<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\LocationCheckController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\ArticleCategoryController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\SeoSettingController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/artikel/{slug}', [App\Http\Controllers\ArticleController::class, 'showBySlug']);

Route::get('/logo.png', function () {
    $logo = base_path('../logo.png');
    if (file_exists($logo)) {
        return response(file_get_contents($logo), 200)
            ->header('Content-Type', 'image/png');
    }
    abort(404);
});

Route::get('/sitemap.xml', [SitemapController::class, 'index']);
Route::get('/robots.txt', [SitemapController::class, 'robots']);

Route::get('/', function () {
    $landingPage = base_path('../index.html');
    if (file_exists($landingPage)) {
        return response(file_get_contents($landingPage), 200)
            ->header('Content-Type', 'text/html');
    }
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('branches', BranchController::class);

        Route::get('location-checks/export', [LocationCheckController::class, 'export'])->name('location-checks.export');
        Route::get('location-checks/{locationCheck}', [LocationCheckController::class, 'show'])->name('location-checks.show');
        Route::get('location-checks', [LocationCheckController::class, 'index'])->name('location-checks.index');

        Route::resource('articles', ArticleController::class);
        Route::post('articles/upload-image', [App\Http\Controllers\Admin\ArticleController::class, 'uploadImage'])->name('articles.upload-image');
        Route::resource('article-categories', ArticleCategoryController::class);

        Route::resource('galleries', GalleryController::class);
        Route::post('galleries/{gallery}/images', [GalleryController::class, 'uploadImage'])->name('galleries.images.upload');
        Route::delete('galleries/images/{image}', [GalleryController::class, 'deleteImage'])->name('galleries.images.destroy');
        Route::post('galleries/{gallery}/reorder', [GalleryController::class, 'reorderImages'])->name('galleries.images.reorder');

        Route::resource('services', ServiceController::class);
        Route::resource('promotions', PromotionController::class);
        Route::resource('testimonials', TestimonialController::class);
        Route::resource('faqs', FaqController::class);

        Route::get('seo-settings', [SeoSettingController::class, 'index'])->name('seo-settings.index');
        Route::get('seo-settings/{seoSetting}/edit', [SeoSettingController::class, 'edit'])->name('seo-settings.edit');
        Route::put('seo-settings/{seoSetting}', [SeoSettingController::class, 'update'])->name('seo-settings.update');

        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    });

require __DIR__.'/auth.php';
