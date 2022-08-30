<?php

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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
Route::group(['middleware' => 'auth'], function () {
Route::get('/home', 'HomeController@index')->name('home');
/*** users routes ***/
Route::prefix('users')->group(function () {
Route::get('index', 'UserController@index')->name('index');
Route::get('create', 'UserController@create')->name('create_user');
Route::post('store_user', 'UserController@store')->name('store_user');
Route::get('edit_user/{id}', 'UserController@edit')->name('edit_user');
Route::post('update_user/{id}', 'UserController@update')->name('update_user');
Route::get('delete-selected', 'UserController@deleteSelected')->name('delete-selected');
Route::get('delete_user/{id}', 'UserController@deleteUser')->name('delete_user');
Route::get('export_user', 'UserController@export')->name('export_user');
Route::get('export_insert', 'UserController@export_insert')->name('export_insert');
Route::post('import_users', 'UserController@import')->name('import_users');
Route::get('users_print', 'UserController@print_pdf')->name('users_print');
});
/**roles routes **/
Route::prefix('roles')->group(function () {
Route::get('index', 'RoleController@index')->name('index');
Route::get('create', 'RoleController@create')->name('create');
Route::post('store', 'RoleController@store')->name('store');
Route::get('edit/{id}', 'RoleController@edit')->name('edit');
Route::post('update/{id}', 'RoleController@update')->name('update');
Route::get('delete/{id}', 'RoleController@delete')->name('delete');
});
/*** employees routes ***/
Route::prefix('employees')->group(function () {
Route::get('index', 'EmployeeController@index')->name('index');
Route::get('create', 'EmployeeController@create')->name('create');
Route::post('store', 'EmployeeController@store')->name('store');
Route::get('edit/{id}', 'EmployeeController@edit')->name('edit');
Route::post('update/{id}', 'EmployeeController@update')->name('update');
Route::get('delete-selected', 'EmployeeController@deleteSelected')->name('delete-selected');
Route::get('delete_employee/{id}','EmployeeController@deleteEmployee')->name('delete_employee');
Route::get('delete_image/{id}','EmployeeController@deleteImage')->name('delete_image');
Route::get('export', 'EmployeeController@export')->name('export_user');
Route::get('export_insert', 'EmployeeController@export_insert')->name('export_insert');
Route::post('import', 'EmployeeController@import')->name('import');
Route::get('print', 'EmployeeController@print_pdf')->name('print');

});
/*** employees salary histories routes ***/
Route::prefix('employees/salaries')->group(function () {
Route::get('index', 'EmployeeSalaryHistoryController@index')->name('index');
Route::get('create', 'EmployeeSalaryHistoryController@create')->name('create');
Route::post('store', 'EmployeeSalaryHistoryController@store')->name('store');
Route::get('edit/{id}', 'EmployeeSalaryHistoryController@edit')->name('edit');
Route::post('update/{id}', 'EmployeeSalaryHistoryController@update')->name('update');
Route::get('delete-selected', 'EmployeeSalaryHistoryController@deleteSelected')->name('delete-selected');
Route::get('delete/{id}','EmployeeSalaryHistoryController@delete')->name('delete');


});
Route::prefix('work/schedules')->group(function () {
Route::get('index', 'WorkScheduleProfileController@index')->name('index');
Route::post('update/{id}', 'WorkScheduleProfileController@update')->name('update');
Route::get('edit/{id}', 'WorkScheduleProfileController@edit')->name('edit');
Route::get('create', 'WorkScheduleProfileController@create')->name('create');
Route::post('store', 'WorkScheduleProfileController@store')->name('store');
Route::get('delete/{id}', 'WorkScheduleProfileController@delete')->name('delete');
Route::get('delete-selected', 'WorkScheduleProfileController@deleteSelected')->name('delete-selected');
Route::get('export', 'WorkScheduleProfileController@export')->name('export');
Route::get('export_insert', 'WorkScheduleProfileController@export_insert')->name('export_insert');
Route::post('import', 'WorkScheduleProfileController@import')->name('import');
});
Route::prefix('overtime/profiles')->group(function () {
Route::get('index', 'OvertimeProfileController@index')->name('index');
Route::post('update/{id}', 'OvertimeProfileController@update')->name('update');
Route::get('edit/{id}', 'OvertimeProfileController@edit')->name('edit');
Route::get('create', 'OvertimeProfileController@create')->name('create');
Route::post('store', 'OvertimeProfileController@store')->name('store');
Route::get('delete/{id}', 'OvertimeProfileController@delete')->name('delete');
Route::get('delete-selected', 'OvertimeProfileController@deleteSelected')->name('delete-selected');
Route::get('export', 'OvertimeProfileController@export')->name('export');
Route::get('export_insert', 'OvertimeProfileController@export_insert')->name('export_insert');
Route::post('import', 'OvertimeProfileController@import')->name('import');
});
Route::prefix('vacations')->group(function () {
Route::get('index', 'VacationController@index')->name('index');
Route::get('create', 'VacationController@create')->name('create');
Route::post('store', 'VacationController@store')->name('store');
Route::get('edit/{id}', 'VacationController@edit')->name('edit');
Route::post('update/{id}', 'VacationController@update')->name('update');
Route::get('delete/{id}', 'VacationController@delete')->name('delete');
Route::get('delete-selected', 'VacationController@deleteSelected')->name('delete-selected');
Route::get('export', 'VacationController@export')->name('export');
Route::get('export_insert', 'VacationController@export_insert')->name('export_insert');
Route::post('import', 'VacationController@import')->name('import');

});
Route::prefix('permissions')->group(function () {
Route::get('index', 'PermissionController@index')->name('index');
Route::get('create', 'PermissionController@create')->name('create');
Route::post('store', 'PermissionController@store')->name('store');
Route::get('edit/{id}', 'PermissionController@edit')->name('edit');
Route::post('update/{id}', 'PermissionController@update')->name('update');
Route::get('delete/{id}', 'PermissionController@delete')->name('delete');
Route::get('delete-selected', 'PermissionController@deleteSelected')->name('delete-selected');
Route::get('export', 'PermissionController@export')->name('export');
Route::get('export_insert', 'PermissionController@export_insert')->name('export_insert');
Route::post('import', 'PermissionController@import')->name('import');
});
Route::prefix('employee/permissions')->group(function () {
Route::get('index', 'EmployeePermissionController@index')->name('index');
Route::get('create', 'EmployeePermissionController@create')->name('create');
Route::post('store', 'EmployeePermissionController@store')->name('store');
Route::get('edit/{id}', 'EmployeePermissionController@edit')->name('edit');
Route::post('update/{id}', 'EmployeePermissionController@update')->name('update');
Route::get('delete/{id}', 'EmployeePermissionController@delete')->name('delete');
Route::get('delete-selected', 'EmployeePermissionController@deleteSelected')->name('delete-selected');
Route::get('export', 'EmployeePermissionController@export')->name('export');
Route::get('export_insert', 'EmployeePermissionController@export_insert')->name('export_insert');
Route::post('import', 'EmployeePermissionController@import')->name('import');
});
Route::prefix('employee/solde/deduction')->group(function () {
Route::get('index', 'EmployeeSoldeDeductionController@index')->name('index');
Route::get('create', 'EmployeeSoldeDeductionController@create')->name('create');
Route::post('store', 'EmployeeSoldeDeductionController@store')->name('store');
Route::get('edit/{id}', 'EmployeeSoldeDeductionController@edit')->name('edit');
Route::post('update/{id}', 'EmployeeSoldeDeductionController@update')->name('update');
Route::get('delete/{id}', 'EmployeeSoldeDeductionController@delete')->name('delete');
Route::get('delete-selected', 'EmployeeSoldeDeductionController@deleteSelected')->name('delete-selected');
Route::get('export', 'EmployeeSoldeDeductionController@export')->name('export');
Route::get('export_insert', 'EmployeeSoldeDeductionController@export_insert')->name('export_insert');
Route::post('import', 'EmployeeSoldeDeductionController@import')->name('import');
});
Route::prefix('leaves')->group(function () {
Route::get('index', 'LeaveController@index')->name('index');
Route::get('create', 'LeaveController@create')->name('create');
Route::post('store', 'LeaveController@store')->name('store');
Route::get('edit/{id}', 'LeaveController@edit')->name('edit');
Route::post('update/{id}', 'LeaveController@update')->name('update');
Route::get('delete/{id}', 'LeaveController@delete')->name('delete');
Route::get('delete-selected', 'LeaveController@deleteSelected')->name('delete-selected');
Route::get('export', 'LeaveController@export')->name('export');
Route::get('export_insert', 'LeaveController@export_insert')->name('export_insert');
Route::post('import', 'LeaveController@import')->name('import');
});
Route::prefix('employee/leaves')->group(function () {
Route::get('index', 'EmployeeLeaveController@index')->name('index');
Route::get('create', 'EmployeeLeaveController@create')->name('create');
Route::post('store', 'EmployeeLeaveController@store')->name('store');
Route::get('edit/{id}', 'EmployeeLeaveController@edit')->name('edit');
Route::post('update/{id}', 'EmployeeLeaveController@update')->name('update');
Route::get('delete/{id}', 'EmployeeLeaveController@delete')->name('delete');
Route::get('delete-selected', 'EmployeeLeaveController@deleteSelected')->name('delete-selected');
Route::get('export', 'EmployeeLeaveController@export')->name('export');
Route::get('print', 'EmployeeLeaveController@print_pdf')->name('print');
Route::get('export', 'EmployeeLeaveController@export')->name('export');
Route::get('export_insert', 'EmployeeLeaveController@export_insert')->name('export_insert');
Route::post('import', 'EmployeeLeaveController@import')->name('import');
Route::get('updateLeaveAbsence', 'EmployeeLeaveController@updateLeaveAbsence')->name('updateLeaveAbsence');
});
Route::prefix('attendance')->group(function () {
Route::get('index', 'AttendanceController@index')->name('index');
Route::get('getAttendances', 'AttendanceController@getAttendances')->name('getAttendances');
Route::get('export', 'AttendanceController@export')->name('export');
Route::get('deleteAttendance/{id}', 'AttendanceController@deleteAttendance')->name('deleteAttendance');
Route::get('create', 'AttendanceController@create')->name('create');
Route::post('store', 'AttendanceController@store')->name('store');
Route::get('edit/{id}', 'AttendanceController@edit')->name('edit');
Route::post('update/{id}', 'AttendanceController@update')->name('update');
Route::get('delete-selected', 'AttendanceController@deleteSelected')->name('delete-selected');
Route::get('insert/export', 'AttendanceController@insertExport')->name('insert/export');
Route::get('update/export', 'AttendanceController@updateExport')->name('update/export');
Route::post('insert/import', 'AttendanceController@insertImport')->name('insert/import');
Route::post('update_import', 'AttendanceController@updateImport')->name('update_import');
});
Route::prefix('attendance-net')->group(function () {
Route::get('index', 'AttendanceNetController@index')->name('index');
Route::get('export', 'AttendanceNetController@export')->name('export');
Route::get('delete/{id}', 'AttendanceNetController@delete')->name('delete');
Route::get('create', 'AttendanceNetController@create')->name('create');
Route::post('store', 'AttendanceNetController@store')->name('store');
Route::get('edit/{id}', 'AttendanceNetController@edit')->name('edit');
Route::post('update/{id}', 'AttendanceNetController@update')->name('update');
Route::get('delete-selected', 'AttendanceNetController@deleteSelected')->name('delete-selected');
Route::get('update_all', 'AttendanceNetController@update_all')->name('update_all');
Route::get('export_insert', 'AttendanceNetController@export_insert')->name('export_insert');
Route::post('import', 'AttendanceNetController@import')->name('import');
});
Route::prefix('absence')->group(function () {
Route::get('index', 'AbsenceController@index')->name('index');
Route::get('export', 'AbsenceController@export')->name('export');
Route::get('delete/{id}', 'AbsenceController@delete')->name('delete');
Route::get('create', 'AbsenceController@create')->name('create');
Route::post('store', 'AbsenceController@store')->name('store');
Route::get('edit/{id}', 'AbsenceController@edit')->name('edit');
Route::post('update/{id}', 'AbsenceController@update')->name('update');
Route::get('delete-selected', 'AbsenceController@deleteSelected')->name('delete-selected');
Route::get('export_insert', 'AbsenceController@export_insert')->name('export_insert');
Route::post('import', 'AbsenceController@import')->name('import');
    });
Route::prefix('check-in')->group(function () {
Route::get('search', 'CheckInController@search')->name('search');
Route::get('get_employee', 'CheckInController@get_employee')->name('get_employee');
Route::post('store/{id}', 'CheckInController@store')->name('store');
Route::get('index', 'CheckInController@index')->name('index');
});
Route::prefix('check-out')->group(function () {
Route::get('search', 'CheckOutController@search')->name('search');
Route::get('get_employee', 'CheckOutController@get_employee')->name('get_employee');
Route::post('store/{id}', 'CheckOutController@store')->name('store');
});
Route::prefix('reports')->group(function () {
Route::get('generate', 'Reports\GenerateReportController@generate')->name('generate');
Route::get('getTableColumns', 'Reports\GenerateReportController@getTableColumns')->name('getTableColumns');
Route::get('getFilterInput', 'Reports\GenerateReportController@getFilterInput')->name('getFilterInput');
Route::post('generated/result', 'Reports\GenerateReportController@runQuery')->name('generated/result');
Route::get('export', 'Reports\GenerateReportController@export')->name('export');
Route::get('print', 'Reports\GenerateReportController@print_pdf')->name('print');
Route::post('save', 'Reports\GenerateReportController@save')->name('save');
});
Route::prefix('reports')->group(function () {
Route::get('salary/report', 'Reports\SalaryReportController@index')->name('salary/report');
Route::get('getSalaryReport', 'Reports\SalaryReportController@getSalaryReport')->name('getSalaryReport');
Route::get('salary_export', 'Reports\SalaryReportController@export')->name('salary_export');
Route::get('salary_print', 'Reports\SalaryReportController@print_pdf')->name('salary_print');
});
Route::prefix('reports')->group(function () {
Route::get('saved', 'Reports\SavedReportController@index')->name('saved');
Route::post('saved/result', 'Reports\SavedReportController@runQuery')->name('saved/result');
Route::get('saved/delete/{id}', 'Reports\SavedReportController@delete')->name('saved/delete');
});
Route::prefix('input/fields')->group(function () {
Route::get('index', 'InputFieldController@index')->name('index');
Route::post('store', 'InputFieldController@store')->name('store');
Route::post('update/{id}', 'InputFieldController@update')->name('update');
Route::get('delete/{id}', 'InputFieldController@delete')->name('delete');
});
Route::prefix('backup')->group(function () {
Route::get('getBackup', 'BackupController@getBackup')->name('getBackup');
});
});