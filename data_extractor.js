const puppeteer = require('puppeteer');
const fs = require('fs');
const path = require('path');

const BASE_URL = 'https://login.teamwork.sg';
const CREDENTIALS = {
    client_id: 'YY244',
    username: 'accountingtang',
    password: 'Pass@123'
};

const OUTPUT_DIR = path.join(__dirname, 'extracted_data');

function ensureDir(dir) {
    if (!fs.existsSync(dir)) fs.mkdirSync(dir, { recursive: true });
}

// Pages with DataTables to extract data from
// Format: { url, name, description }
const DATA_PAGES = [
    // === Core Business Data ===
    { url: '/company_list', name: 'companies', desc: 'All companies' },
    { url: '/pre_company', name: 'pre_companies', desc: 'Pre-incorporation companies' },
    { url: '/post_company', name: 'post_companies', desc: 'Post-incorporation companies' },
    { url: '/member', name: 'members', desc: 'All members/individuals' },
    { url: '/Company_officials/company_officials_list', name: 'company_officials', desc: 'Company officials overview' },
    { url: '/corporate_shareholder/corp_share_comp_list', name: 'corporate_shareholders', desc: 'Corporate shareholders' },

    // === Events & Compliance ===
    { url: '/company_agm/company_agm_list', name: 'agm_list', desc: 'AGM listing by company' },
    { url: '/duedatetracker', name: 'due_dates', desc: 'Due date tracker' },

    // === Finance ===
    { url: '/mainadmin/company_bank', name: 'company_banks', desc: 'Company bank accounts' },
    { url: '/Sealings/sealings_list', name: 'sealings', desc: 'Company sealings' },
    { url: '/Sealings/reg_address_list', name: 'registered_addresses', desc: 'Registered addresses' },
    { url: '/settings/register_charge_list', name: 'register_charges', desc: 'Register of charges' },

    // === Documents ===
    { url: '/alldocuments', name: 'documents', desc: 'All documents' },
    { url: '/company_file', name: 'templates', desc: 'Document templates' },
    { url: '/esign_manage', name: 'esign', desc: 'E-Sign documents' },

    // === Reports (Registers) ===
    { url: '/report_module/register_of_director_list', name: 'reg_directors', desc: 'Register of directors' },
    { url: '/report_module/register_of_member_list', name: 'reg_members', desc: 'Register of members' },
    { url: '/report_module/register_of_owner_list', name: 'reg_owners', desc: 'Register of owners' },
    { url: '/report_module/register_of_secretaries_list', name: 'reg_secretaries', desc: 'Register of secretaries' },
    { url: '/report_module/register_of_auditors_list', name: 'reg_auditors', desc: 'Register of auditors' },
    { url: '/report_module/register_of_managers_list', name: 'reg_managers', desc: 'Register of managers' },
    { url: '/report_module/register_of_ceo_list', name: 'reg_ceos', desc: 'Register of CEOs' },
    { url: '/report_module/register_of_shares_allotment_list', name: 'reg_shares_allotment', desc: 'Register of shares allotment' },
    { url: '/report_module/register_of_shares_transfers_list', name: 'reg_shares_transfers', desc: 'Register of shares transfers' },
    { url: '/report_module/register_of_charges_list', name: 'reg_charges', desc: 'Register of charges' },
    { url: '/report_module/register_of_sealings_list', name: 'reg_sealings', desc: 'Register of sealings' },
    { url: '/report_module/register_of_controllers_list', name: 'reg_controllers', desc: 'Register of controllers' },
    { url: '/report_module/register_of_nominee_list', name: 'reg_nominees', desc: 'Register of nominees' },
    { url: '/report_module/register_of_representative_list', name: 'reg_representatives', desc: 'Register of representatives' },
    { url: '/report_module/register_of_data_protection_list', name: 'reg_data_protection', desc: 'Register of data protection' },
    { url: '/report_module/register_of_fund_manger_list', name: 'reg_fund_managers', desc: 'Register of fund managers' },
    { url: '/report_module/register_of_directors_shareholding_list', name: 'reg_directors_shareholding', desc: 'Register of directors shareholding' },
    { url: '/report_module/register_of_ceo_shareholding_list', name: 'reg_ceo_shareholding', desc: 'Register of CEO shareholding' },

    // === Admin / Settings ===
    { url: '/alladmin', name: 'users', desc: 'All admin users' },
    { url: '/user_groups', name: 'user_groups', desc: 'User groups' },
    { url: '/settings/company_type', name: 'company_types', desc: 'Company types' },
    { url: '/settings/branch_master', name: 'branches', desc: 'Branch master' },
    { url: '/settings/member_id_type_list', name: 'id_types', desc: 'Member ID types' },
    { url: '/settings/event_name_list', name: 'event_names', desc: 'Event name settings' },
    { url: '/settings/fee_type_list', name: 'fee_types', desc: 'Fee types' },
    { url: '/settings/document_category', name: 'doc_categories', desc: 'Document categories' },
    { url: '/settings/email_template_list', name: 'email_templates', desc: 'Email templates' },
    { url: '/settings/payment_mode', name: 'payment_modes', desc: 'Payment modes' },
    { url: '/settings/shares_class_type_list', name: 'share_class_types', desc: 'Share class types' },
    { url: '/settings/register_footer_list', name: 'register_footers', desc: 'Register footer settings' },
    { url: '/Remainder/remainder_list', name: 'reminders', desc: 'Reminders' },
    { url: '/settings/event_receiving_parties', name: 'event_receiving_parties', desc: 'Event receiving parties' },

    // === CRM ===
    { url: '/leads_listing', name: 'crm_leads', desc: 'CRM Leads' },
    { url: '/leads_quotations', name: 'crm_quotations', desc: 'CRM Quotations' },
    { url: '/orders_listing', name: 'crm_orders', desc: 'CRM Orders' },
    { url: '/twcrm_projects', name: 'crm_projects', desc: 'CRM Projects' },
    { url: '/tasks', name: 'crm_tasks', desc: 'CRM Tasks' },
    { url: '/activities', name: 'crm_activities', desc: 'CRM Activities' },
    { url: '/timesheet', name: 'crm_timesheets', desc: 'CRM Timesheets' },
    { url: '/clientsupport_ticket', name: 'crm_tickets', desc: 'Support Tickets' },
];

/**
 * Extract ALL rows from ALL DataTables on a page.
 * Handles server-side pagination by clicking "next" until exhausted.
 */
async function extractAllTableData(page) {
    return await page.evaluate(() => {
        const results = [];

        // Find all DataTable instances or regular tables with data
        const tables = document.querySelectorAll('table[id]:not([id=""])');
        
        tables.forEach(table => {
            const id = table.id;
            // Skip calendar tables, date picker tables
            if (!id || id.includes('calendar') || id.includes('ui-datepicker')) return;

            const headers = [];
            table.querySelectorAll('thead th').forEach(th => {
                const text = th.textContent.trim().replace(/\s+/g, ' ');
                if (text) headers.push(text);
            });

            // Skip if no meaningful headers (calendar, date pickers, etc)
            if (headers.length < 2) return;
            if (headers.every(h => ['Sun','Mon','Tue','Wed','Thu','Fri','Sat','Su','Mo','Tu','We','Th','Fr','Sa'].includes(h))) return;

            const rows = [];
            table.querySelectorAll('tbody tr').forEach(tr => {
                // Skip empty/no-data rows
                if (tr.querySelector('.dataTables_empty')) return;
                if (tr.classList.contains('odd') === false && tr.classList.contains('even') === false && tr.children.length < 2) return;

                const cells = [];
                tr.querySelectorAll('td').forEach(td => {
                    // Get text content, but also capture links, images, select values
                    let value = td.textContent.trim().replace(/\s+/g, ' ');
                    
                    // If cell has a link, capture the href too
                    const link = td.querySelector('a[href]');
                    if (link && link.href && !link.href.includes('javascript:')) {
                        const href = link.getAttribute('href');
                        if (href && href !== '#') {
                            value = { text: value, href: href };
                        }
                    }
                    
                    // If cell has an image, capture src
                    const img = td.querySelector('img[src]');
                    if (img) {
                        value = { text: value, img: img.src };
                    }

                    // If cell has a select, capture selected value
                    const select = td.querySelector('select');
                    if (select) {
                        value = select.options[select.selectedIndex]?.text || value;
                    }

                    cells.push(value);
                });

                if (cells.length > 0) {
                    rows.push(cells);
                }
            });

            if (rows.length > 0 || headers.length > 2) {
                results.push({ tableId: id, headers, rows, rowCount: rows.length });
            }
        });

        // Also try to get DataTable info (total records)
        const dtInfo = [];
        document.querySelectorAll('.dataTables_info').forEach(info => {
            dtInfo.push(info.textContent.trim());
        });

        return { tables: results, paginationInfo: dtInfo };
    });
}

/**
 * For DataTables with server-side pagination, extract ALL pages
 */
async function extractWithPagination(page, pageName) {
    let allRows = [];
    let allHeaders = [];
    let tableId = '';
    let pageNum = 0;
    const maxPages = 200; // safety limit

    // First extraction
    let data = await extractAllTableData(page);
    
    if (data.tables.length === 0) return { headers: [], rows: [], tableId: '' };

    // Use the first meaningful table
    const mainTable = data.tables[0];
    tableId = mainTable.tableId;
    allHeaders = mainTable.headers;
    allRows = [...mainTable.rows];

    // Check if there's pagination
    const hasPagination = await page.evaluate(() => {
        const next = document.querySelector('.dataTables_paginate .next:not(.disabled)');
        return !!next;
    });

    if (hasPagination) {
        console.log(`    Paginated table detected, extracting all pages...`);
        
        // First, try to set page length to maximum (show all)
        const canShowAll = await page.evaluate(() => {
            // Look for "show entries" select and set to max
            const selects = document.querySelectorAll('.dataTables_length select');
            for (const sel of selects) {
                const options = Array.from(sel.options);
                const maxOpt = options.find(o => o.value === '-1' || o.text.toLowerCase() === 'all');
                if (maxOpt) {
                    sel.value = maxOpt.value;
                    sel.dispatchEvent(new Event('change'));
                    return true;
                }
                // Otherwise set to highest available
                const highest = options.reduce((max, o) => {
                    const v = parseInt(o.value);
                    return v > max ? v : max;
                }, 0);
                if (highest > 25) {
                    sel.value = String(highest);
                    sel.dispatchEvent(new Event('change'));
                    return true;
                }
            }
            return false;
        });

        if (canShowAll) {
            await new Promise(r => setTimeout(r, 2000));
            // Re-extract after changing page length
            data = await extractAllTableData(page);
            if (data.tables.length > 0) {
                allRows = data.tables[0].rows;
                allHeaders = data.tables[0].headers;
            }
        }

        // If still paginated, click through pages
        let hasNext = await page.evaluate(() => {
            const next = document.querySelector('.dataTables_paginate .next:not(.disabled)');
            return !!next;
        });

        while (hasNext && pageNum < maxPages) {
            pageNum++;
            await page.evaluate(() => {
                const next = document.querySelector('.dataTables_paginate .next:not(.disabled)');
                if (next) next.click();
            });
            await new Promise(r => setTimeout(r, 1500));

            data = await extractAllTableData(page);
            if (data.tables.length > 0) {
                const pageRows = data.tables[0].rows;
                if (pageRows.length === 0) break;
                allRows.push(...pageRows);
                process.stdout.write(`\r    Page ${pageNum + 1}: ${allRows.length} rows total`);
            }

            hasNext = await page.evaluate(() => {
                const next = document.querySelector('.dataTables_paginate .next:not(.disabled)');
                return !!next;
            });
        }
        if (pageNum > 0) console.log('');
    }

    return { tableId, headers: allHeaders, rows: allRows };
}

/**
 * Extract detail data from company view pages (directors, shareholders, etc.)
 */
async function extractCompanyDetails(page, companyLinks) {
    const details = [];
    let idx = 0;
    
    for (const link of companyLinks.slice(0, 100)) { // limit to first 100
        idx++;
        try {
            const url = link.startsWith('/') ? BASE_URL + link : (link.startsWith('http') ? link : BASE_URL + '/' + link);
            console.log(`    Detail [${idx}/${Math.min(companyLinks.length, 100)}] ${url}`);
            
            await page.goto(url, { waitUntil: 'networkidle2', timeout: 20000 });
            
            // Check for session expiry
            if (page.url().includes('/welcome') || page.url() === BASE_URL + '/') {
                console.log('    Session expired during detail extraction, stopping...');
                break;
            }

            const data = await extractAllTableData(page);
            
            // Also extract form field values (for detail/edit pages)
            const formData = await page.evaluate(() => {
                const fields = {};
                document.querySelectorAll('input[name], select[name], textarea[name]').forEach(el => {
                    const name = el.name;
                    if (!name || name.includes('csrf') || name.includes('token')) return;
                    if (el.type === 'hidden' && !el.value) return;
                    
                    if (el.tagName === 'SELECT') {
                        fields[name] = el.options[el.selectedIndex]?.text || el.value;
                    } else if (el.type === 'checkbox' || el.type === 'radio') {
                        if (el.checked) fields[name] = el.value || 'checked';
                    } else {
                        fields[name] = el.value || '';
                    }
                });
                return fields;
            });

            details.push({
                url: url,
                tables: data.tables,
                formData: formData
            });
            
        } catch (err) {
            console.log(`    Error: ${err.message}`);
        }
    }
    
    return details;
}

async function login(page) {
    console.log('[LOGIN] Logging in to teamwork.sg...');
    await page.goto(BASE_URL, { waitUntil: 'networkidle2', timeout: 30000 });
    
    // Clear any existing input values first
    await page.evaluate(() => {
        document.querySelectorAll('input[type="text"], input[type="password"]').forEach(i => i.value = '');
    });
    
    await page.type('input[name="client_id"]', CREDENTIALS.client_id, { delay: 50 });
    await page.type('input[name="uname"]', CREDENTIALS.username, { delay: 50 });
    await page.type('input[name="upsd"]', CREDENTIALS.password, { delay: 50 });
    
    // Wait for reCAPTCHA v3 to load
    await new Promise(r => setTimeout(r, 3000));
    
    // Click the login button (triggers reCAPTCHA then submits)
    await page.click('#target_submit_btn');
    
    // Wait for navigation after reCAPTCHA + form submit
    try {
        await page.waitForNavigation({ waitUntil: 'networkidle2', timeout: 30000 });
    } catch (e) {
        // Sometimes navigation doesn't trigger properly, wait extra
        await new Promise(r => setTimeout(r, 5000));
    }
    
    const url = page.url();
    if (url.includes('dashboard') || (!url.includes('welcome') && !url.endsWith('/'))) {
        console.log(`[LOGIN] Success! URL: ${url}\n`);
        return true;
    }
    
    // Check if there's a sidebar menu (another way to confirm login)
    const hasMenu = await page.evaluate(() => !!document.querySelector('.side-menu, #sidebar-menu'));
    if (hasMenu) {
        console.log(`[LOGIN] Success (menu detected)! URL: ${url}\n`);
        return true;
    }
    
    console.log(`[LOGIN] May have failed. URL: ${url}`);
    return false;
}

async function reloginIfNeeded(page) {
    const url = page.url();
    if (url.includes('/welcome') || url === BASE_URL + '/' || url === BASE_URL) {
        console.log('  [RE-LOGIN] Session expired, re-logging in...');
        return await login(page);
    }
    return true;
}

async function main() {
    ensureDir(OUTPUT_DIR);

    console.log('=== CorpFile Data Extractor ===');
    console.log(`Target: ${BASE_URL}`);
    console.log(`Output: ${OUTPUT_DIR}\n`);

    const browser = await puppeteer.launch({
        headless: false,
        args: ['--no-sandbox', '--disable-setuid-sandbox', '--window-size=1920,1080'],
        protocolTimeout: 120000,
    });

    let page = await browser.newPage();
    await page.setViewport({ width: 1920, height: 1080 });
    await page.setUserAgent('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');

    try {
        // Login
        const loggedIn = await login(page);
        if (!loggedIn) {
            console.error('Failed to login. Exiting.');
            await browser.close();
            return;
        }

        const summary = {};

        // Extract data from each page
        for (let i = 0; i < DATA_PAGES.length; i++) {
            const dp = DATA_PAGES[i];
            const fullUrl = BASE_URL + dp.url;
            console.log(`[${i + 1}/${DATA_PAGES.length}] ${dp.desc} (${dp.url})`);

            try {
                await page.goto(fullUrl, { waitUntil: 'networkidle2', timeout: 25000 });
                
                // Re-login if needed
                if (!await reloginIfNeeded(page)) continue;
                if (page.url().includes('/welcome')) {
                    await page.goto(fullUrl, { waitUntil: 'networkidle2', timeout: 25000 });
                }

                // Wait for DataTable to load
                await new Promise(r => setTimeout(r, 2000));

                // Extract table data with pagination
                const result = await extractWithPagination(page, dp.name);

                // Collect company detail links (view/edit links from Action columns)
                let detailLinks = [];
                if (['companies', 'members'].includes(dp.name)) {
                    detailLinks = await page.evaluate(() => {
                        const links = [];
                        document.querySelectorAll('table tbody a[href*="view_"], table tbody a[href*="edit_"]').forEach(a => {
                            const href = a.getAttribute('href');
                            if (href && !href.includes('delete') && !href.includes('javascript:')) {
                                links.push(href);
                            }
                        });
                        // Deduplicate
                        return [...new Set(links)];
                    });
                }

                const output = {
                    page: dp.name,
                    description: dp.desc,
                    url: dp.url,
                    extractedAt: new Date().toISOString(),
                    tableId: result.tableId,
                    headers: result.headers,
                    totalRows: result.rows.length,
                    rows: result.rows,
                    detailLinks: detailLinks,
                };

                // Save to JSON
                const filePath = path.join(OUTPUT_DIR, `${dp.name}.json`);
                fs.writeFileSync(filePath, JSON.stringify(output, null, 2));
                
                summary[dp.name] = { rows: result.rows.length, headers: result.headers.length };
                console.log(`  => ${result.rows.length} rows, ${result.headers.length} columns\n`);

            } catch (err) {
                console.log(`  ERROR: ${err.message}\n`);
                summary[dp.name] = { error: err.message };
                
                // Try to recover
                try {
                    if (page.isClosed()) {
                        page = await browser.newPage();
                        await page.setViewport({ width: 1920, height: 1080 });
                        await login(page);
                    }
                } catch (e) {}
            }
        }

        // Now extract company detail pages (view individual companies)
        console.log('\n[DETAIL] Extracting company detail pages...');
        const companiesFile = path.join(OUTPUT_DIR, 'companies.json');
        if (fs.existsSync(companiesFile)) {
            const companiesData = JSON.parse(fs.readFileSync(companiesFile, 'utf8'));
            if (companiesData.detailLinks && companiesData.detailLinks.length > 0) {
                // Filter to only view_company links
                const viewLinks = companiesData.detailLinks.filter(l => l.includes('view_company'));
                console.log(`  Found ${viewLinks.length} company detail links`);
                
                const details = await extractCompanyDetails(page, viewLinks);
                const detailPath = path.join(OUTPUT_DIR, 'company_details.json');
                fs.writeFileSync(detailPath, JSON.stringify(details, null, 2));
                console.log(`  Saved ${details.length} company detail records`);
            }
        }

        // Extract member detail pages
        console.log('\n[DETAIL] Extracting member detail pages...');
        const membersFile = path.join(OUTPUT_DIR, 'members.json');
        if (fs.existsSync(membersFile)) {
            const membersData = JSON.parse(fs.readFileSync(membersFile, 'utf8'));
            if (membersData.detailLinks && membersData.detailLinks.length > 0) {
                const viewLinks = membersData.detailLinks.filter(l => l.includes('view_member'));
                console.log(`  Found ${viewLinks.length} member detail links`);
                
                const details = await extractCompanyDetails(page, viewLinks);
                const detailPath = path.join(OUTPUT_DIR, 'member_details.json');
                fs.writeFileSync(detailPath, JSON.stringify(details, null, 2));
                console.log(`  Saved ${details.length} member detail records`);
            }
        }

        // Save summary
        fs.writeFileSync(
            path.join(OUTPUT_DIR, '_summary.json'),
            JSON.stringify(summary, null, 2)
        );

        console.log('\n=== EXTRACTION COMPLETE ===');
        console.log('Summary:');
        let totalRows = 0;
        for (const [name, info] of Object.entries(summary)) {
            if (info.rows !== undefined) {
                console.log(`  ${name}: ${info.rows} rows`);
                totalRows += info.rows;
            } else {
                console.log(`  ${name}: ERROR - ${info.error}`);
            }
        }
        console.log(`\nTotal data rows extracted: ${totalRows}`);
        console.log(`Output directory: ${OUTPUT_DIR}`);

    } catch (error) {
        console.error('Fatal error:', error.message);
    } finally {
        await browser.close();
    }
}

main().catch(console.error);
