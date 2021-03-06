<?php

namespace Tests\Feature\API\LogicalSensorThreshold;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\TestHelperTrait;

/**
 * Class LogicalSensorThresholdIndexUnauthenticatedTest
 * @package Tests\Feature
 */
class LogicalSensorThresholdIndexUnauthenticatedTest extends TestCase
{

    use TestHelperTrait;

    public function test()
    {

        $response = $this->json('GET', '/api/v1/logical_sensor_thresholds');
        $response->assertStatus(401);

    }

}
