async function executeAction(page, action, params) {
  switch (action) {
    case "navigate":
      return navigate(page, params);
    case "screenshot":
      return screenshot(page, params);
    case "get_content":
      return getContent(page, params);
    case "click":
      return click(page, params);
    case "fill":
      return fill(page, params);
    case "select":
      return selectOption(page, params);
    case "wait_for":
      return waitFor(page, params);
    case "evaluate":
      return evaluate(page, params);
    case "get_links":
      return getLinks(page, params);
    case "get_page_info":
      return getPageInfo(page);
    case "scroll":
      return scroll(page, params);
    case "go_back":
      await page.goBack({ waitUntil: "networkidle2" }).catch(() => null);
      return { url: page.url() };
    case "go_forward":
      await page.goForward({ waitUntil: "networkidle2" }).catch(() => null);
      return { url: page.url() };
    default:
      throw new Error(`Unknown action: ${action}`);
  }
}

async function navigate(page, params) {
  const { url, wait_for_selector, wait_ms } = params;
  if (!url) throw new Error("url is required");

  const response = await page.goto(url, {
    waitUntil: "networkidle2",
    timeout: params.timeout || 30000,
  });

  if (wait_for_selector) {
    await page
      .waitForSelector(wait_for_selector, { timeout: 10000 })
      .catch(() => null);
  }
  if (wait_ms) {
    await new Promise((r) => setTimeout(r, Math.min(wait_ms, 10000)));
  }

  const title = await page.title();
  const content = await page.evaluate(() => {
    const body = document.body;
    if (!body) return "";
    const clone = body.cloneNode(true);
    clone
      .querySelectorAll(
        "script, style, noscript, iframe, nav, footer, header, svg",
      )
      .forEach((el) => el.remove());
    return clone.innerText.replace(/\s+/g, " ").trim().substring(0, 8000);
  });

  return {
    url: page.url(),
    title,
    status: response?.status() || null,
    content_length: content.length,
    content,
  };
}

async function screenshot(page, params) {
  const options = {
    encoding: "base64",
    type: params.format || "png",
    fullPage: params.full_page || false,
  };

  if (params.selector) {
    const el = await page.$(params.selector);
    if (!el) throw new Error(`Element not found: ${params.selector}`);
    const data = await el.screenshot(options);
    return { data, mime: `image/${options.type}` };
  }

  const data = await page.screenshot(options);
  return { data, mime: `image/${options.type}` };
}

async function getContent(page, params) {
  const { selector, attribute, multiple } = params;

  if (!selector) {
    const text = await page.evaluate(() => {
      const clone = document.body.cloneNode(true);
      clone
        .querySelectorAll("script, style, noscript")
        .forEach((el) => el.remove());
      return clone.innerText.substring(0, 8000);
    });
    return { text };
  }

  if (multiple) {
    const results = await page.$$eval(
      selector,
      (els, attr) => {
        return els.slice(0, 100).map((el) => {
          if (attr === "html") return el.innerHTML;
          if (attr === "outerhtml") return el.outerHTML;
          if (attr && attr !== "text") return el.getAttribute(attr);
          return el.innerText;
        });
      },
      attribute || "text",
    );
    return { results, count: results.length };
  }

  const result = await page
    .$eval(
      selector,
      (el, attr) => {
        if (attr === "html") return el.innerHTML;
        if (attr === "outerhtml") return el.outerHTML;
        if (attr && attr !== "text") return el.getAttribute(attr);
        return el.innerText;
      },
      attribute || "text",
    )
    .catch(() => null);

  return { result };
}

async function click(page, params) {
  const { selector, text } = params;

  if (text) {
    const clicked = await page.evaluate((t) => {
      const els = [
        ...document.querySelectorAll(
          'a, button, [role="button"], input[type="submit"]',
        ),
      ];
      const match = els.find((el) =>
        el.textContent.trim().toLowerCase().includes(t.toLowerCase()),
      );
      if (match) {
        match.click();
        return true;
      }
      return false;
    }, text);
    if (!clicked) throw new Error(`No clickable element with text: ${text}`);
  } else if (selector) {
    await page.click(selector);
  } else {
    throw new Error("selector or text is required");
  }

  await page
    .waitForNavigation({ waitUntil: "networkidle2", timeout: 5000 })
    .catch(() => {});
  return { url: page.url(), title: await page.title() };
}

async function fill(page, params) {
  const { selector, value } = params;
  if (!selector || value === undefined)
    throw new Error("selector and value are required");

  await page.click(selector, { clickCount: 3 });
  await page.type(selector, String(value), { delay: 30 });

  return { filled: true, selector };
}

async function selectOption(page, params) {
  const { selector, value } = params;
  if (!selector || !value) throw new Error("selector and value are required");
  await page.select(selector, value);
  return { selected: true, selector, value };
}

async function waitFor(page, params) {
  const { selector, text, ms } = params;

  if (ms) {
    await new Promise((r) => setTimeout(r, Math.min(ms, 10000)));
    return { waited: true, ms };
  }

  if (selector) {
    await page.waitForSelector(selector, { timeout: params.timeout || 10000 });
    return { found: true, selector };
  }

  if (text) {
    await page.waitForFunction(
      (t) => document.body?.innerText?.includes(t),
      { timeout: params.timeout || 10000 },
      text,
    );
    return { found: true, text };
  }

  throw new Error("selector, text, or ms is required");
}

async function evaluate(page, params) {
  const { script } = params;
  if (!script) throw new Error("script is required");

  const SAFE_LIMIT = 2000;
  if (script.length > SAFE_LIMIT)
    throw new Error(`Script too long (max ${SAFE_LIMIT} chars)`);

  const result = await page.evaluate(script);
  return { result };
}

async function getLinks(page, params) {
  const { filter } = params;
  const links = await page.$$eval(
    "a[href]",
    (els, f) => {
      return els
        .map((el) => ({ text: el.innerText.trim(), href: el.href }))
        .filter((l) => l.href && !l.href.startsWith("javascript:"))
        .filter(
          (l) =>
            !f ||
            l.text.toLowerCase().includes(f.toLowerCase()) ||
            l.href.includes(f),
        )
        .slice(0, 200);
    },
    filter || "",
  );
  return { links, count: links.length };
}

async function getPageInfo(page) {
  const info = await page.evaluate(() => {
    const meta = {};
    document.querySelectorAll("meta").forEach((m) => {
      const name = m.getAttribute("name") || m.getAttribute("property");
      if (name) meta[name] = m.getAttribute("content");
    });
    return {
      title: document.title,
      url: location.href,
      meta,
      forms: document.forms.length,
      links: document.querySelectorAll("a[href]").length,
      images: document.images.length,
    };
  });
  return info;
}

async function scroll(page, params) {
  const { direction, amount } = params;
  const px = amount || 500;
  await page.evaluate(
    (dir, px) => {
      if (dir === "up") window.scrollBy(0, -px);
      else if (dir === "left") window.scrollBy(-px, 0);
      else if (dir === "right") window.scrollBy(px, 0);
      else window.scrollBy(0, px);
    },
    direction || "down",
    px,
  );
  return { scrolled: true, direction: direction || "down", amount: px };
}

module.exports = { executeAction };
