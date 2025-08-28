<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Base\PageController;

Route::get('/', [PageController::class,'lander'])->name('lander');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::patch('/avatar', [ProfileController::class, 'updateAvatar'])->name('avatar.update');
        Route::delete('/avatar', [ProfileController::class, 'destroyAvatar'])->name('avatar.destroy');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
        Route::get('/preview', [ProfileController::class,'preview'])->name('preview');
    });

    // Portfolio Profile Management
    Route::prefix('my-profile')->name('profiles.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/create', [ProfileController::class, 'create'])->name('create');
        Route::post('/', [ProfileController::class, 'store'])->name('store');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');

        // Skills
        Route::post('/skills', [ProfileController::class, 'addSkill'])->name('skills.store');
        Route::delete('/skills/{skill}', [ProfileController::class, 'destroySkill'])->name('skills.destroy');

        // Projects
        Route::get('/projects/create', [ProfileController::class, 'createProfileProject'])->name('projects.create');
        Route::post('/projects', [ProfileController::class, 'storeProfileProject'])->name('projects.store');
        Route::get('/projects/{profileProject}/edit', [ProfileController::class, 'editProfileProject'])->name('projects.edit');
        Route::patch('/projects/{profileProject}', [ProfileController::class, 'updateProfileProject'])->name('projects.update');
        Route::delete('/projects/{profileProject}', [ProfileController::class, 'destroyProfileProject'])->name('projects.destroy');

        // Socials
        Route::get('/socials/edit', [ProfileController::class, 'editProfileSocials'])->name('socials.edit');
        Route::patch('/socials', [ProfileController::class, 'updateProfileSocials'])->name('socials.update');
    });
});

Route::get('/get/{user:username}/data', [ProfileController::class, 'getData'])->name('get.data');
Route::get('/get/{profile:username}', [ProfileController::class, 'getProfile'])->name('profiles.get');

require __DIR__.'/auth.php';