<?php

/**
 * Roles Routes
 */
Route::get('payrolls_summary/import_from_excel', 'Payroll\SummaryController@importDataFromExcel');
Route::post('payrolls_summary/import_from_excel', 'Payroll\SummaryController@postImportDataFromExcel');
Route::get('payrolls_summary/by_payroll_id/{payroll_id}', 'Payroll\SummaryController@byPayrollID')->name('admin.payrolls_summary.by_payroll_id');
// Route::post('payrolls_summary/import_from_excel', 'Payroll\SummaryController@postImportDataFromExcel');

Route::resource('payrolls_summary', 'Payroll\SummaryController', [
    'except' => ['edit', 'create']
]);
