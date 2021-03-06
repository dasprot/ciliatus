<?php

namespace Tests\Feature\Web\Pump;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\TestHelperTrait;

/**
 * Class PumpIndexOkTest
 * @package Tests\Feature
 */
class PumpIndexOkTest extends TestCase
{

    use TestHelperTrait;

    public function test()
    {

        $user = $this->createUserWeb();

        $this->actingAs($user)->get('/pumps')->assertStatus(200);

        $this->cleanupUsers();

    }

}
