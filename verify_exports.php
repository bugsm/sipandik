<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

echo "--- STARTING EXPORT VERIFICATION ---\n";

// Mock Admin User
$admin = \App\Models\User::where('role', 'admin')->first();
if (!$admin) {
    echo "[FAIL] No admin user found for testing.\n";
    exit(1);
}
auth()->login($admin);

function testExport($route, $name) {
    echo "Testing $name...\n";
    try {
        $request = Request::create($route, 'GET');
        $response = app()->handle($request);
        
        $status = $response->getStatusCode();
        $contentType = $response->headers->get('content-type');
        
        if ($status === 200) {
            echo "[PASS] $name ($status) - Type: $contentType\n";
        } else {
            echo "[FAIL] $name returned status $status\n";
             if ($status === 500 && method_exists($response, 'exception')) {
                 echo "Error: " . $response->exception->getMessage() . "\n";
             }
        }
    } catch (\Exception $e) {
        echo "[FAIL] $name Exception: " . $e->getMessage() . "\n";
    }
}

// Bug Reports
testExport('/admin/bug-reports/export/xlsx', 'Bug Reports Excel');
testExport('/admin/bug-reports/export/pdf', 'Bug Reports PDF');

// Data Requests
testExport('/admin/data-requests/export/xlsx', 'Data Requests Excel');
testExport('/admin/data-requests/export/pdf', 'Data Requests PDF');

echo "--- VERIFICATION COMPLETE ---\n";
