<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VideosTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_get_total_videos_size_created_by_user()
    {
        $this->withoutExceptionHandling();
        # Create a user.
        $user = factory('App\User')->create();
        # Create x videos
        $videos = factory('App\Video', 3)->create(['user_id' => $user->id]);
        # Get endpoint
        $response = $this->get('/api/total_videos_size_by_user?username='.$user->username);

        $total = $videos->sum(['size']);
        # assert that returns true
        $response->assertStatus(200)
                ->assertSee($total);
    }

    /** @test */
    public function only_can_get_total_videos_size_created_by_user_if_it_has_videos()
    {
        $this->withoutExceptionHandling();
        # Create a user
        $user = factory('App\User')->create();
        # Get endpoint
        $response = $this->get('/api/total_videos_size_by_user?username='.$user->username);
        # Asserts that return error
        $response->assertStatus(200);
        # Asserts the json error mssage
    }

    /** @test */
    public function a_username_is_required_to_get_videos_size_created_by_user()
    {
        $this->withoutExceptionHandling();
        #get endpoint
        $response = $this->get('/api/total_videos_size_by_user?username=');
        #assets that returns error
        $response->assertStatus(422);
        #asserts the json error message
    }

    /** @test */
    public function it_can_get_video_metadata()
    {
        $this->withoutExceptionHandling();
        # Create a user
        $user = factory('App\User')->create();
        # Create a video
        $video = factory('App\Video')->create(['user_id' => $user->id]);
        # Get endpoint
        $response = $this->get('/api/videos/'.$video->id.'/metadata');
        # Asserts it see the metadata
        $response->assertSee($video->size);
    }

    /** @test */
    public function get_video_metadata_requires_video_id()
    {
        # Create a user
        $user = factory('App\User')->create();
        # get the endpoing without video id
        $response = $this->get('/api/videos/1/metadata');
        # Asserts return an error
        $response->assertStatus(400)
                ->assertSee('Not Found');
    }

    /** @test */
    public function it_can_update_video_metadata()
    {
        $this->withoutExceptionHandling();
        # Create a user
        $user = factory('App\User')->create();
        # Create a video
        $video = factory('App\Video')->create(['user_id' => $user->id]);
        # patch the endpoint
        $response = $this->patch('/api/videos/'.$video->id.'/metadata', ['size' => 1, 'viewers' => 1]);

        $response->assertStatus(200)
                ->assertSee(1);
    }

    /** @test */
    public function update_meta_data_requires_video_id()
    {
        #Patch to endpoint without video_id
        $response = $this->patch('/api/videos/1/metadata', ['size' => 1, 'viewers' => 1]);
        # Asserts return an error.
        $response->assertStatus(400)
                ->assertSee('Not Found');
    }

    /** @test */
    public function update_meta_data_requires_viewers_to_be_integer()
    {
        $this->withoutExceptionHandling();
        # Create a user
        $user = factory('App\User')->create();
        # Create a video
        $video = factory('App\Video')->create(['user_id' => $user->id]);
        #Patch to endpoint without video_id
        $response = $this->patch('/api/videos/'.$video->id.'/metadata', ['size' => 1, 'viewers' => 'aaa']);
        # Asserts return an error.
        $response->assertStatus(422);
    }

    /** @test */
    public function only_a_existing_video_can_get_updated()
    {
        #Patch to endpoint without video_id
        $response = $this->patch('/api/videos/1/metadata', ['size' => 1, 'viewers' => 1]);
        # Asserts return an error.
        $response->assertStatus(400)
                ->assertSee('Not Found');
    }
}
