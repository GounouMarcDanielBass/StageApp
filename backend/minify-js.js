import { execSync } from 'child_process';
import fs from 'fs';
import path from 'path';

const jsDir = 'public/js';
const files = fs.readdirSync(jsDir);

files.forEach(file => {
  if (file.endsWith('.js') && !file.endsWith('.min.js') && !file.endsWith('.map')) {
    const filePath = path.join(jsDir, file);
    const minFilePath = filePath.replace('.js', '.min.js');
    if (!fs.existsSync(minFilePath)) {
      try {
        execSync(`npx terser ${filePath} --output ${minFilePath}`, { stdio: 'inherit' });
        console.log(`Minified ${file}`);
      } catch (error) {
        console.error(`Error minifying ${file}:`, error);
      }
    }
  }
});

console.log('JS minification complete.');