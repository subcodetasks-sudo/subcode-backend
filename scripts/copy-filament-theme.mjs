import fs from 'fs';
import path from 'path';

const manifestPath = 'public/build/manifest.json';
const dest = 'public/css/filament/admin-theme.css';

if (! fs.existsSync(manifestPath)) {
    console.warn('Skipping Filament theme copy: manifest not found.');
    process.exit(0);
}

const manifest = JSON.parse(fs.readFileSync(manifestPath, 'utf8'));
const entry = manifest['resources/css/filament/admin/theme.css'];

if (! entry?.file) {
    console.warn('Skipping Filament theme copy: theme entry missing from manifest.');
    process.exit(0);
}

const src = path.join('public/build', entry.file);

fs.mkdirSync(path.dirname(dest), { recursive: true });
fs.copyFileSync(src, dest);

console.log(`Copied ${src} -> ${dest}`);
