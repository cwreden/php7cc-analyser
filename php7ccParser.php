<?php

$file = $argv[1];

if (empty($file)) {
    echo 'php7cc result json file not defined.' . PHP_EOL;
    exit(3);
} elseif (!file_exists($file)) {
    echo sprintf('File: %s not found.' . PHP_EOL, $file);
    exit(3);
}

$content = file_get_contents($file);
$data = json_decode($content, true);

$warnings = 0;
$errors = 0;
foreach ($data['files'] AS $file) {
    echo '.';
    if (isset($file['errors']) && count($file['errors']) > 0) {
        $errors += count($file['errors']);
    }
    if (isset($file['warnings']) && count($file['warnings']) > 0) {
        $warnings += count($file['warnings']);
    }
}

echo PHP_EOL;
echo PHP_EOL;

echo sprintf(
    '[Checked files: %d, Effected files: %d, Warnings: %d, Errors: %d]' . PHP_EOL,
    $data['summary']['checkedFiles'],
    count($data['files']),
    $warnings,
    $errors
);

echo PHP_EOL;

if ($errors > 0) {
    echo 'There are php 7 incompatible statements!' . PHP_EOL;
    exit(2);
} elseif ($warnings > 0) {
    echo 'There are php 7 risky statements!' . PHP_EOL;
    exit(1);
} else {
    echo 'There are no php 7 errors or warnings.' . PHP_EOL;
    exit(0);
}