<?php

namespace Tests\Feature\BiographyEntry;

use App\Animal;
use App\BiographyEntryEvent;
use App\LogicalSensor;
use App\BiographyEntry;
use App\PhysicalSensor;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\TestHelperTrait;

/**
 * Class BiographyEntryStoreOkTest
 * @package Tests\Feature
 */
class BiographyEntryStoreOkTest extends TestCase
{

    use TestHelperTrait;

    public function test()
    {

        $token = $this->createUserFullPermissions();

        $response = $this->json('POST', '/api/v1/biography_entries/categories', [
            'name' => 'TestBiographyEntryCategory02',
            'icon' => 'close'
        ], [
            'HTTP_Authorization' => 'Bearer ' . $token
        ]);
        $response->assertStatus(200);

        $animal = Animal::create([
            'display_name' => 'TestAnimal01'
        ]);

        $response = $this->json('POST', '/api/v1/biography_entries', [
            'title' => 'TestBiographyEntry01',
            'text' => 'Some Text',
            'belongsTo_type' => 'Animal',
            'belongsTo_id' => $animal->id,
            'category' => 'TestBiographyEntryCategory02'
        ], [
            'HTTP_Authorization' => 'Bearer ' . $token
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id'
            ]
        ]);

        $id = $response->decodeResponseJson()['data']['id'];

        $response = $this->get('/api/v1/biography_entries/' . $id, [
            'HTTP_Authorization' => 'Bearer ' . $token
        ]);
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $id,
                'title' => 'TestBiographyEntry01'
            ]
        ]);

        BiographyEntryEvent::find($id)->delete();
        $animal->delete();

        $this->cleanupUsers();

    }

}