import {access, cp, mkdir, readdir, rm, writeFile} from 'node:fs/promises';
import {constants} from 'node:fs';
import {dirname, join, relative} from 'node:path';
import {fileURLToPath} from 'node:url';

const {compile} = await import('sass');

const assetsRoot = fileURLToPath(new URL('.', import.meta.url));
const bundleRoot = dirname(assetsRoot);
const publicRoot = join(bundleRoot, 'assets', 'dist');
const entries = ['layout', 'sidebar', 'styles'];
const loadPaths = [join(bundleRoot, 'node_modules')];

await rm(publicRoot, {recursive: true, force: true});
await rm(join(assetsRoot, 'dist'), {recursive: true, force: true});
await mkdir(publicRoot, {recursive: true});

async function copyDirectory(sourceDir, targetDir) {
  await mkdir(targetDir, {recursive: true});

  const items = await readdir(sourceDir, {withFileTypes: true});
  for (const item of items) {
    const sourcePath = join(sourceDir, item.name);
    const targetPath = join(targetDir, item.name);

    if (item.isDirectory()) {
      await copyDirectory(sourcePath, targetPath);
      continue;
    }

    if (item.name.endsWith('.scss')) {
      continue;
    }

    await cp(sourcePath, targetPath);
  }
}

async function compileScssFiles(sourceDir) {
  const items = await readdir(sourceDir, {withFileTypes: true});
  for (const item of items) {
    const sourcePath = join(sourceDir, item.name);

    if (item.name === 'public' || item.name === 'dist' || item.name === 'node_modules') {
      continue;
    }

    if (item.isDirectory()) {
      await compileScssFiles(sourcePath);
      continue;
    }

    if (!item.isFile() || !item.name.endsWith('.scss') || item.name.startsWith('_')) {
      continue;
    }

    const css = compile(sourcePath, {
      style: 'expanded',
      loadPaths: [assetsRoot, ...loadPaths],
    }).css;

    const targetPath = join(publicRoot, relative(assetsRoot, sourcePath).replace(/\.scss$/, '.css'));
    await mkdir(dirname(targetPath), {recursive: true});
    await writeFile(targetPath, css);
  }
}

for (const entry of entries) {
  const source = join(assetsRoot, entry);
  try {
    await access(source, constants.F_OK);
    await copyDirectory(source, join(publicRoot, entry));
  } catch {
    // Optional asset folders are skipped.
  }
}

await cp(join(assetsRoot, 'layout', 'admin-shell.js'), join(publicRoot, 'admin-shell.js'));

await compileScssFiles(assetsRoot);
