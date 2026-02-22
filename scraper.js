const puppeteer = require('puppeteer');
const fs = require('fs');
const path = require('path');

const BASE_URL = 'https://login.teamwork.sg';
const CREDENTIALS = {
    client_id: 'YY244',
    username: 'accountingtang',
    password: 'Pass@123'
};

const OUTPUT_DIR = path.join(__dirname, 'scraped_pages');

async function ensureDir(dir) {
    if (!fs.existsSync(dir)) {
        fs.mkdirSync(dir, { recursive: true });
    }
}

async function savePage(page, name) {
    const html = await page.content();
    const filePath = path.join(OUTPUT_DIR, `${name}.html`);
    fs.writeFileSync(filePath, html, 'utf8');
    console.log(`  Saved: ${filePath}`);
    
    // Also take screenshot
    const screenshotPath = path.join(OUTPUT_DIR, 'screenshots', `${name}.png`);
    await ensureDir(path.join(OUTPUT_DIR, 'screenshots'));
    await page.screenshot({ path: screenshotPath, fullPage: true });
    console.log(`  Screenshot: ${screenshotPath}`);
    
    return html;
}

async function getAllLinks(page) {
    return await page.evaluate(() => {
        const links = new Set();
        document.querySelectorAll('a[href]').forEach(a => {
            const href = a.getAttribute('href');
            if (href && !href.startsWith('#') && !href.startsWith('javascript:') && !href.startsWith('mailto:')) {
                links.add(href);
            }
        });
        // Also check sidebar menu links
        document.querySelectorAll('.side-menu a[href], .child_menu a[href]').forEach(a => {
            const href = a.getAttribute('href');
            if (href) links.add(href);
        });
        return Array.from(links);
    });
}

async function getMenuStructure(page) {
    return await page.evaluate(() => {
        const menu = [];
        document.querySelectorAll('.side-menu > li').forEach(li => {
            const mainLink = li.querySelector('a');
            const item = {
                text: mainLink ? mainLink.textContent.trim() : '',
                href: mainLink ? mainLink.getAttribute('href') : '',
                children: []
            };
            li.querySelectorAll('.child_menu > li > a').forEach(childA => {
                item.children.push({
                    text: childA.textContent.trim(),
                    href: childA.getAttribute('href') || ''
                });
            });
            if (item.text) menu.push(item);
        });
        return menu;
    });
}

async function main() {
    await ensureDir(OUTPUT_DIR);
    
    console.log('=== Corporate Secretarial System Scraper ===\n');
    console.log('Launching browser...');
    
    const browser = await puppeteer.launch({
        headless: 'new',
        args: [
            '--no-sandbox',
            '--disable-setuid-sandbox',
            '--disable-web-security',
            '--window-size=1920,1080'
        ]
    });
    
    const page = await browser.newPage();
    await page.setViewport({ width: 1920, height: 1080 });
    await page.setUserAgent('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
    
    try {
        // Step 1: Navigate to login page
        console.log('\n[1] Loading login page...');
        await page.goto(BASE_URL, { waitUntil: 'networkidle2', timeout: 30000 });
        await savePage(page, '00_login_page');
        
        // Step 2: Fill in credentials and login
        console.log('\n[2] Filling login form...');
        
        // Fill Company ID
        await page.waitForSelector('input[name="client_id"]');
        await page.type('input[name="client_id"]', CREDENTIALS.client_id, { delay: 50 });
        
        // Fill Username
        await page.type('input[name="uname"]', CREDENTIALS.username, { delay: 50 });
        
        // Fill Password
        await page.type('input[name="upsd"]', CREDENTIALS.password, { delay: 50 });
        
        console.log('  Credentials filled. Clicking login...');
        
        // Wait a moment for reCAPTCHA to be ready
        await new Promise(r => setTimeout(r, 2000));
        
        // Click the login button (which triggers reCAPTCHA then submits)
        await page.click('#target_submit_btn');
        
        // Wait for navigation after login
        console.log('  Waiting for login response...');
        await page.waitForNavigation({ waitUntil: 'networkidle2', timeout: 30000 }).catch(() => {
            console.log('  Navigation timeout - checking current state...');
        });
        
        // Check if login was successful
        const currentUrl = page.url();
        console.log(`  Current URL: ${currentUrl}`);
        
        const pageTitle = await page.title();
        console.log(`  Page title: ${pageTitle}`);
        
        // Check for error messages
        const errorMsg = await page.evaluate(() => {
            const errEl = document.querySelector('.text-danger strong, .msg-error, .alert-danger');
            return errEl ? errEl.textContent.trim() : '';
        });
        
        if (errorMsg) {
            console.log(`  Login error: ${errorMsg}`);
        }
        
        // Check if we're still on login page or moved to dashboard
        const isLoggedIn = await page.evaluate(() => {
            // If there's a sidebar menu, we're logged in
            return !!document.querySelector('.side-menu, .nav-sm, .main_container, .left_col');
        });
        
        if (!isLoggedIn) {
            console.log('\n  Still on login page. Let me wait for reCAPTCHA and retry...');
            
            // Wait longer for reCAPTCHA v3 to complete
            await new Promise(r => setTimeout(r, 5000));
            
            // Try clicking again
            await page.click('#target_submit_btn');
            await page.waitForNavigation({ waitUntil: 'networkidle2', timeout: 30000 }).catch(() => {});
            
            const newUrl = page.url();
            console.log(`  URL after retry: ${newUrl}`);
        }
        
        // Save post-login page
        await savePage(page, '01_after_login');
        
        // Step 3: Get menu structure
        console.log('\n[3] Extracting menu structure...');
        const menuStructure = await getMenuStructure(page);
        fs.writeFileSync(
            path.join(OUTPUT_DIR, 'menu_structure.json'),
            JSON.stringify(menuStructure, null, 2)
        );
        console.log(`  Found ${menuStructure.length} menu items`);
        menuStructure.forEach(item => {
            console.log(`    - ${item.text} (${item.href})`);
            item.children.forEach(child => {
                console.log(`      - ${child.text} (${child.href})`);
            });
        });
        
        // Step 4: Get all links
        console.log('\n[4] Collecting all page links...');
        const allLinks = await getAllLinks(page);
        fs.writeFileSync(
            path.join(OUTPUT_DIR, 'all_links.json'),
            JSON.stringify(allLinks, null, 2)
        );
        console.log(`  Found ${allLinks.length} links`);
        
        // Step 5: Visit each internal link and save
        console.log('\n[5] Scraping all internal pages...');
        const visited = new Set();
        const pagesToVisit = allLinks.filter(link => {
            return link.startsWith('/') || link.startsWith(BASE_URL);
        });
        
        let pageIndex = 2;
        for (const link of pagesToVisit) {
            const fullUrl = link.startsWith('/') ? `${BASE_URL}${link}` : link;
            
            if (visited.has(fullUrl)) continue;
            if (fullUrl.includes('logout') || fullUrl.includes('delete') || fullUrl.includes('remove')) continue;
            
            visited.add(fullUrl);
            
            try {
                console.log(`\n  Visiting: ${fullUrl}`);
                await page.goto(fullUrl, { waitUntil: 'networkidle2', timeout: 15000 });
                
                // Create safe filename from URL
                const safeName = fullUrl
                    .replace(BASE_URL, '')
                    .replace(/[^a-zA-Z0-9]/g, '_')
                    .replace(/_+/g, '_')
                    .substring(0, 100) || 'index';
                
                await savePage(page, `${String(pageIndex).padStart(2, '0')}_${safeName}`);
                
                // Get any new links from this page
                const newLinks = await getAllLinks(page);
                for (const newLink of newLinks) {
                    const newFullUrl = newLink.startsWith('/') ? `${BASE_URL}${newLink}` : newLink;
                    if (!visited.has(newFullUrl) && (newLink.startsWith('/') || newLink.startsWith(BASE_URL))) {
                        if (!newFullUrl.includes('logout') && !newFullUrl.includes('delete')) {
                            pagesToVisit.push(newLink);
                        }
                    }
                }
                
                pageIndex++;
            } catch (err) {
                console.log(`  Error visiting ${fullUrl}: ${err.message}`);
            }
        }
        
        // Step 6: Extract JavaScript files
        console.log('\n[6] Extracting JS/CSS resources...');
        const resources = await page.evaluate(() => {
            const res = { scripts: [], styles: [] };
            document.querySelectorAll('script[src]').forEach(s => res.scripts.push(s.src));
            document.querySelectorAll('link[rel="stylesheet"]').forEach(l => res.styles.push(l.href));
            return res;
        });
        fs.writeFileSync(
            path.join(OUTPUT_DIR, 'resources.json'),
            JSON.stringify(resources, null, 2)
        );
        console.log(`  Scripts: ${resources.scripts.length}`);
        console.log(`  Stylesheets: ${resources.styles.length}`);
        
        console.log('\n=== Scraping complete! ===');
        console.log(`Output directory: ${OUTPUT_DIR}`);
        console.log(`Total pages saved: ${pageIndex}`);
        
    } catch (error) {
        console.error('Error:', error.message);
        await savePage(page, 'error_page');
    } finally {
        await browser.close();
    }
}

main().catch(console.error);
