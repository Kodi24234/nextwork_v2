<?php

use App\Http\Controllers\Admin\AdminAccountController as AdminAccountController;
// Public Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\JobController as AdminJobController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
// Professional Controllers
use App\Http\Controllers\Auth\CompanyRegistrationController;
use App\Http\Controllers\Auth\RedirectController;
use App\Http\Controllers\Company\DashboardController as CompanyDashboardController;
use App\Http\Controllers\Company\JobController as CompanyJobController;
use App\Http\Controllers\Company\ProfileController as CompanyProfileController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\Professional\ChatController;
use App\Http\Controllers\Professional\ConnectionController;
use App\Http\Controllers\Professional\CvController;
use App\Http\Controllers\Professional\DashboardController as ProfessionalDashboardController;

// Company Controllers
use App\Http\Controllers\Professional\EducationController;
use App\Http\Controllers\Professional\FeedController;
use App\Http\Controllers\Professional\JobApplicationController;

// Admin Controllers
use App\Http\Controllers\Professional\MessageController;
use App\Http\Controllers\Professional\PostCommentController;
use App\Http\Controllers\Professional\PostController;
use App\Http\Controllers\Professional\PostLikeController;
use App\Http\Controllers\Professional\ProfileController;
use App\Http\Controllers\Professional\ProfileSkillController;
use App\Http\Controllers\Professional\PublicProfileController;
use App\Http\Controllers\Professional\WorkExperienceController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//
// ─── Public Routes ───────────────────────────────────────────
//

Route::get('/', function () {
    return Auth::check()
    ? redirect()->route('redirect.dashboard')
    : view('welcome', [
        'userCount'       => \App\Models\User::role('professional')->count(),
        'jobCount'        => \App\Models\Job::where('status', 'open')->count(),
        'connectionCount' => \App\Models\Connection::where('status', 'accepted')->count(),
    ]);
})->name('welcome');

Route::middleware('auth')->group(function () {
    Route::get('/jobs', [JobListingController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/{job}', [JobListingController::class, 'show'])->name('jobs.show');
});

require __DIR__ . '/auth.php';

//
// ─── Authenticated Routes ────────────────────────────────────
//

Route::middleware(['auth', 'verified'])->group(function () {
    // Redirect after login
    Route::get('/redirect-dashboard', [RedirectController::class, 'handle'])->name('redirect.dashboard');

    //
    // ── Professional Features ──
    //
    Route::get('/feed', [FeedController::class, 'index'])->name('feed.index');
    Route::get('/professionals', [PublicProfileController::class, 'index'])->name('professionals.index');
    Route::get('/professionals/{user}', [PublicProfileController::class, 'show'])->name('professionals.show');

    Route::post('/posts/{post}/like', [PostLikeController::class, 'store'])->name('posts.like');
    Route::delete('/posts/{post}/like', [PostLikeController::class, 'destroy'])->name('posts.unlike');
    Route::post('/posts/{post}/comments', [PostCommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [PostCommentController::class, 'destroy'])->name('comments.destroy');

    Route::resource('posts', PostController::class)->only(['store', 'edit', 'update', 'destroy']);
    Route::resource('connections', ConnectionController::class)->only(['store', 'update', 'destroy']);

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');

        Route::resource('experience', WorkExperienceController::class)->only(['store', 'update', 'destroy']);
        Route::resource('education', EducationController::class)->only(['store', 'update', 'destroy']);
        Route::post('skills', [ProfileSkillController::class, 'store'])->name('skills.store');
        Route::delete('skills/{skill}', [ProfileSkillController::class, 'destroy'])->name('skills.destroy');
    });

    Route::post('/jobs/{job}/apply', [JobApplicationController::class, 'store'])->name('jobs.apply');
    Route::post('/notifications/read', function () {
        if (Auth::check()) {
            Auth::user()->unreadNotifications->markAsRead();
        }

        return response()->json(['status' => 'ok']);
    })->name('notifications.read');

    //Personal Space
    Route::get('/yourspace', [ProfessionalDashboardController::class, 'index'])->name('professional.dashboard');
    Route::get('/my-posts', [PostController::class, 'myPosts'])->name('posts.mine');

    //cv
    Route::get('/cv', [CvController::class, 'index'])->name('cv.index');
    Route::patch('/cv', [CvController::class, 'update'])->name('cv.update');
    Route::get('/cv/preview', [CvController::class, 'preview'])->name('cv.preview');
    Route::get('/cv/download', [CvController::class, 'download'])->name('cv.download');

    //Message
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chats/{chat}/messages', [MessageController::class, 'index']);
    Route::post('/chats/{chat}/messages', [MessageController::class, 'store']);
    // New route for sending messages to users (creates chat if needed)
    // New route for sending messages to users (creates chat if needed)
    Route::post('/messages/send-to-user', [MessageController::class, 'sendToUser'])->name('messages.sendToUser');

});

//
// ─── Admin Routes ─────────────────────────────────────────────
//

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/jobs', [AdminJobController::class, 'index'])->name('jobs.index');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');

    // Admin account management
    Route::get('/admins', [AdminAccountController::class, 'index'])->name('admins.index');
    Route::get('/admins/create', [AdminAccountController::class, 'create'])->name('admins.create');
    Route::post('/admins', [AdminAccountController::class, 'store'])->name('admins.store');
    Route::delete('/admins/{user}', [AdminAccountController::class, 'destroy'])->name('admins.destroy');
});

//
// ─── Company Routes ──────────────────────────────────────────
//

Route::get('register/company', [CompanyRegistrationController::class, 'create'])->middleware('guest')->name('company.register.create');
Route::post('register/company', [CompanyRegistrationController::class, 'store'])->middleware('guest')->name('company.register.store');

Route::middleware(['auth', 'role:company'])->prefix('company')->name('company.')->group(function () {
    Route::get('/dashboard', [CompanyDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [CompanyProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [CompanyProfileController::class, 'update'])->name('profile.update');

    Route::resource('jobs', CompanyJobController::class);
    Route::get('/jobs/{job}/applicants', [CompanyJobController::class, 'applicants'])->name('jobs.applicants');
    Route::get('/jobs/{job}/applicants/{applicant}', [CompanyJobController::class, 'showApplicant'])->name('jobs.applicants.show');
});

//
// ─── Fallback ────────────────────────────────────────────────
//

Route::fallback(fn() => redirect('/'));
