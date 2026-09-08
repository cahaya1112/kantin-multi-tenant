<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function guest_diarahkan_ke_halaman_login(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect('/login');
    }

    #[Test]
    public function pengguna_admin_terverifikasi_dapat_membuka_dashboard(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'active',
        ]);

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
    }

    #[Test]
    public function pengguna_non_admin_mendapat_respon_403(): void
    {
        $user = User::factory()->create([
            'role' => 'customer',
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertStatus(403);
    }
}
