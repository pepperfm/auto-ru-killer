<?php

declare(strict_types=1);

namespace App\Repositories\Auto;

use App\Data\Auto\AutoData;
use App\Models\Auto;

interface AutoRepositoryContract
{
    public function find(int $id, array $relations): Auto;

    public function get(array $relations): \Illuminate\Support\Collection;

    public function create(AutoData $data): Auto;

    public function update(AutoData $data): Auto;
}
