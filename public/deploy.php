<?php
/**
 * Simple Deployment Script
 * Akan menjalankan git pull otomatis saat dipanggil oleh GitHub Webhook
 */

// Ganti token ini dengan kata sandi rahasia Anda jika ingin lebih aman
$secret_token = 'KanaPC_AutoDeploy_2026';

// Mengecek token dari parameter URL (?token=...)
$request_token = $_GET['token'] ?? '';

if ($request_token !== $secret_token) {
    header('HTTP/1.1 403 Forbidden');
    die('Akses Ditolak. Token salah.');
}

// Perintah yang akan dijalankan di terminal cPanel
$commands = [
    'cd .. && git pull origin main 2>&1',
    'cd .. && php artisan optimize:clear 2>&1',
];

$output = '';
foreach ($commands as $command) {
    $result = shell_exec($command);
    $output .= "Menjalankan: $command\n";
    $output .= htmlentities(trim($result)) . "\n\n";
}

echo "<pre style='background: #1e1e1e; color: #00ff00; padding: 20px; border-radius: 10px;'>";
echo "=== DEPLOYMENT BERHASIL ===\n\n";
echo $output;
echo "</pre>";
?>
