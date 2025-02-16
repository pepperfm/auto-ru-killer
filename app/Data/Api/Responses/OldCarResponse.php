<?php

declare(strict_types=1);

namespace App\Data\Api\Responses;

use Spatie\LaravelData\Data;

class OldCarResponse extends Data
{
    public function __construct(
        public string $brand,
        public string $model,
        public string $vin,
        public string $price,
        public string $year,
        public string $mileage,
    ) {
    }
}
