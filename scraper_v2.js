const puppeteer = require('puppeteer');
const fs = require('fs');
const path = require('path');
const https = require('https');
const http = require('http');
const { URL } = require('url');

const BASE_URL = 'https://login.teamwork.sg';
const CREDENTIALS = {
    client_id: 'YY244',
    username: 'accountingtang',
    password: 'Pass@123'
};

const OUTPUT_DIR = path.join(__dirname, 'scraped_pages');
const ASSETS_DIR = path.join(__dirname, 'scraped_assets');

function ensureDir(dir) {
    if (!fs.existsSync(dir)) fs.mkdirSync(dir, { recursive: true });
}

function downloadFile(url, destPath) {
    return new Promise((resolve, reject) => {
        const client = url.startsWith('https') ? https : http;
        const req = client.get(url, { timeout: 10000 }, (res) => {
            if (res.statusCode === 301 || res.statusCode === 302) {
                return downloadFile(res.headers.location, destPath).then(resolve).catch(reject);
            }
            const ws = fs.createWriteStream(destPath);
            res.pipe(ws);
            ws.on('finish', () => { ws.close(); resolve(true); });
            ws.on('error', reject);
        });
        req.on('error', () => resolve(false));
        req.on('timeout', () => { req.destroy(); resolve(false); });
    });
}

// Deduplicate similar URLs (e.g., /edit_agm/123, /edit_agm/456 -> keep only one)
function getUrlPattern(url) {
    return url.replace(/\/\d+$/g, '/{id}').replace(/\/\d+\//g, '/{id}/').replace(/\?.*$/, '');
}

async function main() {
    ensureDir(OUTPUT_DIR);
    ensureDir(ASSETS_DIR);
    ensureDir(path.join(ASSETS_DIR, 'css'));
    ensureDir(path.join(ASSETS_DIR, 'js'));
    ensureDir(path.join(ASSETS_DIR, 'images'));
    ensureDir(path.join(OUTPUT_DIR, 'screenshots'));

    console.log('=== Corporate Secretarial System - Deep Scraper v2 ===\n');

    const browser = await puppeteer.launch({
        headless: 'new',
        args: ['--no-sandbox', '--disable-setuid-sandbox', '--window-size=1920,1080'],
        protocolTimeout: 60000,
    });

    let page = await browser.newPage();
    await page.setViewport({ width: 1920, height: 1080 });
    await page.setUserAgent('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');

    // Track network requests to find AJAX API endpoints
    const apiEndpoints = new Set();
    page.on('response', async (response) => {
        const url = response.url();
        const contentType = response.headers()['content-type'] || '';
        if (contentType.includes('json') && url.includes('login.teamwork.sg')) {
            apiEndpoints.add(url);
        }
    });

    try {
        // === LOGIN ===
        console.log('[1] Logging in...');
        await page.goto(BASE_URL, { waitUntil: 'networkidle2', timeout: 30000 });
        await page.type('input[name="client_id"]', CREDENTIALS.client_id, { delay: 30 });
        await page.type('input[name="uname"]', CREDENTIALS.username, { delay: 30 });
        await page.type('input[name="upsd"]', CREDENTIALS.password, { delay: 30 });
        await new Promise(r => setTimeout(r, 2000));
        await page.click('#target_submit_btn');
        await page.waitForNavigation({ waitUntil: 'networkidle2', timeout: 30000 });
        
        const currentUrl = page.url();
        console.log(`  Logged in! Current URL: ${currentUrl}`);

        // === COLLECT ALL MENU LINKS ===
        console.log('\n[2] Collecting menu links...');
        const menuLinks = await page.evaluate(() => {
            const links = [];
            document.querySelectorAll('.side-menu a[href], .child_menu a[href]').forEach(a => {
                const href = a.getAttribute('href');
                const text = a.textContent.trim();
                if (href && href !== '#' && !href.startsWith('javascript:')) {
                    links.push({ href, text });
                }
            });
            return links;
        });
        console.log(`  Found ${menuLinks.length} menu links`);

        // === COLLECT ALL PAGE LINKS (including ones from content area) ===
        const allPageLinks = await page.evaluate((baseUrl) => {
            const links = new Set();
            document.querySelectorAll('a[href]').forEach(a => {
                let href = a.getAttribute('href');
                if (href && !href.startsWith('#') && !href.startsWith('javascript:') && !href.startsWith('mailto:')) {
                    if (href.startsWith('/')) href = baseUrl + href;
                    if (href.includes('login.teamwork.sg') && !href.includes('logout') && !href.includes('delete') && !href.includes('remove')) {
                        links.add(href);
                    }
                }
            });
            return Array.from(links);
        }, BASE_URL);

        // Build unique page set (deduplicate by pattern)
        const visitedPatterns = new Set();
        const pagesToVisit = [];
        
        // Add menu links first (highest priority)
        for (const link of menuLinks) {
            let url = link.href;
            if (url.startsWith('/')) url = BASE_URL + url;
            const pattern = getUrlPattern(url);
            if (!visitedPatterns.has(pattern)) {
                visitedPatterns.add(pattern);
                pagesToVisit.push({ url, name: link.text });
            }
        }
        
        // Add other content links
        for (const url of allPageLinks) {
            const pattern = getUrlPattern(url);
            if (!visitedPatterns.has(pattern)) {
                visitedPatterns.add(pattern);
                pagesToVisit.push({ url, name: '' });
            }
        }

        console.log(`  Unique pages to visit: ${pagesToVisit.length}`);

        // === SCRAPE EACH PAGE ===
        console.log('\n[3] Scraping all unique pages...');
        let idx = 0;
        const allResources = { scripts: new Set(), styles: new Set(), images: new Set() };
        
        for (const pageInfo of pagesToVisit) {
            idx++;
            const safeName = pageInfo.url
                .replace(BASE_URL, '')
                .replace(/[^a-zA-Z0-9_-]/g, '_')
                .replace(/_+/g, '_')
                .substring(0, 120) || 'index';
            const fileName = `${String(idx).padStart(3, '0')}_${safeName}`;
            
            try {
                // Create a new page if previous one crashed
                if (page.isClosed()) {
                    page = await browser.newPage();
                    await page.setViewport({ width: 1920, height: 1080 });
                    await page.setUserAgent('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36');
                    
                    // Re-login by going to dashboard with cookies
                    const cookies = await browser.cookies();
                    if (cookies.length) await page.setCookie(...cookies);
                }

                console.log(`  [${idx}/${pagesToVisit.length}] ${pageInfo.url}`);
                await page.goto(pageInfo.url, { waitUntil: 'networkidle2', timeout: 20000 });
                
                // Check if redirected to login page
                if (page.url().includes('/welcome') || page.url() === BASE_URL + '/') {
                    console.log('    Session expired, re-logging in...');
                    await page.type('input[name="client_id"]', CREDENTIALS.client_id, { delay: 20 });
                    await page.type('input[name="uname"]', CREDENTIALS.username, { delay: 20 });
                    await page.type('input[name="upsd"]', CREDENTIALS.password, { delay: 20 });
                    await new Promise(r => setTimeout(r, 2000));
                    await page.click('#target_submit_btn');
                    await page.waitForNavigation({ waitUntil: 'networkidle2', timeout: 30000 });
                    // Retry the original page
                    await page.goto(pageInfo.url, { waitUntil: 'networkidle2', timeout: 20000 });
                }

                // Save HTML
                const html = await page.content();
                fs.writeFileSync(path.join(OUTPUT_DIR, `${fileName}.html`), html, 'utf8');

                // Screenshot
                await page.screenshot({
                    path: path.join(OUTPUT_DIR, 'screenshots', `${fileName}.png`),
                    fullPage: true
                });

                // Collect resources
                const res = await page.evaluate(() => {
                    const r = { scripts: [], styles: [], images: [] };
                    document.querySelectorAll('script[src]').forEach(s => r.scripts.push(s.src));
                    document.querySelectorAll('link[rel="stylesheet"]').forEach(l => r.styles.push(l.href));
                    document.querySelectorAll('img[src]').forEach(i => r.images.push(i.src));
                    return r;
                });
                res.scripts.forEach(s => allResources.scripts.add(s));
                res.styles.forEach(s => allResources.styles.add(s));
                res.images.forEach(s => allResources.images.add(s));

                // Discover new unique links from this page
                const newLinks = await page.evaluate((baseUrl) => {
                    const links = [];
                    document.querySelectorAll('a[href]').forEach(a => {
                        let href = a.getAttribute('href');
                        if (href && !href.startsWith('#') && !href.startsWith('javascript:') && !href.startsWith('mailto:')) {
                            if (href.startsWith('/')) href = baseUrl + href;
                            if (href.includes('login.teamwork.sg') && !href.includes('logout') && !href.includes('delete') && !href.includes('remove')) {
                                links.push(href);
                            }
                        }
                    });
                    return links;
                }, BASE_URL);

                for (const newUrl of newLinks) {
                    const pattern = getUrlPattern(newUrl);
                    if (!visitedPatterns.has(pattern)) {
                        visitedPatterns.add(pattern);
                        pagesToVisit.push({ url: newUrl, name: '' });
                    }
                }

                // Extract form structures (important for understanding functionality)
                const forms = await page.evaluate(() => {
                    const formData = [];
                    document.querySelectorAll('form').forEach(form => {
                        const fields = [];
                        form.querySelectorAll('input, select, textarea').forEach(field => {
                            fields.push({
                                tag: field.tagName.toLowerCase(),
                                type: field.type || '',
                                name: field.name || '',
                                id: field.id || '',
                                placeholder: field.placeholder || '',
                                className: field.className || '',
                                required: field.required || false,
                            });
                        });
                        formData.push({
                            action: form.action || '',
                            method: form.method || '',
                            id: form.id || '',
                            fields
                        });
                    });
                    return formData;
                });

                if (forms.length > 0) {
                    fs.writeFileSync(
                        path.join(OUTPUT_DIR, `${fileName}_forms.json`),
                        JSON.stringify(forms, null, 2)
                    );
                }

                // Extract DataTable structures (column headers)
                const tables = await page.evaluate(() => {
                    const tableData = [];
                    document.querySelectorAll('table').forEach(table => {
                        const headers = [];
                        table.querySelectorAll('thead th, thead td').forEach(th => {
                            headers.push(th.textContent.trim());
                        });
                        if (headers.length > 0) {
                            tableData.push({
                                id: table.id || '',
                                className: table.className || '',
                                headers
                            });
                        }
                    });
                    return tableData;
                });

                if (tables.length > 0) {
                    fs.writeFileSync(
                        path.join(OUTPUT_DIR, `${fileName}_tables.json`),
                        JSON.stringify(tables, null, 2)
                    );
                }

            } catch (err) {
                console.log(`    Error: ${err.message}`);
                // Try to recover
                try {
                    if (page.isClosed()) {
                        page = await browser.newPage();
                        await page.setViewport({ width: 1920, height: 1080 });
                    }
                } catch (e) {}
            }
        }

        // === DOWNLOAD ASSETS ===
        console.log('\n[4] Downloading CSS/JS/Image assets...');
        
        const cssFiles = Array.from(allResources.styles).filter(u => u.includes('login.teamwork.sg'));
        const jsFiles = Array.from(allResources.scripts).filter(u => u.includes('login.teamwork.sg'));
        const imgFiles = Array.from(allResources.images).filter(u => u.includes('login.teamwork.sg'));

        console.log(`  CSS files: ${cssFiles.length}`);
        console.log(`  JS files: ${jsFiles.length}`);
        console.log(`  Images: ${imgFiles.length}`);

        for (const cssUrl of cssFiles) {
            try {
                const urlObj = new URL(cssUrl);
                const filePath = path.join(ASSETS_DIR, 'css', path.basename(urlObj.pathname));
                await downloadFile(cssUrl, filePath);
                console.log(`  Downloaded CSS: ${path.basename(urlObj.pathname)}`);
            } catch (e) {}
        }

        for (const jsUrl of jsFiles) {
            try {
                const urlObj = new URL(jsUrl);
                const filePath = path.join(ASSETS_DIR, 'js', path.basename(urlObj.pathname));
                await downloadFile(jsUrl, filePath);
                console.log(`  Downloaded JS: ${path.basename(urlObj.pathname)}`);
            } catch (e) {}
        }

        for (const imgUrl of imgFiles) {
            try {
                const urlObj = new URL(imgUrl);
                const filePath = path.join(ASSETS_DIR, 'images', path.basename(urlObj.pathname));
                await downloadFile(imgUrl, filePath);
                console.log(`  Downloaded Image: ${path.basename(urlObj.pathname)}`);
            } catch (e) {}
        }

        // Save API endpoints found
        fs.writeFileSync(
            path.join(OUTPUT_DIR, 'api_endpoints.json'),
            JSON.stringify(Array.from(apiEndpoints), null, 2)
        );

        // Save all resource URLs
        fs.writeFileSync(
            path.join(OUTPUT_DIR, 'all_resources.json'),
            JSON.stringify({
                scripts: Array.from(allResources.scripts),
                styles: Array.from(allResources.styles),
                images: Array.from(allResources.images)
            }, null, 2)
        );

        console.log(`\n=== COMPLETE ===`);
        console.log(`Pages scraped: ${idx}`);
        console.log(`API endpoints found: ${apiEndpoints.size}`);
        console.log(`Output: ${OUTPUT_DIR}`);
        console.log(`Assets: ${ASSETS_DIR}`);

    } catch (error) {
        console.error('Fatal error:', error.message);
    } finally {
        await browser.close();
    }
}

main().catch(console.error);
