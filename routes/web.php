<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FeedbackController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', fn() => redirect()->to('/login'));

Route::group(['middleware' => 'auth'], function () {
    /*
		|--------------------------------------------------------------------------
		| Feedback Routes
		|--------------------------------------------------------------------------
    */
    Route::prefix('feedback')
        ->whereNumber('id')
        ->group(static function (): void {
            Route::get('/list', [FeedbackController::class, 'index'])
                ->name('feedback.index')
                ->middleware('permission.check:feedback-list');
            Route::get('/create', [FeedbackController::class, 'create'])
                ->name('feedback.create')
                ->middleware('permission.check:feedback-create');
            Route::post('store', [FeedbackController::class, 'store'])
                ->name('feedback.store')
                ->middleware('permission.check:feedback-create');
            Route::get('show/{id}', [FeedbackController::class, 'show'])
                ->name('feedback.show')
                ->middleware('permission.check:feedback-show');
            Route::post('comment/store', [FeedbackController::class, 'comment'])
                ->name('feedback.comment')
                ->middleware('permission.check:feedback-send-comment');
            Route::get('search-users', [FeedbackController::class, 'searchUsers'])->name('search-users');
        });
});

Auth::routes();
