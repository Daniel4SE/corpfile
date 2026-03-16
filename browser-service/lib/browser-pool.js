const puppeteer = require('puppeteer');
const { executeAction } = require('./actions');

class BrowserPool {
  constructor(options = {}) {
    this.maxConcurrent = options.maxConcurrent || 3;
    this.actionTimeout = options.actionTimeout || 30000;
    this.launchOptions = options.launchOptions || {};
    this.sessions = new Map();
    this.browser = null;
    this.activePages = 0;
  }

  async init() {
    this.browser = await puppeteer.launch(this.launchOptions);
    this.browser.on('disconnected', () => {
      console.error('Browser disconnected — will relaunch on next request');
      this.browser = null;
    });
  }

  async ensureBrowser() {
    if (!this.browser || !this.browser.connected) {
      this.browser = await puppeteer.launch(this.launchOptions);
    }
    return this.browser;
  }

  async execute(action, params, options = {}) {
    if (this.activePages >= this.maxConcurrent) {
      throw new Error(`Concurrency limit reached (${this.maxConcurrent})`);
    }

    const browser = await this.ensureBrowser();
    const sessionId = options.sessionId;
    const timeout = options.timeout || this.actionTimeout;

    let page;
    let isSessionPage = false;

    if (sessionId && this.sessions.has(sessionId)) {
      page = this.sessions.get(sessionId);
      if (page.isClosed()) {
        this.sessions.delete(sessionId);
        page = null;
      } else {
        isSessionPage = true;
      }
    }

    if (!page) {
      page = await browser.newPage();
      await page.setViewport({ width: 1280, height: 800 });
      await page.setUserAgent(
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
      );

      if (sessionId) {
        this.sessions.set(sessionId, page);
        isSessionPage = true;
      }
    }

    this.activePages++;

    try {
      const result = await Promise.race([
        executeAction(page, action, params),
        new Promise((_, reject) =>
          setTimeout(() => reject(new Error(`Action timed out after ${timeout}ms`)), timeout)
        )
      ]);

      return result;
    } finally {
      this.activePages--;
      if (!isSessionPage && !page.isClosed()) {
        await page.close().catch(() => {});
      }
    }
  }

  async destroySession(sessionId) {
    const page = this.sessions.get(sessionId);
    if (page && !page.isClosed()) {
      await page.close().catch(() => {});
    }
    this.sessions.delete(sessionId);
  }

  stats() {
    return {
      active: this.activePages,
      max: this.maxConcurrent,
      sessions: this.sessions.size,
      connected: this.browser?.connected ?? false
    };
  }

  async destroy() {
    for (const [id, page] of this.sessions) {
      if (!page.isClosed()) await page.close().catch(() => {});
    }
    this.sessions.clear();
    if (this.browser) await this.browser.close().catch(() => {});
  }
}

module.exports = { BrowserPool };
