<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Resort\ImageController;
use App\Http\Controllers\Resort\ResortController;
use App\Http\Controllers\Resort\RoomController;
use App\Http\Controllers\Resort\UploadTemporaryImageController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\User\UserController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [UserController::class, 'welcome']);

Route::get('/dashboard', [UserController::class, 'dashboard'])->middleware(['auth', 'verified', 'PreventBackHistory'])->name('dashboard');



Route::middleware(['auth', 'PreventBackHistory'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //room book
    Route::get('/resort/room/book/{id}', [BookingController::class, 'booking'])->name('room.book');
    Route::post('bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/mybooking', [BookingController::class, 'mybooking'])->name('user.mybooking');
    Route::post('/booking/cancel/{id}', [BookingController::class, 'bookingCancel'])->name('booking.cancel');

    Route::post('/reviews/store/{room}', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/resort/profile/{name}', [UserController::class, 'resort'])->name('resort.profiles');
Route::get('resort/room/{name}', [UserController::class, 'resortRoom'])->name('resort.Room');
});

require __DIR__ . '/auth.php';


/**------------Admin----------------- */
Route::middleware(['auth', 'role:admin', 'PreventBackHistory'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

/**------------Resort----------------- */
Route::middleware(['guest', 'PreventBackHistory'])->group(function () {

    Route::get('resort/register', [ResortController::class, 'create'])->name('resort.register');
    Route::post('register', [ResortController::class, 'store'])->name('resort.store');
});
Route::middleware(['auth', 'role:resort', 'PreventBackHistory'])->group(function () {

    Route::get('/resort/profile', [ResortController::class, 'profile'])->name('resort.profile');
    //ROOM
    Route::get('/resort/room', [RoomController::class, 'room'])->name('resort.room');
    Route::get('resort/add-room', [RoomController::class, 'create'])->name('room.create');
    Route::post('resort/store', [RoomController::class, 'store'])->name('room.store');
    Route::put('resort/update/{room}', [RoomController::class, 'update'])->name('room.update');
    Route::delete('resort/delete/{room}', [RoomController::class, 'destroy'])->name('room.delete');
    Route::get('resort/roomEdit/{id}', [RoomController::class, 'edit'])->name('room.edit');
   // Route::put('resort/room/{id}/update', [RoomController::class, 'update'])->name('room.update');
    Route::delete('/image/{id}', [ImageController::class, 'destroy'])->name('image.destroy');
    Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('room.destroy');

    //booking
    Route::get('/resort/booking', [ResortController::class, 'booking'])->name('resort.booking');
    Route::get('/resort/bookings/{booking}', [ResortController::class, 'bookingShow'])->name('bookings.show');
    Route::get('/bookings/{booking}/checkout', [BookingController::class, 'check_outView'])->name('bookings.checkout');
    Route::patch('/bookings/{booking}/checkout', [BookingController::class, 'check_out'])->name('bookings.checkOut');
    Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateBooking'])->name('bookings.updateBooking');
    Route::patch('/booking/accept/{id}', [BookingController::class, 'bookingAccept'])->name('booking.accept');
    //calendar
    Route::get('/bookings/calendar', [BookingController::class, 'calendar'])->name('bookings.calendar');
    Route::get('/bookings/events', [BookingController::class, 'getEvents'])->name('bookings.events');

    //post
    Route::post('resort/post', [PostController::class, 'post'])->name('resort.post');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');


});

//IMAGE FilePond
Route::post('/upload', [UploadTemporaryImageController::class, 'uploadTempImage']);
Route::delete('/delete', [UploadTemporaryImageController::class, 'deleteTempImage']);
//Profile and Cover photo update
Route::patch('/resort/changeProfile', [ProfileController::class, 'profilePhoto'])->name('profilePhoto');
Route::patch('/resort/changeCoverPhoto', [ProfileController::class, 'coverPhoto'])->name('coverPhoto');
