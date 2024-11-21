<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\App\AppService;
use Illuminate\Pagination\LengthAwarePaginator;

final class AppServiceTest extends TestCase
{
    private $appService;

    /**
     * @doesNotPerformAssertions
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->appService = new AppService();
    }


    /**
     * @doesNotPerformAssertions
     */
    public function testListWithEmptyFilters()
    {
        $result = $this->appService->list();
        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }


    /**
     * @doesNotPerformAssertions
     */
    public function testListWithNullValuesInFilters()
    {
        $filters = ['name' => null, 'invalid' => 'value'];
        $result = $this->appService->list($filters);
        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }


    /**
     * @doesNotPerformAssertions
     */
    public function test_list_returns_length_aware_paginator(): void
    {
        $result = $this->appService->list();

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }
}