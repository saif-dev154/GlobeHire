<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ErrorController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Agent\AgentController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Agent\AgentVisaController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\AdminAgentsController;
use App\Http\Controllers\Employer\EmployerController;
use App\Http\Controllers\Candidate\CandidateController;
use App\Http\Controllers\Admin\AdminEmployersController;
use App\Http\Controllers\Agent\AgentInterviewsController;
use App\Http\Controllers\Employer\EmployerJobsController;
use App\Http\Controllers\Agent\AgentApplicationsController;
use App\Http\Controllers\Candidate\CandidateJobsController;
use App\Http\Controllers\Candidate\CandidateVisaController;
use App\Http\Controllers\Agent\AgentFlightScheduleController;
use App\Http\Controllers\Employer\EmployerContractsController;
use App\Http\Controllers\Employer\EmployerInterviewsController;
use App\Http\Controllers\Candidate\CandidateContractsController;
use App\Http\Controllers\Candidate\CandidateInterviewController;
use App\Http\Controllers\Candidate\CandidateApplicationController;
use App\Http\Controllers\Candidate\CandidateFlightScheduleController;






// Default route
Route::get('/', function () {
     return view('welcome');
});


 




// Error Routes (Using Controller in Auth folder)
Route::get('/error/403', [ErrorController::class, 'error403'])->name('error.403');
Route::get('/error/404', [ErrorController::class, 'error404'])->name('error.404');



Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);



// Auth Routes
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', RoleMiddleware::class . ':admin'])->prefix('admin')->name('admin.')->group(function () {
     Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
     Route::resource('users', AdminUsersController::class)->except(['show']);
     Route::get('users/agents', [AdminAgentsController::class, 'index'])->name('users.agents.index');
     Route::get('users/employers', [AdminEmployersController::class, 'index'])->name('users.employers.index');
     Route::patch('/users/{id}/toggle-status', [AdminUsersController::class, 'toggleStatus'])->name('users.toggle-status');
});

// Employer Routes
Route::middleware(['auth', RoleMiddleware::class . ':employer'])->prefix('employer')->name('employer.')->group(function () {
     Route::get('dashboard', [EmployerController::class, 'index'])->name('dashboard');
     Route::resource('jobs', EmployerJobsController::class);
     Route::get('interviews/passed', [EmployerInterviewsController::class, 'passed'])->name('interviews.passed');
     Route::patch('interviews/{id}/shortlist', [EmployerInterviewsController::class, 'shortlist'])->name('interviews.shortlist');
     Route::patch('interviews/{id}/reject', [EmployerInterviewsController::class, 'reject'])->name('interviews.reject');
     Route::get('interviews/shortlisted', [EmployerInterviewsController::class, 'shortlisted'])->name('interviews.shortlisted');

     Route::get('employer/contracts/create/{interview}', [EmployerContractsController::class, 'create'])->name('contracts.create');
     Route::post('employer/contracts', [EmployerContractsController::class, 'store'])->name('contracts.store');
     Route::get('contracts', [EmployerContractsController::class, 'index'])->name('contracts.index');


     Route::get('contracts/{contract}/show', [EmployerContractsController::class, 'show'])->name('contracts.show');
     Route::get('contracts/{contract}/edit', [EmployerContractsController::class, 'edit'])->name('contracts.edit');
     Route::put('contracts/{contract}', [EmployerContractsController::class, 'update'])->name('contracts.update');
     Route::delete('contracts/{contract}', [EmployerContractsController::class, 'destroy'])->name('contracts.destroy');
     Route::get('contracts/{contract}/signature', [EmployerContractsController::class, 'showSignature'])->name('contracts.showSignature');
     Route::post('contracts/{contract}/approve', [EmployerContractsController::class, 'approve'])->name('contracts.approve');
     Route::post('contracts/{contract}/reject', [EmployerContractsController::class, 'reject'])->name('contracts.reject');
});


// Agent Routes
Route::middleware(['auth', RoleMiddleware::class . ':agent'])->prefix('agent')->name('agent.')->group(function () {
     Route::get('/dashboard', [AgentController::class, 'index'])->name('dashboard');
     // applications
     Route::get('applications', [AgentApplicationsController::class, 'index'])->name('applications.index');
     Route::get('applications/{id}', [AgentApplicationsController::class, 'show'])->name('applications.show');
     Route::post('applications/{id}/reject', [AgentApplicationsController::class, 'reject'])->name('applications.reject');


     // interviews
     Route::post('/applications/{id}/interview', [AgentInterviewsController::class, 'store'])->name('applications.interview.store');
     Route::get('interviews', [AgentInterviewsController::class, 'index'])->name('interviews.index');
     Route::get('interviews/{id}/edit', [AgentInterviewsController::class, 'edit'])->name('interviews.edit');
     Route::patch('interviews/{id}', [AgentInterviewsController::class, 'update'])->name('interviews.update');
     Route::delete('interviews/{id}', [AgentInterviewsController::class, 'destroy'])->name('interviews.destroy');
     Route::get('interviews/{id}/status', [AgentInterviewsController::class, 'status'])->name('interviews.status');
     Route::patch('interviews/{id}/status', [AgentInterviewsController::class, 'updateStatus'])->name('interviews.updateStatus');

     // visa document review
     Route::get('visa',   [AgentVisaController::class, 'index'])->name('visa.index');
     Route::get('visa/{visa}/show',   [AgentVisaController::class, 'show'])->name('visa.show');
     Route::post('visa/{visa}/{field}/approve', [AgentVisaController::class, 'approve'])->name('visa.approve');
     Route::post('visa/{visa}/{field}/reject',  [AgentVisaController::class, 'reject'])->name('visa.reject');


     Route::get('visa/approved', [AgentVisaController::class, 'approved'])->name('visa.approved');
     Route::get('visa/{visa}/schedule-flight', [AgentVisaController::class, 'scheduleFlight'])->name('visa.scheduleFlight');



     // List all flight schedules assigned to this agent
     Route::get('visa/schedules', [AgentFlightScheduleController::class, 'index'])
          ->name('visa.schedules');

     // List all flight schedules
    Route::get('visa/schedules', [AgentFlightScheduleController::class, 'index'])
         ->name('visa.schedules');

    // Show the “create” form
    Route::get('visa/{visa}/flight/create', [AgentFlightScheduleController::class, 'create'])
         ->name('visa.flight.create');

    // Store a new schedule
    Route::post('visa/{visa}/flight', [AgentFlightScheduleController::class, 'store'])
         ->name('visa.flight.store');

    // Show a single schedule
    Route::get('visa/{visa}/flight/{schedule}', [AgentFlightScheduleController::class, 'show'])
         ->name('visa.flight.show');

    // Edit form
    Route::get('visa/{visa}/flight/{schedule}/edit', [AgentFlightScheduleController::class, 'edit'])
         ->name('visa.flight.edit');

    // Update a schedule
    Route::put('visa/{visa}/flight/{schedule}', [AgentFlightScheduleController::class, 'update'])
         ->name('visa.flight.update');

    // **Delete a schedule**
    Route::delete('visa/{visa}/flight/{schedule}', [AgentFlightScheduleController::class, 'destroy'])
         ->name('visa.flight.destroy');
});

// Candidate Routes
Route::middleware(['auth', RoleMiddleware::class . ':candidate'])->prefix('candidate')->name('candidate.')->group(function () {
     Route::get('/dashboard', [CandidateController::class, 'index'])->name('dashboard');
     Route::get('jobs', [CandidateJobsController::class, 'index'])->name('jobs.index');
     Route::get('jobs/{job}', [CandidateJobsController::class, 'show'])->name('jobs.show');
     Route::get('jobs/{id}/apply', [CandidateApplicationController::class, 'create'])->name('jobs.apply');
     Route::post('jobs/{id}/apply', [CandidateApplicationController::class, 'store'])->name('jobs.apply.submit');
     Route::get('applications', [CandidateApplicationController::class, 'index'])->name('applications.index');
     Route::get('applications/{id}', [CandidateApplicationController::class, 'show'])->name('applications.show');
     Route::get('/interviews', [CandidateInterviewController::class, 'index'])->name('interviews.index');
     Route::get('/interviews/{id}', [CandidateInterviewController::class, 'show'])->name('interviews.show');
     Route::get('interviews/{id}/status', [CandidateInterviewController::class, 'status'])->name('interviews.status');
     Route::get('contracts', [CandidateContractsController::class, 'index'])->name('contracts.index');
     Route::get('contracts/{contract}/sign', [CandidateContractsController::class, 'show'])->name('contracts.sign');
     Route::post('contracts/{contract}/sign', [CandidateContractsController::class, 'storeSignature'])->name('contracts.storeSignature');

     // upload / edit
     Route::get('visa-documents',                  [CandidateVisaController::class, 'index'])->name('visa.index');
     Route::get('visa-documents/create/{contract}', [CandidateVisaController::class, 'create'])->name('visa.create');
     Route::post('visa-documents',                  [CandidateVisaController::class, 'store'])->name('visa.store');
     Route::get('visa-documents/{visa}',           [CandidateVisaController::class, 'show'])->name('visa.show');
     Route::get('visa-documents/{visa}/edit',      [CandidateVisaController::class, 'edit'])->name('visa.edit');
     Route::put('visa-documents/{visa}',           [CandidateVisaController::class, 'update'])->name('visa.update');
     Route::delete('visa-documents/{visa}',           [CandidateVisaController::class, 'destroy'])->name('visa.destroy');


     Route::get('visa/{visa}/flights', [CandidateFlightScheduleController::class, 'index'])
         ->name('visa.flights.index');

    // View a single flight schedule
    Route::get('visa/{visa}/flights/{schedule}', [CandidateFlightScheduleController::class, 'show'])
         ->name('visa.flights.show');
         
});
