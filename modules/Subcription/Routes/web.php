<?php


Route::prefix('subcription')->middleware(['XssSanitization','auth'])->group(function() {

    Route::get('/', 'SubcriptionController@index');
    Route::resource('packages','PackageController');

    Route::get('get-package-info','PackageController@getPackageInfo')->name('get-package-info');

    Route::get('get-packages','PackageController@getPackageInfoByType')->name('get-packages');
    
    Route::resource('packages-invoices','InvoiceController');
    Route::get('send-mail/{invoice_id}','InvoiceController@sentInvoiceByMail')->name('send-mail');

    // Route::get('invoice-create/{package}', 'InvoiceController@invoiceCreate')->name('invoice_create');
    
    Route::resource('payment-methods','PaymentMethodController');
    Route::resource('recarring-invoices','RecarringInvoiceController');
    Route::get('sent-invoices','PackageInvoiceSentController@sentInvoice');
    Route::resource('package-durations','PackageDurationController');




    Route::resource('salespackages','SalesPackageController');
    

});
