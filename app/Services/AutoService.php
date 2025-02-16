<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\Auto\AutoRepositoryContract;
use App\Data\Auto\AutoData;
use App\Models\Auto;

readonly class AutoService
{
    public function __construct(
        private AutoRepositoryContract $autoRepository,
    ) {
    }

    public function create(AutoData $autoData): Auto
    {
        return $this->autoRepository->create($autoData);
    }
}
