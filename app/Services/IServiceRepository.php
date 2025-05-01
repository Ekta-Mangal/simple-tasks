<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;

/**
 * IServiceRepository
 */
interface IServiceRepository
{
    /**
     * store
     */
    public function store(array $data);

    /**
     * update
     */
    public function update(int $id, array $data);

    /**
     * find by id
     *
     * @return void
     */
    public function find(int $id);

    /**
     * list
     */
    public function list(array $filters = []): LengthAwarePaginator;

    /**
     * Destroy by id
     *
     * @return void
     */
    public function delete(int $id): bool;
}
