<?php

namespace Tests\Feature;

use App\Models\Tenant;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthRbacTest extends TestCase
{
    use DatabaseMigrations;

    public function test_register_and_login_scoped_by_tenant()
    {
        $tenant = Tenant::factory()->create(['slug' => 'acme']);
        app()->instance('tenant', $tenant);

        $this->postJson('/api/v1/auth/register', [
            'name'=>'A', 'email'=>'a@a.com', 'password'=>'password123'
        ], ['X-Tenant-ID'=>'acme'])->assertCreated();

        $res = $this->postJson('/api/v1/auth/login', [
            'email'=>'a@a.com', 'password'=>'password123'
        ], ['X-Tenant-ID'=>'acme'])->assertOk()->json();

        $this->withHeaders([
            'Authorization' => 'Bearer '.$res['token'],
            'X-Tenant-ID' => 'acme',
        ])->getJson('/api/v1/auth/me')->assertOk();
    }
}

