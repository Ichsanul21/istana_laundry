<?php

use App\Http\Controllers\Api\BranchApiController;
use App\Http\Controllers\Api\LocationCheckApiController;
use App\Http\Controllers\Api\ArticleApiController;
use App\Http\Controllers\Api\GalleryApiController;
use App\Http\Controllers\Api\ServiceApiController;
use App\Http\Controllers\Api\PromotionApiController;
use App\Http\Controllers\Api\TestimonialApiController;
use App\Http\Controllers\Api\FaqApiController;
use App\Http\Controllers\Api\SettingApiController;
use Illuminate\Support\Facades\Route;

Route::get('/branches', [BranchApiController::class, 'index']);
Route::post('/location/check', [LocationCheckApiController::class, 'check']);
Route::get('/articles', [ArticleApiController::class, 'index']);
Route::get('/articles/{slug}', [ArticleApiController::class, 'show']);
Route::get('/galleries', [GalleryApiController::class, 'index']);
Route::get('/services', [ServiceApiController::class, 'index']);
Route::get('/promotions', [PromotionApiController::class, 'index']);
Route::get('/testimonials', [TestimonialApiController::class, 'index']);
Route::get('/faqs', [FaqApiController::class, 'index']);
Route::get('/settings', [SettingApiController::class, 'index']);
