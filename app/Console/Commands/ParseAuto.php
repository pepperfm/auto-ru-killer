<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Api\TapirService;

class ParseAuto extends Command
{
    protected $signature = 'app:parse-auto';

    /**
     * Execute the console command.
     */
    public function handle(TapirService $service): void
    {
        dd(
            $service->new(),
            $service->used()
        );
    }
}
