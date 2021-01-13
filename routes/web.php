<?php

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



Route::get('/join', function () {
    return view('join-welcome');
});

Route::get('/join/person', [\App\Http\Controllers\CompetitionJoining::class, 'join_person']);
Route::post('/join/person', [\App\Http\Controllers\CompetitionJoining::class, 'join_person_submit']);

Route::get('/join/team', [\App\Http\Controllers\CompetitionJoining::class, 'join_team']);
Route::post('/join/team', [\App\Http\Controllers\CompetitionJoining::class, 'join_team_submit']);

Route::get('/join/person/api_filler_data', [\App\Http\Controllers\IEEAppsAPIConnector::class, 'join_personal_info_filler_iee_apps']);

Route::get('/api/callback', [\App\Http\Controllers\IEEAppsAPIConnector::class, 'callback_join_personal_info_filler_iee_apps']);

Route::get('/join/status/{submisionid}', [\App\Http\Controllers\StatusPage::class, 'show_submision_status']);

Route::get('/team/invite/{invitecode}', [\App\Http\Controllers\CompetitionJoining::class, 'join_memeber_to_team']);
Route::post('/join/team/{invitecode}', [\App\Http\Controllers\CompetitionJoining::class, 'join_memeber_to_team_submit']);

Route::get('/login', [\App\Http\Controllers\Accounts::class, 'index']);
Route::get('/join/person/api_login', [\App\Http\Controllers\IEEAppsAPIConnector::class, 'login_filler_iee_apps']);
Route::post('/login', [\App\Http\Controllers\Accounts::class, 'login']);
Route::get('/user/dashboard', [\App\Http\Controllers\Accounts::class, 'dashboard_home']);

//Route::get('/user/dashboard/projectspace', [\App\Http\Controllers\Accounts::class, 'dashboard_home']);
//Route::get('/user/dashboard/projectspace/{pjstatus}', [\App\Http\Controllers\Accounts::class, 'dashboard_home']);

Route::get('/logout', [\App\Http\Controllers\Accounts::class, 'user_logout']);

Route::post('/user/dashboard/projectspace', [\App\Http\Controllers\Accounts::class, 'project_space_form_submit']);

