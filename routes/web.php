<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PcrController;
use App\Http\Controllers\PatientAssessmentController;
use App\Http\Controllers\PatientManagementController;
use App\Http\Controllers\PatientObservationController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\ResponseTeamController;
use App\Http\Controllers\PatientRefusalController;
use App\Http\Controllers\HotlineController;

Auth::routes();
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/account/create/{userType?}', [AccountController::class, 'create'])->name('account.create');
Route::post('/account/store', [AccountController::class, 'store'])->name('account.store');
Route::get('/account/overview/{userType?}', [AccountController::class, 'index'])->name('account.overview');
Route::get('/account/{id}', [AccountController::class, 'show'])->name('account.show');

Route::get('/account', [AccountController::class, 'showMyAccount'])->name('account.own');
Route::get('/account-edit', [AccountController::class, 'editMyAccount'])->name('account.edit');
Route::put('/account-update', [AccountController::class, 'updateMyAccount'])->name('account.update');
Route::post('/account/search', [AccountController::class, 'index'])->name('account.search');

Route::get('/ambulance/{user}/edit', [AccountController::class, 'editAmbulance'])->name('ambulance.edit');
Route::put('/ambulance/{user}/update', [AccountController::class, 'updateAmbulance'])->name('ambulance.update');
Route::get('/hospital/{user}/edit', [AccountController::class, 'editHospital'])->name('hospital.edit');
Route::put('/hospital/{user}/update', [AccountController::class, 'updateHospital'])->name('hospital.update');
Route::get('/comcen/{user}/edit', [AccountController::class, 'editComcen'])->name('comcen.edit');
Route::put('/comcen/{user}/update', [AccountController::class, 'updateComcen'])->name('comcen.update');
Route::get('/admin/{user}/edit', [AccountController::class, 'editAdmin'])->name('admin.edit');
Route::put('/admin/{user}/update', [AccountController::class, 'updateAdmin'])->name('admin.update');

Route::get('/incident/create', [IncidentController::class, 'create'])->name('incident.create');
Route::post('/incident/store', [IncidentController::class, 'store'])->name('incident.store');
Route::get('/incident/overview/{status?}', [IncidentController::class, 'index'])->name('incident');
Route::get('/incident/{incident}', [IncidentController::class, 'show'])->name('incident.show');
Route::get('/incident/{incident}/edit', [IncidentController::class, 'edit'])->name('incident.edit');
Route::put('/incident/{incident}/update', [IncidentController::class, 'update'])->name('incident.update');
Route::post('/incident/search', [IncidentController::class, 'index'])->name('incident.search');

Route::put('/incident/assign/{incident}', [IncidentController::class, 'assign'])->name('incident.assign');
Route::put('/incident/enroute/{patient}', [IncidentController::class, 'enroute'])->name('incident.enroute');
Route::put('/incident/arrival/{patient}', [IncidentController::class, 'arrival'])->name('incident.arrival');
Route::put('/incident/depart/{patient}', [IncidentController::class, 'depart'])->name('incident.depart');
Route::put('/incident/{incident}/enroute', [IncidentController::class, 'enrouteIncident'])->name('incident.only.enroute');
Route::put('/incident/{incident}/arrival', [IncidentController::class, 'arrivalIncident'])->name('incident.only.arrival');
Route::put('/incident/{incident}/depart', [IncidentController::class, 'departIncident'])->name('incident.only.depart');

Route::get('/patient/create/{incident}', [PatientController::class, 'create'])->name('patient.create');
Route::post('/patient/store/{incident}', [PatientController::class, 'store'])->name('patient.store');
Route::get('/patient/overview/{status?}', [PatientController::class, 'index'])->name('patient');
Route::get('/patient/{patient}/edit', [PatientController::class, 'edit'])->name('patient.edit');
Route::put('/patient/{patient}/update', [PatientController::class, 'update'])->name('patient.update');
Route::post('/patient/search', [PatientController::class, 'index'])->name('patient.search');

Route::get('/pcr/{patient}', [PcrController::class, 'show'])->name('pcr.show');
Route::get('/pcr/{patient}/print', [PcrController::class, 'print'])->name('pcr.print');

Route::get('/assessment/create/{patient}', [PatientAssessmentController::class, 'create'])->name('assessment.create');
Route::post('/assessment/store/{patient}', [PatientAssessmentController::class, 'store'])->name('assessment.store');
Route::get('/assessment/{patientAssessment}/edit', [PatientAssessmentController::class, 'edit'])->name('assessment.edit');
Route::put('/assessment/{patientAssessment}/update', [PatientAssessmentController::class, 'update'])->name('assessment.update');

Route::get('/assessment/vitals/{patientAssessment}', [PatientAssessmentController::class, 'createVitals'])->name('assessment.vitals.create');
Route::put('/assessment/vitals/{patientAssessment}', [PatientAssessmentController::class, 'updateVitals'])->name('assessment.vitals.update');

Route::get('/management/create/{patient}', [PatientManagementController::class, 'create'])->name('management.create');
Route::post('/management/store/{patient}', [PatientManagementController::class, 'store'])->name('management.store');
Route::get('/management/{patientManagement}/edit', [PatientManagementController::class, 'edit'])->name('management.edit');
Route::put('/management/{patientManagement}/update', [PatientManagementController::class, 'update'])->name('management.update');

Route::put('/management/arrival/{patient}', [PatientManagementController::class, 'arrival'])->name('management.arrival');
Route::put('/management/handover/{patient}', [PatientManagementController::class, 'handover'])->name('management.handover');
Route::put('/management/clear/{patient}', [PatientManagementController::class, 'clear'])->name('management.clear');

Route::get('/refusal/create/{patient}', [PatientRefusalController::class, 'create'])->name('refusal.create');
Route::put('/refusal/store/{patient}', [PatientRefusalController::class, 'store'])->name('refusal.store');

Route::get('/refusal/hospital/{patient}', [PatientRefusalController::class, 'createHospital'])->name('refusal.hospital.create');
Route::put('/refusal/hospital/{patient}', [PatientRefusalController::class, 'storeHospital'])->name('refusal.hospital.store');
Route::get('/refusal/hospital/{patientRefusal}/edit', [PatientRefusalController::class, 'editHospital'])->name('refusal.hospital.edit');
Route::put('/refusal/hospital/{patientRefusal}/update', [PatientRefusalController::class, 'updateHospital'])->name('refusal.hospital.update');
Route::put('/refusal/hospital/{patientRefusal}/delete', [PatientRefusalController::class, 'destroyHospital'])->name('refusal.hospital.destroy');

Route::get('/observation/create/{patient}', [PatientObservationController::class, 'create'])->name('observation.create');
Route::post('/observation/store/{patient}', [PatientObservationController::class, 'store'])->name('observation.store');
Route::get('/observation/{patientObservation}/edit', [PatientObservationController::class, 'edit'])->name('observation.edit');
Route::put('/observation/{patientObservation}/update', [PatientObservationController::class, 'update'])->name('observation.update');

Route::get('/personnel/create', [PersonnelController::class, 'create'])->name('personnel.create');
Route::post('/personnel/store', [PersonnelController::class, 'store'])->name('personnel.store');
Route::get('/personnel/overview/{status?}', [PersonnelController::class, 'index'])->name('personnel');
Route::get('/personnel/{personnel}', [PersonnelController::class, 'show'])->name('personnel.show');
Route::get('/personnel/{personnel}/edit', [PersonnelController::class, 'edit'])->name('personnel.edit');
Route::put('/personnel/{personnel}/update', [PersonnelController::class, 'update'])->name('personnel.update');
Route::post('/personnel/search', [PersonnelController::class, 'index'])->name('personnel.search');

Route::get('/response/create', [ResponseTeamController::class, 'create'])->name('response.create');
Route::post('/response/store', [ResponseTeamController::class, 'store'])->name('response.store');
Route::get('/response', [ResponseTeamController::class, 'index'])->name('response');
Route::get('/response/{responseTeam}', [ResponseTeamController::class, 'show'])->name('response.show');
Route::get('/response/{responseTeam}/edit', [ResponseTeamController::class, 'edit'])->name('response.edit');
Route::put('/response/{responseTeam}/update', [ResponseTeamController::class, 'update'])->name('response.update');

Route::get('/hotline', [HotlineController::class, 'index'])->name('hotline');
Route::post('/hotline/search', [HotlineController::class, 'index'])->name('hotline.search');
Route::get('/hotline/create', [HotlineController::class, 'create'])->name('hotline.create');
Route::post('/hotline/store', [HotlineController::class, 'store'])->name('hotline.store');
Route::get('/hotline/edit/{hotline}', [HotlineController::class, 'edit'])->name('hotline.edit');
Route::put('/hotline/update/{hotline}', [HotlineController::class, 'update'])->name('hotline.update');

Route::fallback(function () {
    view('errors.404');
});



