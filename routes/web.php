<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Profile\AvatarController;
use App\Http\Controllers\Profile\ProjectController;
use App\Http\Controllers\Profile\SkillController;
use App\Http\Controllers\Profile\SocialsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Base\PageController;
use App\Http\Controllers\LanguageController;

Route::get('/', [PageController::class,'lander'])->name('lander');


Route::get('/language/{locale}', [LanguageController::class, 'changeLanguage'])
    ->name('change-language');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::middleware('verified')->group(function () {
            Route::patch('/avatar', [AvatarController::class, 'update'])->name('avatar.update');
            Route::delete('/avatar', [AvatarController::class, 'destroy'])->name('avatar.destroy');
            Route::patch('/socials', [SocialsController::class, 'update'])->name('socials.update');
            Route::post('/skills', [SkillController::class, 'store'])->name('skills.store');
            Route::delete('/skills/{skill}', [SkillController::class, 'destroy'])->name('skills.destroy');
            Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
            Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
        });
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
        Route::get('/preview', [ProfileController::class,'preview'])->name('preview');
        Route::get('/skills', [ProfileController::class, 'editSkills'])->name('skills');
        Route::get('/projects', [ProfileController::class, 'editProjects'])->name('projects');
        Route::get('/experiences', [ProfileController::class, 'editExperiences'])->name('experiences');
        Route::get('/socials', [ProfileController::class, 'editSocials'])->name('socials');
    });

    /*
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
    */
});

Route::get('/get/{user:username}/data', [ProfileController::class, 'getData'])->name('profile.get.data');
Route::get('/get/{profile:username}', [ProfileController::class, 'getProfile'])->name('profile.get');
//Route::get('/get/{user:username}/svg', [ProfileController::class, 'getUserSvg'])->name(    'profile.get.svg',);

require __DIR__.'/auth.php';