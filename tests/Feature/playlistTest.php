<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class PlaylistTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_can_login_and_see_playlists(): void
    {
        $user = User::factory()->create();

        authenticate($response);
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('playlist.index', absolute: false));

        // $response->assertStatus(302);
        $response = $this->get('/playlist');

        $response->assertSee("Create Playlist");

 
    }

    public function test_user_can_see_created_playlists(): void 
    {
        $this->authenticate    
        $response->assertSee("No playlists found.");

    }
    public function authenticate(): void 
{

}
}