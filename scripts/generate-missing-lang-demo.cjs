const fs = require("fs");
const path = require("path");

const ROOT = process.cwd();
const RESOURCES_DIR = path.join(ROOT, "resources");
const AR_JSON_PATH = path.join(ROOT, "resources", "lang", "ar.json");
const DEMO_JSON_PATH = path.join(ROOT, "resources", "lang", "demo.json");

function walk(dir) {
  const out = [];
  for (const item of fs.readdirSync(dir, { withFileTypes: true })) {
    if (item.name === "lang") continue;
    const full = path.join(dir, item.name);
    if (item.isDirectory()) out.push(...walk(full));
    else out.push(full);
  }
  return out;
}

function extractKeys(content) {
  const keys = [];
  const regex = /(?:__|@lang)\(\s*(['"])((?:\\.|(?!\1).)*)\1/gm;
  let match = regex.exec(content);
  while (match) {
    const key = match[2].trim();
    if (key) keys.push(key);
    match = regex.exec(content);
  }
  return keys;
}

function main() {
  const allFiles = walk(RESOURCES_DIR);
  const translatableFiles = allFiles.filter((f) => {
    const ext = path.extname(f).toLowerCase();
    return [".php", ".blade.php", ".js", ".ts", ".vue"].some((e) =>
      f.endsWith(e)
    ) || [".php", ".js", ".ts", ".vue"].includes(ext);
  });

  const usedKeys = new Set();
  for (const file of translatableFiles) {
    const content = fs.readFileSync(file, "utf8");
    for (const key of extractKeys(content)) usedKeys.add(key);
  }

  const arJson = JSON.parse(fs.readFileSync(AR_JSON_PATH, "utf8"));
  const arKeys = new Set(Object.keys(arJson));

  const missing = [...usedKeys].filter((k) => !arKeys.has(k)).sort();
  const demo = {};
  for (const key of missing) demo[key] = "";

  fs.writeFileSync(DEMO_JSON_PATH, JSON.stringify(demo, null, 2) + "\n", "utf8");
  console.log(`Created ${path.relative(ROOT, DEMO_JSON_PATH)} with ${missing.length} missing keys.`);
}

main();

