<?php

namespace Tests\Feature\API\ActionSequence;

use App\Controlunit;
use App\LogicalSensor;
use App\PhysicalSensor;
use App\Pump;
use App\Terrarium;
use App\ActionSequence;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\TestHelperTrait;

/**
 * Class ActionSequenceUpdateOkTest
 * @package Tests\Feature
 */
class ActionSequenceUpdateOkTest extends TestCase
{

    use TestHelperTrait;

    public function test()
    {

        $token = $this->createUserFullPermissions();

        $terrarium = Terrarium::create([
            'name' => 'TestTerrarium01', 'display_name' => 'TestTerrarium01'
        ]);

        $response = $this->json('POST', '/api/v1/action_sequences', [
            'terrarium' => $terrarium->id,
            'name' => 'TestActionSequence01',
            'template' => 'irrigate',
            'runonce' => false,
            'duration_minutes' => 1
        ], [
            'Authorization' => 'Bearer ' . $token
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id'
            ]
        ]);

        $action_sequence_id = $response->decodeResponseJson()['data']['id'];

        $response = $this->put('/api/v1/action_sequences/' . $action_sequence_id, [
            'name' => 'TestActionSequence01_Updated',
        ], [
            'Authorization' => 'Bearer ' . $token
        ]);
        $response->assertStatus(200);

        $response = $this->get('/api/v1/action_sequences/' . $action_sequence_id, [
            'Authorization' => 'Bearer ' . $token
        ]);
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $action_sequence_id,
                'name' => 'TestActionSequence01_Updated'
            ]
        ]);

        ActionSequence::find($action_sequence_id)->delete();
        $terrarium->delete();

        $this->cleanupUsers();

    }

}
