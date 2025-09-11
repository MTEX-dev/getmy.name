<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Profile\AvatarController;
use App\Http\Controllers\Profile\ProjectController;
use App\Http\Controllers\Profile\SkillController;
use App\Http\Controllers\Profile\SocialsController;
use App\Http\Controllers\Profile\ExperienceController;
use App\Http\Controllers\Profile\EducationController;
use App\Http\Controllers\Profile\ApiRequestController;
use App\Http\Controllers\Profile\AboutMeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Base\PageController;
use App\Http\Controllers\LanguageController;

Route::get('/', [PageController::class,'lander'])->name('lander');


Route::get('/language/{locale}', [LanguageController::class, 'changeLanguage'])
    ->name('change-language');

Route::get('/sitemap', [PageController::class, 'sitemap'])->name('sitemap'); // NEW ROUTE

Route::get('/dashboard', [PageController::class , 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::patch('/template', [ProfileController::class, 'updateTemplate'])->name('template.update');
        Route::middleware('verified')->group(function () {
            Route::get('/skills', [ProfileController::class, 'editSkills'])->name('skills');
            Route::get('/projects', [ProfileController::class, 'editProjects'])->name('projects');
            Route::get('/experiences', [ProfileController::class, 'editExperiences'])->name('experiences');
            Route::get('/education', [ProfileController::class, 'editEducation'])->name('education');
            Route::get('/socials', [ProfileController::class, 'editSocials'])->name('socials');
            Route::get('/about-me', [AboutMeController::class, 'edit'])->name('about-me');


            Route::patch('/socials', [SocialsController::class, 'update'])->name('socials.update');
            Route::patch('/about-me', [AboutMeController::class, 'update'])->name('about-me.update');
            Route::post('/skills', [SkillController::class, 'store'])->name('skills.store');
            Route::delete('/skills/{skill}', [SkillController::class, 'destroy'])->name('skills.destroy');
            Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
            Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
            Route::patch('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
            Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
            Route::post('/experiences', [ExperienceController::class, 'store'])->name('experiences.store');
            Route::delete('/experiences/{experience}', [ExperienceController::class, 'destroy'])->name('experiences.destroy');
            Route::post('/education', [EducationController::class, 'store'])->name('education.store');
            Route::delete('/education/{education}', [EducationController::class, 'destroy'])->name('education.destroy');


            Route::get('/api-requests', [ApiRequestController::class, 'index'])->name('api-requests.index');
            Route::get('/api-requests-data', [ApiRequestController::class, 'getApiRequestData'])->name('api-requests.data');

            Route::get('/api-tokens', [\App\Http\Controllers\Profile\ApiTokenController::class, 'index'])->name('api-tokens.index');
            Route::post('/api-tokens', [\App\Http\Controllers\Profile\ApiTokenController::class, 'store'])->name('api-tokens.store');
            Route::delete('/api-tokens/{tokenId}', [\App\Http\Controllers\Profile\ApiTokenController::class, 'destroy'])->name('api-tokens.destroy');
        });
        Route::patch('/avatar', [AvatarController::class, 'update'])->name('avatar.update');
        Route::delete('/avatar', [AvatarController::class, 'destroy'])->name('avatar.destroy');

        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
        Route::get('/preview', [ProfileController::class,'preview'])->name('preview');
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

/*
Route::get('/get/{user:username}/data', [ProfileController::class, 'getData'])->name('profile.get.data');
Route::get('/get/{user:username}', [ProfileController::class, 'getProfile'])->name('profile.get');
*/
Route::get('/get/{username}/data', [ProfileController::class, 'getData'])->name('profile.get.data');
Route::get('/get/{username}', [ProfileController::class, 'getProfile'])->name('profile.get');
//Route::get('/get/{user:username}/svg', [ProfileController::class, 'getUserSvg'])->name(    'profile.get.svg',);

Route::get('/legal/{section}', [PageController::class, 'legal'])->name('legal');
Route::get('/api-docs', [\App\Http\Controllers\ApiDocumentationController::class, 'index'])->name('api-docs');

require __DIR__.'/auth.php';