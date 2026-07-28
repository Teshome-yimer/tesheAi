<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Student\CourseViewerController;
use App\Http\Controllers\Admin;

// Public
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/course/{slug}', [CourseController::class, 'show'])->name('course.show');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // Social Auth
    Route::get('/auth/google', [\App\Http\Controllers\Auth\SocialAuthController::class, 'googleRedirect'])->name('auth.google');
    Route::get('/auth/google/callback', [\App\Http\Controllers\Auth\SocialAuthController::class, 'googleCallback'])->name('auth.google.callback');
    Route::get('/auth/github', [\App\Http\Controllers\Auth\SocialAuthController::class, 'githubRedirect'])->name('auth.github');
    Route::get('/auth/github/callback', [\App\Http\Controllers\Auth\SocialAuthController::class, 'githubCallback'])->name('auth.github.callback');
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Checkout (requires auth)
Route::middleware('auth')->group(function () {
    Route::get('/checkout/{slug}', [CheckoutController::class, 'show'])->name('checkout');
    Route::post('/coupon/apply', [CheckoutController::class, 'applyCoupon'])->name('coupon.apply');
    // Payment
    Route::post('/payment/chapa/initiate', [PaymentController::class, 'chapaInitiate'])->name('payment.chapa.initiate');
    Route::get('/payment/chapa/return/{order}', [PaymentController::class, 'chapaReturn'])->name('payment.chapa.return');
    Route::post('/payment/stripe/intent', [PaymentController::class, 'stripeIntent'])->name('payment.stripe.intent');
    Route::get('/payment/stripe/success', [PaymentController::class, 'stripeSuccess'])->name('payment.stripe.success');
});

// Chapa callback (no CSRF)
Route::post('/payment/chapa/callback', [PaymentController::class, 'chapaCallback'])->name('payment.chapa.callback')->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

// Student area
Route::middleware('auth')->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/course/{slug}', [CourseViewerController::class, 'show'])->name('course');
    Route::get('/lesson/{courseSlug}/{lessonSlug}', [CourseViewerController::class, 'lesson'])->name('lesson');
    Route::post('/progress/complete', [CourseViewerController::class, 'markComplete'])->name('progress.complete');
    Route::post('/progress/update', [CourseViewerController::class, 'updateProgress'])->name('progress.update');
    Route::get('/video/{lesson}', [\App\Http\Controllers\Admin\VideoController::class, 'stream'])->name('video.stream');

// File download — public route (controller handles auth check)
Route::get('/files/download/{file}', [\App\Http\Controllers\Student\FileController::class, 'download'])->name('files.download');
});

// Admin auth (sign-in only, no register)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn () => auth()->check() && auth()->user()->isAdmin()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('admin.login'));
    Route::get('/login', [Admin\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [Admin\AuthController::class, 'login'])->middleware('throttle:5,1');
    Route::post('/logout', [Admin\AuthController::class, 'logout'])->name('logout')->middleware('auth');
});

// Admin area
Route::middleware([\App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Courses
    Route::get('/courses', [Admin\CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/create', [Admin\CourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [Admin\CourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/{course}/edit', [Admin\CourseController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/{course}', [Admin\CourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{course}', [Admin\CourseController::class, 'destroy'])->name('courses.destroy');
    Route::post('/courses/{course}/toggle-publish', [Admin\CourseController::class, 'togglePublish'])->name('courses.toggle-publish');

    // Course Content
    Route::get('/courses/{course}/content', [Admin\ContentController::class, 'manage'])->name('courses.content');
    Route::post('/courses/{course}/sections', [Admin\ContentController::class, 'storeSection'])->name('sections.store');
    Route::put('/sections/{section}', [Admin\ContentController::class, 'updateSection'])->name('sections.update');
    Route::delete('/sections/{section}', [Admin\ContentController::class, 'destroySection'])->name('sections.destroy');
    Route::post('/sections/{section}/lessons', [Admin\ContentController::class, 'storeLesson'])->name('lessons.store');
    Route::put('/lessons/{lesson}', [Admin\ContentController::class, 'updateLesson'])->name('lessons.update');
    Route::delete('/lessons/{lesson}', [Admin\ContentController::class, 'destroyLesson'])->name('lessons.destroy');

    // Orders
    Route::get('/orders', [Admin\OrderController::class, 'index'])->name('orders.index');

    // Students
    Route::get('/students', [Admin\StudentController::class, 'index'])->name('students.index');
    Route::post('/users', [Admin\StudentController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [Admin\StudentController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [Admin\StudentController::class, 'destroy'])->name('users.destroy');
    Route::get('/students/enroll', [Admin\StudentController::class, 'enrollForm'])->name('students.enroll-form');
    Route::post('/students/enroll', [Admin\StudentController::class, 'enroll'])->name('students.enroll');

    // File Manager
    Route::get('/courses/{course}/files', [Admin\FileController::class, 'index'])->name('courses.files');
    Route::post('/lessons/{lesson}/files', [Admin\FileController::class, 'upload'])->name('lessons.files.upload');
    Route::delete('/files/{file}', [Admin\FileController::class, 'destroy'])->name('files.destroy');
    Route::post('/files/{file}/toggle-free', [Admin\FileController::class, 'toggleFree'])->name('files.toggle-free');

    // Video Upload
    Route::post('/lessons/{lesson}/video', [Admin\VideoController::class, 'upload'])->name('lessons.video.upload');
    Route::delete('/lessons/{lesson}/video', [Admin\VideoController::class, 'delete'])->name('lessons.video.delete');
    Route::get('/coupons', [Admin\CouponController::class, 'index'])->name('coupons.index');
    Route::get('/coupons/create', [Admin\CouponController::class, 'create'])->name('coupons.create');
    Route::post('/coupons', [Admin\CouponController::class, 'store'])->name('coupons.store');
    Route::get('/coupons/{coupon}/edit', [Admin\CouponController::class, 'edit'])->name('coupons.edit');
    Route::put('/coupons/{coupon}', [Admin\CouponController::class, 'update'])->name('coupons.update');
    Route::delete('/coupons/{coupon}', [Admin\CouponController::class, 'destroy'])->name('coupons.destroy');
});
