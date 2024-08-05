<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Post;
use App\Models\Review;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {

        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return view('dashboard');
    }
    public function welcome()
    {
        $users = User::where('role', 'resort')->with('userInfo')->get();
        return view('welcome', compact('users'));
    }
    public function resort($name) {
        // Fetch the user by name and ensure the user is a resort
        $user = User::where('name', $name)->where('role', 'resort')->with('userinfo')->firstOrFail();

        // Check if the authenticated user is the owner of the profile
        $isOwner = Auth::check() && Auth::id() === $user->id;

        // Fetch reviews for the specified user and calculate the average rating
        $averageRating = Review::where('resort_id', $user->id)->avg('rating');

        // Ensure the average rating does not exceed 5
        $averageRating = min($averageRating, 5);

        // Fetch posts for the specified user with their associated files
        $posts = Post::where('user_id', $user->id)->with('files')->get();

        return view('resort.resort-profile', compact('user', 'isOwner', 'averageRating', 'posts'));
    }


    public function resortRoom($name)
    {
        $user = User::where('name', $name)->where('role', 'resort')->with('userinfo')->first();
        $isOwner = false;
        // Fetch reviews for the resort user and calculate the average rating
        $averageRating = Review::where('resort_id', $user->id)->avg('rating');

        // Ensure the average rating does not exceed 5
        $averageRating = min($averageRating, 5);
        $rooms = Room::with('images')->where('user_id', $user->id)->get();
        return view('resort.room', compact('user', 'isOwner', 'rooms', 'averageRating'));
    }
}
