<?php

namespace Tests\Feature\API\AnimalWeighingSchedule;

use App\Animal;
use App\AnimalWeighingSchedule;
use App\Valve;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\TestHelperTrait;

/**
 * class AnimalWeighingScheduleSkipOkTest
 * @package Tests\Feature
 */
class AnimalWeighingScheduleSkipOkTest extends TestCase
{

    use TestHelperTrait;

    public function test()
    {

        $token = $this->createUserFullPermissions();

        $animal = Animal::create([
            'name' => 'TestAnimalWeighingSchedule01', 'display_name' => 'TestAnimalWeighingSchedule01'
        ]);

        $response = $this->post('/api/v1/animals/' . $animal->id . '/weighing_schedules', [
            'value' => '1'
        ],
        [
            'Authorization' => 'Bearer ' . $token
        ]);
        $response->assertStatus(200);

        $id = $response->decodeResponseJson()['data']['id'];

        $response = $this->post('/api/v1/animals/' . $animal->id . '/weighing_schedules/' . $id . '/skip', [
            'value' => '7'
        ],
            [
                'Authorization' => 'Bearer ' . $token
            ]);
        $response->assertStatus(200);

        $this->cleanupUsers();

    }

}
