FROM node:20-alpine

RUN apk add --no-cache \
    chromium \
    ca-certificates \
    ttf-freefont \
    harfbuzz \
    nss \
    freetype

ENV PUPPETEER_EXECUTABLE_PATH=/usr/bin/chromium-browser \
    PUPPETEER_SKIP_CHROMIUM_DOWNLOAD=true \
    CHROME_PATH=/usr/bin/chromium-browser \
    NODE_ENV=production

WORKDIR /app

# Railway builds from repo root with RAILWAY_DOCKERFILE_PATH
# so COPY paths are relative to repo root, not browser-service/
COPY browser-service/package*.json ./
RUN npm ci --only=production

COPY browser-service/ .

RUN addgroup -g 1001 -S nodejs && \
    adduser -S nodejs -u 1001
USER nodejs

EXPOSE 3100

HEALTHCHECK --interval=30s --timeout=10s --start-period=10s --retries=3 \
  CMD wget --spider -q http://localhost:3100/health || exit 1

CMD ["node", "server.js"]
