const { URL } = require('url');

const BLOCKED_HOSTS = new Set([
  'localhost', '127.0.0.1', '0.0.0.0', '::1',
  'metadata.google.internal', '169.254.169.254',
]);

const PRIVATE_RANGES = [
  /^10\./,
  /^172\.(1[6-9]|2\d|3[01])\./,
  /^192\.168\./,
  /^fc00:/i,
  /^fd/i,
  /^fe80:/i,
];

function validateUrl(urlString) {
  let parsed;
  try {
    parsed = new URL(urlString);
  } catch {
    throw new Error('Invalid URL format');
  }

  if (!['http:', 'https:'].includes(parsed.protocol)) {
    throw new Error('Only HTTP/HTTPS protocols allowed');
  }

  const host = parsed.hostname.toLowerCase();

  if (BLOCKED_HOSTS.has(host)) {
    throw new Error('Access to internal hosts is blocked');
  }

  if (host.endsWith('.local') || host.endsWith('.internal')) {
    throw new Error('Access to internal domains is blocked');
  }

  for (const range of PRIVATE_RANGES) {
    if (range.test(host)) {
      throw new Error('Access to private IP ranges is blocked');
    }
  }

  return true;
}

module.exports = { validateUrl };
