<?php
header('Content-Type: text/plain');

echo "Current dir: " . __DIR__ . "\n";
echo "Document root: " . $_SERVER['DOCUMENT_ROOT'] . "\n";

$dirs = [
    '/var/www/html/wp-content/uploads',
    '/var/www/html/wp-content/uploads_backup',
    'wp-content/uploads',
    'wp-content/uploads_backup'
];

foreach ($dirs as $d) {
    echo "\nChecking $d:\n";
    if (file_exists($d)) {
        echo "  Exists: Yes\n";
        echo "  Is Dir: " . (is_dir($d) ? "Yes" : "No") . "\n";
        echo "  Permissions: " . substr(sprintf('%o', fileperms($d)), -4) . "\n";
        
        $files = scandir($d);
        echo "  Files count: " . count($files) . "\n";
        echo "  First 10 files:\n";
        foreach (array_slice($files, 0, 10) as $f) {
            echo "    - $f\n";
        }
    } else {
        echo "  Exists: No\n";
    }
}
?>
