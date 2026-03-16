/**
 * CorpFile Browser Service
 * 
 * Headless Chromium microservice exposing browser automation as REST API.
 * Called by PHP backend when Claude AI requests browser tools.
 * 
 * Architecture:
 *   PHP (AiBridge) → HTTP → this service → Puppeteer → Chromium
 */

const fastify = require('fastify')({ 
  logger: true,
  bodyLimit: 10 * 1024 * 1024 // 10MB for screenshot responses
});

const { BrowserPool } = require('./lib/browser-pool');
const { validateUrl } = require('./lib/security');
const { executeAction } = require('./lib/actions');

// ── Config ──────────────────────────────────────────────────────
const PORT = parseInt(process.env.BROWSER_SERVICE_PORT || '3100', 10);
const MAX_CONCURRENT = parseInt(process.env.MAX_CONCURRENT || '3', 10);
const ACTION_TIMEOUT = parseInt(process.env.ACTION_TIMEOUT || '30000', 10);
const API_KEY = process.env.BROWSER_SERVICE_KEY || '';

// ── Browser Pool ────────────────────────────────────────────────
let pool;

// ── Auth middleware ─────────────────────────────────────────────
fastify.addHook('onRequest', async (request, reply) => {
  // Skip auth for health check
  if (request.url === '/health') return;
  
  if (API_KEY && request.headers['x-api-key'] !== API_KEY) {
    reply.code(401).send({ ok: false, error: 'Unauthorized' });
  }
});

// ── Health check ────────────────────────────────────────────────
fastify.get('/health', async () => {
  return { 
    ok: true, 
    service: 'corpfile-browser',
    pool: pool ? pool.stats() : null,
    uptime: process.uptime()
  };
});

// ── Single tool execution ───────────────────────────────────────
fastify.post('/api/tool', {
  schema: {
    body: {
      type: 'object',
      required: ['action'],
      properties: {
        action: { type: 'string' },
        params: { type: 'object', default: {} },
        session_id: { type: 'string' }
      }
    }
  }
}, async (request, reply) => {
  const { action, params, session_id } = request.body;
  const startTime = Date.now();

  try {
    // URL validation for navigation actions
    if (params.url) {
      validateUrl(params.url);
    }

    const result = await pool.execute(action, params, {
      sessionId: session_id || null,
      timeout: Math.min(params.timeout || ACTION_TIMEOUT, 60000)
    });

    return {
      ok: true,
      action,
      result,
      duration_ms: Date.now() - startTime
    };

  } catch (err) {
    request.log.error({ err, action, params }, 'Tool execution failed');
    reply.code(500).send({
      ok: false,
      error: err.message,
      action,
      duration_ms: Date.now() - startTime
    });
  }
});

// ── Batch tool execution (for parallel tool calls) ──────────────
fastify.post('/api/tools', {
  schema: {
    body: {
      type: 'object',
      required: ['tools'],
      properties: {
        tools: {
          type: 'array',
          items: {
            type: 'object',
            required: ['action'],
            properties: {
              id: { type: 'string' },
              action: { type: 'string' },
              params: { type: 'object', default: {} }
            }
          }
        },
        session_id: { type: 'string' }
      }
    }
  }
}, async (request, reply) => {
  const { tools, session_id } = request.body;
  const startTime = Date.now();
  
  const results = [];
  for (const tool of tools) {
    try {
      if (tool.params?.url) validateUrl(tool.params.url);
      
      const result = await pool.execute(tool.action, tool.params || {}, {
        sessionId: session_id || null,
        timeout: Math.min(tool.params?.timeout || ACTION_TIMEOUT, 60000)
      });
      
      results.push({ id: tool.id, ok: true, action: tool.action, result });
    } catch (err) {
      results.push({ id: tool.id, ok: false, action: tool.action, error: err.message });
    }
  }

  return {
    ok: true,
    results,
    duration_ms: Date.now() - startTime
  };
});

// ── Session management ──────────────────────────────────────────
fastify.delete('/api/session/:id', async (request) => {
  const { id } = request.params;
  if (pool) {
    await pool.destroySession(id);
  }
  return { ok: true, session_id: id };
});

// ── Start server ────────────────────────────────────────────────
async function start() {
  try {
    pool = new BrowserPool({
      maxConcurrent: MAX_CONCURRENT,
      actionTimeout: ACTION_TIMEOUT,
      launchOptions: {
        headless: 'new',
        args: [
          '--no-sandbox',
          '--disable-setuid-sandbox',
          '--disable-dev-shm-usage',
          '--disable-gpu',
          '--disable-extensions',
          '--disable-background-networking',
          '--disable-default-apps',
          '--disable-sync',
          '--disable-translate',
          '--no-first-run',
          '--mute-audio',
          '--hide-scrollbars',
        ],
        // Use system Chromium in Docker
        ...(process.env.PUPPETEER_EXECUTABLE_PATH ? {
          executablePath: process.env.PUPPETEER_EXECUTABLE_PATH
        } : {})
      }
    });

    await pool.init();
    await fastify.listen({ port: PORT, host: '0.0.0.0' });
    fastify.log.info(`Browser service ready on port ${PORT} (max ${MAX_CONCURRENT} concurrent)`);
  } catch (err) {
    fastify.log.error(err);
    process.exit(1);
  }
}

// Graceful shutdown
async function shutdown() {
  fastify.log.info('Shutting down browser service...');
  if (pool) await pool.destroy();
  await fastify.close();
  process.exit(0);
}

process.on('SIGINT', shutdown);
process.on('SIGTERM', shutdown);

start();
