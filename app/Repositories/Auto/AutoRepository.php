<?php

declare(strict_types=1);

namespace App\Repositories\Auto;

use App\Data\Auto\AutoData;
use App\Models\Auto;

readonly class AutoRepository implements AutoRepositoryContract
{
    public function __construct(
        protected Auto $model
    ) {
    }

    public function find(int $id, array $relations): Auto
    {
        return $this->model
            ->newQuery()
            ->findOrFail($id)
            ->load($relations);
    }

    public function get(array $relations): \Illuminate\Support\Collection
    {
        return $this->model
            ->newQuery()
            ->with($relations)
            ->get();
    }

    public function create(AutoData $data): Auto
    {
        $model = $this->model->newInstance($data->toArray());
        $model->save();

        return $model;
    }

    public function update(AutoData $data): Auto
    {
        $model = $this->model->newInstance($data->toArray(), true);
        $model->save();

        return $model;
    }
}
