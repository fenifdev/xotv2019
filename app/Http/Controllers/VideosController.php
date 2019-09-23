<?php

namespace App\Http\Controllers;

use App\User;
use App\Video;
use Illuminate\Http\Request;

class VideosController extends Controller
{
    public function total_videos_size_by_user()
    {
        # Validate that has username
        $validator = \Validator::make(request()->all(), ['username' => 'required']);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        }

        # Get the user by username;
        $user = User::where('username', request()->username)->firstOrFail();

        # Get the videos created by the user.
        # Calculate the sume of the size for all the user's videos
        # Return the total size.
        return $user->videos->sum('size');
    }

    public function video_metadata()
    {
        # Validates has video_id
        $validator = \Validator::make(request()->all(), ['id_video' => 'required']);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        }

        # Get video
        $video = Video::find(request()->id_video)->firstOrFail();

        # return metadata
        return $video;
    }

    public function update_video_metadata()
    {
        # Validates has video_id
        $validator = \Validator::make(request()->all(), ['id_video' => 'required']);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        }

        #Get video
        $video = Video::find(request()->id_video)->firstOrFail();

        # Update meta data
        if (request()->has('size')) {
            $video->size = request('size');
        }

        if (request()->has('viewers')) {
            $video->viewers = request('viewers');
        }

        $video->save();

        # return metadata
        return $video;
    }
}
