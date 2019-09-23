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
        # assert that returns true
        $response->assertStatus(200);
        # assert that see te total video size created by the user.
        $total = $videos->sum(['size']);
        $response->assertSee($total);
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
        $response = $this->get('/api/get_video_metadata?id_video='.$video->id);
        # Asserts it see the metadata
        $response->assertSee($video->size);
    }

    /** @test */
    public function get_video_metadata_requires_video_id()
    {
        # Create a user
        $user = factory('App\User')->create();
        # Create a video
        $video = factory('App\Video')->create(['user_id' => $user->id]);
        # get the endpoing without video id
        $response = $this->get('/api/get_video_metadata?id_video=');
        # Asserts return an error
        $response->assertStatus(422);
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
        $response = $this->patch('/api/update_video_metadata/?id_video='.$video->id, ['size' => 1, 'viewers' => 1]);
        //$response = $this->json('POST', '/user', ['name' => 'Sally']);
        $response->assertStatus(200);
        # asserts return the video with new metadata
        $response->assertSee(1);
    }

    /** @test */
    public function update_meta_data_requires_video_id()
    {
        #Patch to endpoint without video_id
        $response = $this->patch('/api/update_video_metadata/?id_video=', ['size' => 1, 'viewers' => 1]);
        # Asserts return an error.
        $response->assertStatus(422);
    }

    /** @test */
    public function only_a_existing_video_can_get_updated()
    {
        #Patch to endpoint without video_id
        $response = $this->patch('/api/update_video_metadata/?id_video=', ['size' => 1, 'viewers' => 1]);
        # Asserts return an error.
        $response->assertStatus(422);
    }
}
