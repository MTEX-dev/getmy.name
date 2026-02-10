<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Profile\{AvatarController, ProjectController, SkillController, SocialsController, ExperienceController, EducationController, ApiRequestController, AboutMeController, ApiTokenController};
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Base\PageController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ApiDocumentationController;
use App\Http\Controllers\StatsController;

Route::get('/', [PageController::class, 'lander'])->name('lander');
Route::get('/language/{locale}', [LanguageController::class, 'changeLanguage'])->name('change-language');
Route::get('/sitemap', [PageController::class, 'sitemap'])->name('sitemap');
Route::get('/dashboard', [PageController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/stats/{metric}', [StatsController::class, 'index'])->name('stats.platform');
Route::get('/stats/data/{metric}', [StatsController::class, 'getData'])->name('stats.data');
Route::get('/stats/data/{metric}', [StatsController::class, 'getData'])->name('stats.platform.data');

Route::middleware('auth')->group(function () {
    //Route::prefix('profile')->name('profile.')->group(function () {

    //Route::middleware('verified')->prefix('stats')->name('stats.')->group(function () {
    Route::prefix('stats')->name('stats.')->group(function () {
        Route::get('/api-requests', [StatsController::class, 'apiRequests'])->name('api-requests');
        Route::get('/api-requests-data', [StatsController::class, 'getApiRequestData'])->name('api-requests.data');
    });

    Route::prefix('settings')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::get('/password', [ProfileController::class, 'password'])->name('password');
        Route::get('/avatar', [ProfileController::class, 'avatar'])->name('avatar');
        Route::get('/design', [ProfileController::class, 'design'])->name('design');
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
            Route::patch('/skills/{skill}', [SkillController::class, 'update'])->name('skills.update'); // Add this
            Route::delete('/skills/{skill}', [SkillController::class, 'destroy'])->name('skills.destroy');Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
            Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
            Route::patch('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
            Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
            Route::delete('/projects/{project}/image', [ProjectController::class, 'removeImage'])->name('projects.image.remove');
            Route::post('/projects/{project}/technologies', [ProjectController::class, 'addTechnology'])->name('projects.technologies.add');
            Route::patch('/projects/{project}/technologies/{technology}', [ProjectController::class, 'updateTechnology'])->name('projects.technologies.update');
            Route::delete('/projects/{project}/technologies/{technology}', [ProjectController::class, 'removeTechnology'])->name('projects.technologies.remove');
            Route::post('/projects/{project}/features', [ProjectController::class, 'addFeature'])->name('projects.features.add');
            Route::patch('/projects/{project}/features/{feature}', [ProjectController::class, 'updateFeature'])->name('projects.features.update');
            Route::delete('/projects/{project}/features/{feature}', [ProjectController::class, 'removeFeature'])->name('projects.features.remove');
            Route::post('/experiences', [ExperienceController::class, 'store'])->name('experiences.store');
            Route::get('/experiences/{experience}/edit', [ExperienceController::class, 'edit'])->name('experiences.edit');
            Route::patch('/experiences/{experience}', [ExperienceController::class, 'update'])->name('experiences.update');
            Route::delete('/experiences/{experience}', [ExperienceController::class, 'destroy'])->name('experiences.destroy');
            Route::post('/education', [EducationController::class, 'store'])->name('education.store');
            Route::get('/education/{education}/edit', [EducationController::class, 'edit'])->name('education.edit');
            Route::patch('/education/{education}', [EducationController::class, 'update'])->name('education.update');
            Route::delete('/education/{education}', [EducationController::class, 'destroy'])->name('education.destroy');
            Route::get('/api-requests', [ApiRequestController::class, 'index'])->name('api-requests.index');
            Route::get('/api-requests-data', [ApiRequestController::class, 'getApiRequestData'])->name('api-requests.data');
            Route::get('/api-tokens', [ApiTokenController::class, 'index'])->name('api-tokens.index');
            Route::post('/api-tokens', [ApiTokenController::class, 'store'])->name('api-tokens.store');
            Route::delete('/api-tokens/{tokenId}', [ApiTokenController::class, 'destroy'])->name('api-tokens.destroy');
            Route::get('/activity', [ProfileController::class, 'activity'])->name('activity');
        });

        Route::patch('/avatar', [AvatarController::class, 'update'])->name('avatar.update');
        Route::delete('/avatar', [AvatarController::class, 'destroy'])->name('avatar.destroy');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
        Route::get('/preview/{template?}', [ProfileController::class, 'preview'])->name('preview');
    });
});

Route::get('/get/{username}/data', [ProfileController::class, 'getData'])->name('profile.get.data');
Route::get('/get/{username}/{template?}', [ProfileController::class, 'getProfile'])->name('profile.get');

Route::get('/legal/{section}', [PageController::class, 'legal'])->name('legal');
Route::get('/api-docs', [ApiDocumentationController::class, 'index'])->name('api-docs');

require __DIR__ . '/auth.php';