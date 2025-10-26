import sharp from 'sharp';
import fs from 'fs';
import path from 'path';

const imagesDir = 'public/images';
const outputDir = 'public/images-optimized';

if (!fs.existsSync(outputDir)) {
  fs.mkdirSync(outputDir, { recursive: true });
}

function optimizeImage(inputPath, outputPath) {
  const ext = path.extname(inputPath).toLowerCase();
  if (ext === '.jpg' || ext === '.jpeg') {
    return sharp(inputPath)
      .jpeg({ quality: 80 })
      .toFile(outputPath.replace(ext, '.webp'))
      .then(() => sharp(inputPath).jpeg({ quality: 80 }).toFile(outputPath))
      .catch(err => console.error(`Error optimizing ${inputPath}:`, err));
  } else if (ext === '.png') {
    return sharp(inputPath)
      .png({ quality: 80 })
      .toFile(outputPath.replace(ext, '.webp'))
      .then(() => sharp(inputPath).png({ quality: 80 }).toFile(outputPath))
      .catch(err => console.error(`Error optimizing ${inputPath}:`, err));
  }
}

function processDirectory(dir) {
  const files = fs.readdirSync(dir);
  files.forEach(file => {
    const filePath = path.join(dir, file);
    const stat = fs.statSync(filePath);
    if (stat.isDirectory()) {
      processDirectory(filePath);
    } else {
      const ext = path.extname(file).toLowerCase();
      if (['.jpg', '.jpeg', '.png'].includes(ext)) {
        const relativePath = path.relative(imagesDir, filePath);
        const outputPath = path.join(outputDir, relativePath);
        const outputDirPath = path.dirname(outputPath);
        if (!fs.existsSync(outputDirPath)) {
          fs.mkdirSync(outputDirPath, { recursive: true });
        }
        optimizeImage(filePath, outputPath);
      }
    }
  });
}

processDirectory(imagesDir);
console.log('Image optimization complete.');