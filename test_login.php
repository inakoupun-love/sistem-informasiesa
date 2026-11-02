<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$request = Illuminate\Http\Request::create('/login', 'POST', [
    'login_field' => 'Abraham Petra Titihalawa',
    'password' => '8171031503040005',
    'role' => 'masyarakat',
]);

// We need to bypass CSRF for this test, or we can just call the controller directly.
$controller = new App\Http\Controllers\AuthController();
try {
    $response = $controller->login($request);
    echo "Status: " . $response->getStatusCode() . "\n";
    echo "Target URL: " . $response->getTargetUrl() . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
