<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Data\Auto\AutoData;
use App\Services\Api\TapirService;
use App\Services\AutoService;

use function Laravel\Prompts\info;

class ParseAuto extends Command
{
    protected $signature = 'app:parse-auto';

    public function handle(TapirService $tapirService, AutoService $autoService): int
    {
        try {
            app('db')->beginTransaction();

            foreach ($tapirService->new() as $item) {
                $autoService->create(AutoData::from($item));
            }
            foreach ($tapirService->used() as $item) {
                $autoService->create(AutoData::from(
                    array_merge($item->toArray(), ['isNew' => false])
                ));
            }

            app('db')->commit();
        } catch (\Throwable $e) {
            app('db')->rollback();
            logger()->debug($e->getMessage());

            info($e->getMessage());

            return static::FAILURE;
        }

        return static::SUCCESS;
    }
}
