<?php
/**
 * Validation Script for Eunoiaverse
 * Tests critical components and database connectivity
 */

echo "====================================\n";
echo "Eunoiaverse Validation Report\n";
echo "====================================\n\n";

// 1. Database Connection Test
echo "[1] Database Connection Test\n";
try {
    require_once 'service/database.php';
    if ($connection->connect_error) {
        echo "❌ FAILED: " . $connection->connect_error . "\n";
    } else {
        echo "✓ PASSED: Database connected successfully\n";
        $connection->close();
    }
} catch (Exception $e) {
    echo "❌ FAILED: " . $e->getMessage() . "\n";
}

// 2. Critical Files Existence Test
echo "\n[2] Critical Files Existence Test\n";
$critical_files = [
    'src/Auth/Authentication.php',
    'src/Database/Connection.php',
    'src/Marketplace/Product.php',
    'src/Profile/Profile.php',
    'src/Wallet/Wallet.php',
    'service/profile.php',
    'assets/js/components/neumorphic.js',
    'assets/css/neumorphic.css'
];

foreach ($critical_files as $file) {
    $path = __DIR__ . '/' . $file;
    if (file_exists($path)) {
        echo "✓ " . $file . "\n";
    } else {
        echo "❌ " . $file . " (NOT FOUND)\n";
    }
}

// 3. PHP Syntax Check
echo "\n[3] PHP Syntax Check\n";
$php_files = glob(__DIR__ . '/src/**/*.php', GLOB_RECURSIVE);
$php_files = array_merge($php_files, glob(__DIR__ . '/service/*.php'));

$syntax_errors = 0;
foreach ($php_files as $file) {
    $output = [];
    $return = 0;
    exec("php -l \"$file\"", $output, $return);
    if ($return !== 0) {
        echo "❌ Syntax Error in: " . basename($file) . "\n";
        $syntax_errors++;
    }
}

if ($syntax_errors === 0) {
    echo "✓ All PHP files have valid syntax\n";
} else {
    echo "❌ Found $syntax_errors PHP files with syntax errors\n";
}

// 4. Directory Structure Test
echo "\n[4] Directory Structure Test\n";
$required_dirs = [
    'src',
    'assets',
    'assets/css',
    'assets/js',
    'assets/img',
    'layout',
    'service'
];

foreach ($required_dirs as $dir) {
    $path = __DIR__ . '/' . $dir;
    if (is_dir($path)) {
        echo "✓ " . $dir . "/\n";
    } else {
        echo "❌ " . $dir . "/ (MISSING)\n";
    }
}

echo "\n====================================\n";
echo "Validation Complete\n";
echo "====================================\n";
?>
