<?php
/**
 * GitHub Webhook Auto-Deploy Script
 * 
 * هذا الملف يستمع لـ GitHub Webhooks ويقوم بتحديث الموقع تلقائياً
 * عند push على branch main
 */

// إعدادات الأمان
$secret = 'your_webhook_secret_here'; // غيّر هذا إلى كلمة سر قوية
$repo_path = '/home/u994369532/basmah'; // مسار المشروع على السيرفر
$branch = 'refs/heads/main'; // الـ branch المطلوب

// التحقق من صحة الطلب
function verify_webhook($data, $signature, $secret) {
    $expected = hash_hmac('sha256', $data, $secret);
    return hash_equals('sha256=' . $expected, $signature);
}

// تسجيل الأحداث
function log_message($message) {
    $log = date('Y-m-d H:i:s') . " - " . $message . PHP_EOL;
    file_put_contents(__DIR__ . '/deploy.log', $log, FILE_APPEND | LOCK_EX);
}

// بداية التنفيذ
$headers = getallheaders();
$signature = $headers['X-Hub-Signature-256'] ?? '';
$payload = file_get_contents('php://input');

// التحقق من الأمان
if (!verify_webhook($payload, $signature, $secret)) {
    http_response_code(403);
    log_message('ERROR: Invalid webhook signature');
    exit('Forbidden');
}

$data = json_decode($payload, true);

// التحقق من أن الـ push على الـ branch الصحيح
if ($data['ref'] !== $branch) {
    log_message('INFO: Push to ' . $data['ref'] . ' ignored (not main branch)');
    exit('Not main branch');
}

log_message('INFO: Webhook received for main branch');

// تنفيذ أوامر التحديث
$commands = [
    "cd $repo_path",
    "git pull origin main 2>&1",
    "composer install --no-dev --optimize-autoloader --no-interaction 2>&1",
    "php artisan down --message='نظام قيد التحديث' --retry=60 2>&1",
    "php artisan migrate --force 2>&1",
    "php artisan config:clear 2>&1",
    "php artisan view:clear 2>&1",
    "php artisan route:clear 2>&1",
    "php artisan cache:clear 2>&1",
    "php artisan config:cache 2>&1",
    "php artisan route:cache 2>&1",
    "php artisan view:cache 2>&1",
    "rsync -av --delete $repo_path/public/ /home/u994369532/public_html/ 2>&1",
    "php artisan storage:link 2>&1",
    "php artisan up 2>&1"
];

log_message('INFO: Starting deployment...');

foreach ($commands as $command) {
    log_message("COMMAND: $command");
    $output = shell_exec($command);
    log_message("OUTPUT: " . trim($output));
}

log_message('SUCCESS: Deployment completed successfully!');

// إرسال رد نجح
http_response_code(200);
echo json_encode([
    'status' => 'success',
    'message' => 'Deployment completed successfully',
    'timestamp' => date('Y-m-d H:i:s'),
    'commit' => $data['head_commit']['id'] ?? 'unknown'
]);
?>
