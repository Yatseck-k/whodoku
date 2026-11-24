<?php

declare(strict_types=1);

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;
use Whodoku\Application\Puzzle\GeneratedPuzzlePublisher;
use Whodoku\Domain\Puzzle\Generation\GenerationProfile;
use Whodoku\Models\Puzzle;

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();
DB::setDefaultConnection('whodoku');

if (Puzzle::query()->where('status', 'published')->where('guest_access', true)->where('collection', '!=', 'story')->exists()) {
    echo "A public case already exists; keeping it.\n";
    exit(0);
}

$puzzle = $app->make(GeneratedPuzzlePublisher::class)->publish(GenerationProfile::forGrid(4, 4, seed: 1, maxAttempts: 40));
echo "Created a local example: {$puzzle->slug}\n";
