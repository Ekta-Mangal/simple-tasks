<?php

declare(strict_types=1);

namespace App\Services\App;

use App\Models\App;
use App\Services\IServiceRepository;
use Illuminate\Pagination\LengthAwarePaginator;

final class AppService implements IServiceRepository
{
    private App $model;

    public function __construct()
    {
        $this->model = new App();
    }

    /**
     * list
     * 
     * Review & refactor the following code as part of the test
     */
    public function list(array $filters = []): LengthAwarePaginator
    {
        //remove null values from filters array
        $temp = [];
        foreach ($filters as $key => $value) {
            if ($value !== null) {
                $temp[$key] = $value;
            }
        }
        $filters = $temp;

        $query = $this->model->query();
        if (isset($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        return $query->paginate();
    }

    /**
     * list all app users email
     * 
     * Review & refactor the following code as part of the test
     */
    public function allAppUserEmails(): array
    {
        $apps = $this->model
            ->orderBy('name')
            ->get();

        $emails = [];
        foreach ($apps as $app) {
            if ($app->users()->count() > 0) {
                $users = $app->users;
                foreach ($users as $user) {
                    $emails[$app->name][] = $user->email;
                }
            }
        }

        return $emails;
    }

    /**
     * store
     * @codeCoverageIgnore
     */
    public function store(array $data): void
    {
        //This is not needed for this screening test
        return;
    }

    /**
     * update
     * @codeCoverageIgnore
     */
    public function update(int $id, array $data): void
    {
        //This is not needed for this screening test
        return;
    }

    /**
     * find by id
     * @codeCoverageIgnore
     */
    public function find(int $id)
    {
        //This is not needed for this screening test
        return;
    }


    /**
     * Destroy by id
     */
    public function delete(int $id): bool
    {
        // TODO: Implement delete logic
        // Check for any dependent data

        return true;
    }
}
