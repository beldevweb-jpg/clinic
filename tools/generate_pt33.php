<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $ctrl = $app->make(Modules\PDF\Http\Controllers\PDFController::class);
    $pt = Modules\Document\Models\PT33::first();
    if (!$pt) {
        echo "NO_PT33_RECORD\n";
        exit(1);
    }
    echo "Using pt33 id=" . $pt->id . "\n";
    $medicId = 1;
    // try to pick a medic if available
    $medic = Modules\Medics\Models\Medics::first();
    if ($medic) {
        $medicId = $medic->id;
        echo "Using medic id=" . $medicId . "\n";
    }
    $path = $ctrl->generatePT33($pt, $medicId);
    echo "OK:" . $path . "\n";
} catch (Throwable $e) {
    echo "ERROR: " . $e->getMessage() . " in " . $e->getFile() . ':' . $e->getLine() . "\n";
    echo $e->getTraceAsString();
}
