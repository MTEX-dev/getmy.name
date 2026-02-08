<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProfileController as ApiProfileController;
use App\Http\Controllers\Api\SkillController as ApiSkillController;
use App\Http\Controllers\Api\ProjectController as ApiProjectController;
use App\Http\Controllers\Api\ExperienceController as ApiExperienceController;
use App\Http\Controllers\Api\EducationController as ApiEducationController;
use App\Http\Controllers\Api\SocialsController as ApiSocialsController;
use App\Http\Controllers\Api\AboutMeController as ApiAboutMeController;
use App\Http\Controllers\Api\AvatarController as ApiAvatarController;
use App\Http\Controllers\Api\ApiRequestsController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('profile', ApiProfileController::class)->except(['index', 'show']);
        Route::patch('profile/avatar', [ApiAvatarController::class, 'update']);
        Route::delete('profile/avatar', [ApiAvatarController::class, 'destroy']);
        Route::apiResource('skills', ApiSkillController::class);
        Route::apiResource('projects', ApiProjectController::class);
        Route::apiResource('experiences', ApiExperienceController::class);
        Route::apiResource('education', ApiEducationController::class);
        Route::apiResource('socials', ApiSocialsController::class)->except(['index', 'show']);
        Route::apiResource('about-me', ApiAboutMeController::class)->except(['index', 'show']);

        Route::get('stats/requests/user', [ApiRequestsController::class, 'getAuthUserStats']);
        Route::get('stats/requests/user/{username}', [ApiRequestsController::class, 'getUserStats']);
        Route::get('stats/requests/platform', [ApiRequestsController::class, 'getPlatformStats']);
    });

    Route::get('/profile/{username}', [ApiProfileController::class, 'show']);
    Route::get('/profile/{username}/skills', [ApiSkillController::class, 'index']);
    Route::get('/profile/{username}/projects', [ApiProjectController::class, 'index']);
    Route::get('/profile/{username}/experiences', [ApiExperienceController::class, 'index']);
    Route::get('/profile/{username}/education', [ApiEducationController::class, 'index']);
    Route::get('/profile/{username}/socials', [ApiSocialsController::class, 'index']);
    Route::get('/profile/{username}/about-me', [ApiAboutMeController::class, 'index']);
});