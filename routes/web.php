<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Student\CourseViewerController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

// Sitemap
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Public
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/course/{slug}', [CourseController::class, 'show'])->name('course.show');
// login route timer
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:login');


Route::view('/privacy-policy', 'privacy')->name('privacy');
Route::view('/terms', 'terms')->name('terms');
Route::view('/contact', 'contact')->name('contact');
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

    // Password Reset (request form + send link)
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    // Password Reset (reset form + update)
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});

// Primary logout (POST only) — keeps CSRF protection intact
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Safe GET fallback for convenience (avoids 419 when someone visits /logout directly).
// Prefer the POST form with @csrf in the UI; this GET route is a convenience and only
// runs for authenticated users to avoid accidental logouts for guests.
Route::middleware('auth')->get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout.get');

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

// Free PDF documents — for registered (logged-in) users only
Route::middleware('auth')->prefix('documents')->name('documents.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Student\DocumentController::class, 'index'])->name('index');
    Route::get('/{document}/read', [\App\Http\Controllers\Student\DocumentController::class, 'read'])->name('read');
    Route::get('/{document}/view', [\App\Http\Controllers\Student\DocumentController::class, 'view'])->name('view');
    Route::get('/{document}/download', [\App\Http\Controllers\Student\DocumentController::class, 'download'])->name('download');
});

// Online quizzes — for registered (logged-in) users only
Route::middleware('auth')->prefix('quizzes')->name('quizzes.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Student\QuizController::class, 'index'])->name('index');
    Route::get('/{quiz}/take', [\App\Http\Controllers\Student\QuizController::class, 'take'])->name('take');
    Route::post('/{quiz}/question/{question}/check', [\App\Http\Controllers\Student\QuizController::class, 'check'])->name('question.check');
    Route::post('/{quiz}/submit', [\App\Http\Controllers\Student\QuizController::class, 'submit'])->name('submit');
    Route::get('/result/{attempt}', [\App\Http\Controllers\Student\QuizController::class, 'result'])->name('result');
});

// Chapa callback (no CSRF)
Route::post('/payment/chapa/callback', [PaymentController::class, 'chapaCallback'])->name('payment.chapa.callback')->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

// Student area
Route::middleware('auth')->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/course/{slug}', [CourseViewerController::class, 'show'])->name('course');
    Route::post('/progress/complete', [CourseViewerController::class, 'markComplete'])->name('progress.complete');
    Route::post('/progress/update', [CourseViewerController::class, 'updateProgress'])->name('progress.update');
    Route::get('/video/{lesson}', [\App\Http\Controllers\Admin\VideoController::class, 'stream'])->name('video.stream');
});

// Lesson viewer — guests can view free preview lessons
Route::prefix('student')->name('student.')->group(function () {
    Route::get('/lesson/{courseSlug}/{lessonSlug}', [CourseViewerController::class, 'lesson'])->name('lesson');
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

// Safe GET fallback for admin logout (convenience) — protected by auth middleware.
Route::middleware('auth')->get('/admin/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('admin.login');
})->name('admin.logout.get');

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

    // PDF Documents (free library)
    Route::get('/documents', [Admin\DocumentController::class, 'index'])->name('documents.index');
    Route::post('/documents', [Admin\DocumentController::class, 'store'])->name('documents.store');
    Route::put('/documents/{document}', [Admin\DocumentController::class, 'update'])->name('documents.update');
    Route::post('/documents/{document}/toggle-publish', [Admin\DocumentController::class, 'togglePublish'])->name('documents.toggle-publish');
    Route::delete('/documents/{document}', [Admin\DocumentController::class, 'destroy'])->name('documents.destroy');

    // Quizzes (online exams)
    Route::get('/quizzes', [Admin\QuizController::class, 'index'])->name('quizzes.index');
    Route::post('/quizzes', [Admin\QuizController::class, 'store'])->name('quizzes.store');
    Route::put('/quizzes/{quiz}', [Admin\QuizController::class, 'update'])->name('quizzes.update');
    Route::post('/quizzes/{quiz}/toggle-publish', [Admin\QuizController::class, 'togglePublish'])->name('quizzes.toggle-publish');
    Route::delete('/quizzes/{quiz}', [Admin\QuizController::class, 'destroy'])->name('quizzes.destroy');
    Route::get('/quizzes/{quiz}/questions', [Admin\QuizController::class, 'questions'])->name('quizzes.questions');
    Route::post('/quizzes/{quiz}/questions', [Admin\QuizController::class, 'storeQuestion'])->name('quizzes.questions.store');
    Route::put('/quiz-questions/{question}', [Admin\QuizController::class, 'updateQuestion'])->name('quizzes.questions.update');
    Route::delete('/quiz-questions/{question}', [Admin\QuizController::class, 'destroyQuestion'])->name('quizzes.questions.destroy');

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
    
     ///new thumbnail route
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;

Route::get('/storage/thumbnails/{filename}', function ($filename) {
    // 🛡️ የፓዝ ትራቨርሳል (path traversal) ጥቃትን ለመከላከል የፋይሉን ስም ብቻ እንወስዳለን።
    // ማንኛውንም ../ ወይም / የያዘ ስም ያጸዳል።
    $safe_filename = basename($filename);

    // 1. መጀመሪያ storage/app/public/thumbnails/ ውስጥ ይፈልጋል
    $path = storage_path('app/public/thumbnails/' . $safe_filename);

    // 2. እዚያ ከሌለ storage/app/thumbnails/ ውስጥ ይፈልጋል
    if (!file_exists($path)) {
        $path = storage_path('app/thumbnails/' . $safe_filename);
    }

    // ፋይሉ በጭራሽ ከሌለ 404 ይሰጣል
    if (!file_exists($path)) {
        abort(404, 'File not found.');
    }

    // ፋይሉን ለማንበብ ፍቃድ መኖሩን እናረጋግጥ
    if (!is_readable($path)) {
        Log::error("File exists but is not readable: " . $path);
        abort(500, 'File permission error.');
    }

    // ፋይሉን እና የፋይል ዝርዝሩን (mime type) እናንብብ
    $file = file_get_contents($path);
    $type = mime_content_type($path);

    // ምስሉን እንደ Response እንላክ
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});
