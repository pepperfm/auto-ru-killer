<?php

declare(strict_types=1);

namespace App\Data\Auto;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Attributes\MapName;

class AutoData extends Data
{
    public function __construct(
        public int|Optional $id,
        public Optional|string $brand,
        public Optional|string $model,
        public Optional|string $vin,
        public Optional|string $price,
        public null|Optional|string $year,
        public null|Optional|string $mileage,
        #[MapName('is_new')]
        public bool $isNew = true,
    ) {
    }
}
