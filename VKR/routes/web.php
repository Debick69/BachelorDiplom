<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/', [\App\Http\Controllers\Missions\MissionsController::class, 'remissions'])->name('route_remissions');
Route::get('/home', [\App\Http\Controllers\Missions\MissionsController::class, 'remissions'])->name('route_remissions');
Route::get('/register', [\App\Http\Controllers\Missions\MissionsController::class, 'remissions'])->name('route_register');

Route::get('/missions', [\App\Http\Controllers\Missions\MissionsController::class, 'missions'])->name('route_missions');
Route::get('/statistics', [\App\Http\Controllers\Statistics\StatisticsController::class, 'statistics'])->name('route_statistics');
Route::get('/notifications', [\App\Http\Controllers\Notifications\NotificationsController::class, 'notifications'])->name('route_notifications');

Route::get('/missions/missions_applications', [\App\Http\Controllers\Missions\Applications\MissionsApplicationsController::class, 'missions_missions_applications'])->name('route_missions_missions_applications');
Route::post('/missions/applications', [\App\Http\Controllers\Missions\Applications\ApplicationsController::class, 'missions_applications'])->name('route_missions_applications');
Route::post('/missions/application', [\App\Http\Controllers\Missions\Applications\ApplicationController::class, 'missions_application'])->name('route_missions_application');
Route::post('/missions/application/accept', [\App\Http\Controllers\Missions\Applications\ApplicationController::class, 'missions_application_accept'])->name('route_missions_application_accept');
Route::post('/missions/application/reject', [\App\Http\Controllers\Missions\Applications\ApplicationController::class, 'missions_application_reject'])->name('route_missions_application_reject');

Route::get('/missions/missions_reports', [\App\Http\Controllers\Missions\Reports\MissionsReportsController::class, 'missions_missions_reports'])->name('route_missions_missions_reports');
Route::post('/missions/reports', [\App\Http\Controllers\Missions\Reports\ReportsController::class, 'missions_reports'])->name('route_missions_reports');
Route::post('/missions/report', [\App\Http\Controllers\Missions\Reports\ReportController::class, 'missions_report'])->name('route_missions_report');
Route::post('/missions/report/accept', [\App\Http\Controllers\Missions\Reports\ReportController::class, 'missions_report_accept'])->name('route_missions_report_accept');
Route::post('/missions/report/reject', [\App\Http\Controllers\Missions\Reports\ReportController::class, 'missions_report_reject'])->name('route_missions_report_reject');

Route::get('/missions/missions_edit', [\App\Http\Controllers\Missions\Edit\MissionsEditController::class, 'missions_missions_edit'])->name('route_missions_missions_edit');
Route::post('/missions/missions_edit_post', [\App\Http\Controllers\Missions\Edit\MissionsEditController::class, 'missions_missions_edit_post'])->name('route_missions_missions_edit_post');
Route::post('/missions/edit', [\App\Http\Controllers\Missions\Edit\EditController::class, 'missions_edit'])->name('route_missions_edit');
Route::post('/missions/edit/edit', [\App\Http\Controllers\Missions\Edit\EditController::class, 'missions_edit_edit'])->name('route_missions_edit_edit');

Route::get('/missions/missions_approve', [\App\Http\Controllers\Missions\Approve\MissionsApproveController::class, 'missions_missions_approve'])->name('route_missions_missions_approve');
Route::post('/missions/approve', [\App\Http\Controllers\Missions\Approve\ApproveController::class, 'missions_approve'])->name('route_missions_approve');
Route::post('/missions/approv', [\App\Http\Controllers\Missions\Approve\ApproveController::class, 'missions_approv'])->name('route_missions_approv');
Route::post('/missions/approve/reject', [\App\Http\Controllers\Missions\Approve\ApproveController::class, 'missions_approve_reject'])->name('route_missions_approve_reject');

Route::get('/missions/missions_applications_teacher', [\App\Http\Controllers\Missions\ApplicationsTeacher\MissionsApplicationsTeacherController::class, 'missions_missions_applications_teacher'])->name('route_missions_missions_applications_teacher');
Route::post('/missions/applications_teacher', [\App\Http\Controllers\Missions\ApplicationsTeacher\ApplicationsTeacherController::class, 'missions_applications_teacher'])->name('route_missions_applications_teacher');
Route::post('/missions/applications_teacher/accept', [\App\Http\Controllers\Missions\ApplicationsTeacher\ApplicationsTeacherController::class, 'missions_applications_teacher_accept'])->name('route_missions_applications_teacher_accept');

Route::get('/missions/missions_applications_teacher_mine', [\App\Http\Controllers\Missions\ApplicationsTeacherMine\MissionsApplicationsTeacherMineController::class, 'missions_missions_applications_teacher_mine'])->name('route_missions_missions_applications_teacher_mine');
Route::post('/missions/missions_applications_teacher_mine_post', [\App\Http\Controllers\Missions\ApplicationsTeacherMine\MissionsApplicationsTeacherMineController::class, 'missions_missions_applications_teacher_mine_post'])->name('route_missions_missions_applications_teacher_mine_post');
Route::post('/missions/missions_applications_teacher_mine/rework', [\App\Http\Controllers\Missions\ApplicationsTeacherMine\MissionsApplicationsTeacherMineReworkController::class, 'missions_missions_applications_teacher_mine_rework'])->name('route_missions_missions_applications_teacher_mine_rework');
Route::post('/missions/applications_teacher_mine/accept', [\App\Http\Controllers\Missions\ApplicationsTeacherMine\MissionsApplicationsTeacherMineReworkController::class, 'missions_applications_teacher_mine_accept'])->name('route_missions_applications_teacher_mine_accept');

Route::get('/missions/missions_reports_teacher_mine', [\App\Http\Controllers\Missions\ReportsTeacherMine\MissionsReportsTeacherMineController::class, 'missions_missions_reports_teacher_mine'])->name('route_missions_missions_reports_teacher_mine');
Route::post('/missions/missions_reports_teacher_mine_post', [\App\Http\Controllers\Missions\ReportsTeacherMine\MissionsReportsTeacherMineController::class, 'missions_missions_reports_teacher_mine_post'])->name('route_missions_missions_reports_teacher_mine_post');
Route::post('/missions/missions_reports_teacher_mine/rework', [\App\Http\Controllers\Missions\ReportsTeacherMine\MissionsReportsTeacherMineReworkController::class, 'missions_missions_reports_teacher_mine_rework'])->name('route_missions_missions_reports_teacher_mine_rework');
Route::post('/missions/reports_teacher_mine/accept', [\App\Http\Controllers\Missions\ReportsTeacherMine\MissionsReportsTeacherMineReworkController::class, 'missions_reports_teacher_mine_accept'])->name('route_missions_reports_teacher_mine_accept');

Route::get('/missions/missions_tasks', [\App\Http\Controllers\Missions\Tasks\MissionsTasksController::class, 'missions_missions_tasks'])->name('route_missions_missions_tasks');
Route::post('/missions/tasks', [\App\Http\Controllers\Missions\Tasks\TasksController::class, 'missions_tasks'])->name('route_missions_tasks');

Route::get('/missions/missions_create', [\App\Http\Controllers\Missions\Create\MissionsCreateController::class, 'missions_missions_create'])->name('route_missions_missions_create');
Route::post('/missions/create/create', [\App\Http\Controllers\Missions\Create\MissionsCreateController::class, 'missions_create_create'])->name('route_missions_create_create');

Route::get('/missions/missions_tasks_teacher', [\App\Http\Controllers\Missions\TasksTeacher\MissionsTasksTeacherController::class, 'missions_missions_tasks_teacher'])->name('route_missions_missions_tasks_teacher');
Route::post('/missions/tasks_teacher', [\App\Http\Controllers\Missions\TasksTeacher\TasksTeacherController::class, 'missions_tasks_teacher'])->name('route_missions_tasks_teacher');
