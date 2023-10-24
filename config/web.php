<?php

$directory = rtrim(
    __DIR__ . DIRECTORY_SEPARATOR .
        '..' . DIRECTORY_SEPARATOR .
        'app' . DIRECTORY_SEPARATOR .
        'Routes',
    DIRECTORY_SEPARATOR
) . DIRECTORY_SEPARATOR;

$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
foreach ($files as $file) {
    if ($file->isDir()) {
        continue;
    }
    if ($file->isFile() && $file->getExtension() === 'php') {
        require_once $file;
    }
}
