<?php

namespace App\Http\Controllers;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use App\Models\TaskStatus;

trait ControllerUtility
{
    public function filterTasks(array|null $filters, Builder $tasks): Builder
    {
        if (! is_null($filters)) {
            foreach ($filters as $key => $filter) {
                $filteredTasks = $this->filter($tasks, $key, $filter);
            }
        } else {
            $filteredTasks = $tasks;
        }

        return $filteredTasks;
    }

    private function filter(Builder $tasks, string $key, string $filter): array
    {
        if (! is_null($filter)) {
            $filteredTasks = $tasks->where([
                [$key, '=', $filter]
            ]);
        } else {
            $filteredTasks = $tasks;
        }

        return $filteredTasks;
    }

    public function getAll(mixed $model): mixed
    {
        return $model::all('id', 'name')->pluck('name', 'id');
    }
}
