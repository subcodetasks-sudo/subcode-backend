<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\FQController;
// Import all new Api Controllers
use App\Http\Controllers\Api\V1\BlogController;
use App\Http\Controllers\Api\V1\PageController;
use App\Http\Controllers\Api\V1\AdminController;
use App\Http\Controllers\Api\V1\AboutUsController;
use App\Http\Controllers\Api\V1\FeatureController;
use App\Http\Controllers\Api\V1\PackageController;
use App\Http\Controllers\Api\V1\ProjectController;
use App\Http\Controllers\Api\V1\ServiceController;
use App\Http\Controllers\Api\V1\SettingController;
use App\Http\Controllers\Api\V1\VisitorController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\DepartmentController;
use App\Http\Controllers\Api\V1\TestimonialController;
use App\Http\Controllers\Api\V1\TeamMemberController;
use App\Http\Controllers\Api\V1\WebsiteController;
use App\Http\Controllers\Api\V1\SuccessNumberController;
use App\Http\Controllers\Api\V1\ReviewProjectController;
use App\Http\Controllers\Api\V1\FeaturePackageController;
use App\Http\Controllers\Api\V1\PartnerSuccessController;
use App\Http\Controllers\Api\V1\AdvantageProjectController;
use App\Http\Controllers\Api\V1\OccasionController;
use App\Http\Controllers\Api\V1\SectorController;
use App\Http\Controllers\Api\V1\RedirectController;
use App\Http\Controllers\Api\V1\SlugController;

// Route::prefix('v1')->group(function () {

    Route::controller(PageController::class)->group(function () {

        Route::get('testimonials', 'testimonials');
        Route::post('news-letters', 'newsLetter');

    });

    Route::controller(BlogController::class)->group(function () {
        Route::get('category-with-blogs', 'categoryWithBlog');
        Route::get('blog/{slug}', 'singleBlog')->name('blog.single');
        Route::get('all-blog', 'index')->name('blog.all');

    });

    // Partner Successes routes
    Route::get('partner-successes', [PartnerSuccessController::class, 'index']);
    Route::get('partner-successes/{id}', [PartnerSuccessController::class, 'show']);
    


     // About Us routes
    Route::get('about-us', [AboutUsController::class, 'index']);
    // Route::get('about-us/{id}', [AboutUsController::class, 'show']);

     // Services routes
    Route::get('services', [ServiceController::class, 'index']);
    Route::get('services/{id}', [ServiceController::class, 'show']);


     // Departments routes (supports slug)
    Route::get('departments', [DepartmentController::class, 'index']);
    Route::get('departments/{slug}', [DepartmentController::class, 'show']);



    // Projects routes
    Route::get('projects', [ProjectController::class, 'index']);
    Route::get('projects/{slug}', [ProjectController::class, 'show']);
    Route::get('projects-special', [ProjectController::class, 'specialProjects']);


   

    // Packages routes
    Route::get('packages', [PackageController::class, 'index']);
    Route::get('packages/{id}', [PackageController::class, 'show']);

       // Feature Packages routes
    Route::get('feature-packages', [FeaturePackageController::class, 'index']);
    // Route::get('feature-packages/{id}', [FeaturePackageController::class, 'show']);

    

    // Testimonials routes (Full CRUD)
    Route::get('testimonials', [TestimonialController::class, 'index']);
    Route::get('testimonials/{id}', [TestimonialController::class, 'show']);
    Route::post('testimonials', [TestimonialController::class, 'store']);
    Route::put('testimonials/{id}', [TestimonialController::class, 'update']);
    Route::delete('testimonials/{id}', [TestimonialController::class, 'destroy']);

    // Team Members routes (Full CRUD)
    Route::get('team', [TeamMemberController::class, 'index']);

    // Websites routes (includes subscriptions as nested resource)
    Route::get('websites', [WebsiteController::class, 'index']);
    Route::get('websites/{slug}', [WebsiteController::class, 'show']);

    // Success Numbers routes
    Route::get('success-numbers', [SuccessNumberController::class, 'index']);

    // FAQs routes
    Route::get('fqs', [FQController::class, 'index']);
    Route::get('fqs/{id}', [FQController::class, 'show']);

   

    // Settings routes
    Route::get('settings', [SettingController::class, 'index']);
    Route::get('settings/scripts', [SettingController::class, 'scripts']);
    Route::get('settings/robots', [SettingController::class, 'robots']);

    Route::get('all-slugs', [SlugController::class, 'index']);
    Route::get('all-slugs/{locale}', [SlugController::class, 'index']);

    // Features routes
    Route::get('features', [FeatureController::class, 'index']);
    Route::get('features/{id}', [FeatureController::class, 'show']);



    // Advantage Projects routes
    Route::get('advantage-projects', [AdvantageProjectController::class, 'index']);
    Route::get('advantage-projects/{id}', [AdvantageProjectController::class, 'show']);

    // Review Projects routes
    Route::get('review-projects', [ReviewProjectController::class, 'index']);
    Route::get('review-projects/{id}', [ReviewProjectController::class, 'show']);

    // Occasions routes
    Route::get('occasions', [OccasionController::class, 'index']);
    Route::get('occasions/{slugOrId}', [OccasionController::class, 'show']);

    // Sectors routes
    Route::get('sectors', [SectorController::class, 'index']);



    
    // Categories routes (supports slug)
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{slugOrId}', [CategoryController::class, 'show']);


      Route::post('/visitor', [VisitorController::class, 'track']);

    Route::get('redirects/resolve', [RedirectController::class, 'resolve']);
// });
