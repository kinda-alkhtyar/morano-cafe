<?php

namespace Tests\Feature;

use App\Models\User;
use Filament\Auth\Pages\Login;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login_is_available_without_registration(): void
    {
        $this->get('/admin/login')->assertOk();
        $this->get('/admin')->assertRedirect('/admin/login');
        $this->get('/register')->assertNotFound();
    }

    public function test_only_verified_admin_can_open_panel(): void
    {
        $ordinary = User::create(['name' => 'Guest', 'email' => 'guest@example.test', 'password' => 'secret']);
        $ordinary->forceFill(['email_verified_at' => now()])->save();
        $unverified = User::create(['name' => 'Staff', 'email' => 'staff@example.test', 'password' => 'secret']);
        $unverified->forceFill(['is_admin' => true])->save();
        $admin = User::create(['name' => 'Admin', 'email' => 'admin@example.test', 'password' => 'secret']);
        $admin->forceFill(['is_admin' => true, 'email_verified_at' => now()])->save();

        $this->actingAs($ordinary)->get('/admin')->assertForbidden();
        $this->actingAs($unverified)->get('/admin')->assertForbidden();
        $this->actingAs($admin)->get('/admin')->assertOk();
        $this->actingAs($admin)->get('/admin/products')->assertOk();
    }

    public function test_admin_can_sign_in_with_password(): void
    {
        $admin = User::create(['name' => 'Admin', 'email' => 'admin@example.test', 'password' => 'secure-example-password']);
        $admin->forceFill(['is_admin' => true, 'email_verified_at' => now()])->save();

        Filament::setCurrentPanel(Filament::getPanel('admin'));
        Livewire::test(Login::class)
            ->fillForm(['email' => 'admin@example.test', 'password' => 'secure-example-password'])
            ->call('authenticate')
            ->assertHasNoFormErrors();

        $this->assertAuthenticatedAs($admin);
    }
}
