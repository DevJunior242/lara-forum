<?php

use App\Http\Middleware\Userbanned;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotifController;
use App\Http\Middleware\TrackOnlineUsers;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserBannedController;


Route::fallback(function () {
    return response()->view('error.404');
});
Route::middleware(['auth', 'verified', 'throttle'])->group(function () {
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/', [PostController::class, 'index'])->name('home');
    Route::get('/showPost/{hashid}/{connection}', [PostController::class, 'show'])->name('show');
    Route::get('post', [PostController::class, 'post'])->name('post');
    Route::post('postStore', [PostController::class, 'postStore']);
    Route::get('postEdit/{hashid}/{connection}', [PostController::class, 'postEdit']);
    Route::post('postUpdate/{hashid}/{connection}', [PostController::class, 'postUpdate']);
    Route::get('postDelete/{hashid}/{connection}', [PostController::class, 'postDelete']);
    //ajouter commentaire au post 
    Route::get('/posts/{postId}/comments', [CommentController::class, 'index'])
        ->name('comments.index');

    Route::post('updateComment/{commentId}', [CommentController::class, 'updateComment'])->name('updateComment');

    Route::post('deleteComment/{commentId}', [CommentController::class, 'deleteComment'])->name('deleteComment');
    Route::post('comment/{postId}', [CommentController::class, 'comment'])->name('comment');
    Route::post('reply/{commentId}', [CommentController::class, 'reply'])->name('reply');
    Route::post('like/comment/{comment}', [CommentController::class, 'likeComment'])->name('commentLike');
    Route::post('like/reply/{reply}', [CommentController::class, 'replyLike'])->name('replyLike');
    Route::get('comments/{comment}', [CommentController::class, 'show'])->name('comments');
    Route::delete('comments/{commentId}', [CommentController::class, 'delete'])->name('comments.delete');

    Route::get('notification', [NotifController::class, 'index'])->name('notif');
    Route::get('notification/{id}', [NotifController::class, 'markAsRead'])->name('read');
});

Route::get('/online', [UserController::class, 'online'])->name('online')->middleware(TrackOnlineUsers::class);
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/registerPost', [UserController::class, 'registerPost'])->name('registerPost');
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/loginUpdate', [UserController::class, 'loginUpdate'])->name('loginUpdate');
//emailVerify

Route::get('/email/verify', [UserController::class, 'emailVerify'])->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [UserController::class, 'emailVerifyUpdate'])->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/resend', [UserController::class, 'emailResend'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');

//reset password

Route::get('/forgot-password', [UserController::class, 'forgotPassword'])
    ->middleware('guest')->name('password.request');

Route::post('/forgot-password', [UserController::class, 'PasswordEmail'])->middleware('guest')->name('password.email');
Route::get('/reset-password/{token}', [UserController::class, 'resetPassword'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [UserController::class, 'resetPasswordUpdate'])->middleware('guest')->name('password.update');
///login with google and facebook

Route::controller(GoogleController::class)->group(function () {
    Route::get('auth/google', 'redirectToGoogle')->name('auth.google');
    Route::get('auth/google/callback', 'handleGoogleCallback');
});

//bannir un utilisateur
Route::middleware(['auth', 'Userbanned'])->group(function () {
    Route::post('user/{id}/ban', [UserBannedController::class, 'ban'])

        ->name('ban');
    Route::post('user/{id}/unban', [UserBannedController::class, 'unban'])
        ->name('unban');
});


Route::get('test', function () {
    return view('test');
});
