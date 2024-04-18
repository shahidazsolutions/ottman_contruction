<?php

use App\Http\Controllers\Admin\Accounts\ContractorPaymentController;
use App\Http\Controllers\Admin\Accounts\InvoiceController;
use App\Http\Controllers\Admin\Accounts\SupplierPaymentController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ContractorController;
use App\Http\Controllers\Admin\CustomerPaymemtController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\TransferController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MemberPayment;
use App\Http\Controllers\Purchase\ItemUnitController;
use App\Http\Controllers\Purchase\PurchaseController;
use App\Http\Controllers\Purchase\PurchaseRequistionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\User\UserController;
use App\Models\CustomerPayment;
use App\Models\InvoiceModel;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
Auth::routes();


// Route::POST('login',function(){
    //     return "asd";
    // })->name('login');


Route::middleware(['auth'])->group(function () {
    Route::controller(HomeController::class)->group(function (){
        Route::get('dashboard','index')->name('dashboard');
        Route::get('logout',  'logout')->name('logouto');
});

//Project Controller
Route::controller(ProjectController::class)->group(function (){

    Route::get('/project/add','new')->name('project.add-projects');
    Route::get('projects','list')->name('project.all-projects');
    Route::post('/project/insert','insert')->name('project.insert-project');
    Route::get('/project/edit/{id}','edit')->name('project.edit-project');
    Route::post('/project/update','update')->name('project.update-project');
    Route::DELETE('/project/{id}/destroy','destroy')->name('project.destroy');
});



// Product Controller
Route::controller(ProductController::class)->group(function (){
    Route::get('/products','all_products')->name('products.all-product');
    Route::get('/product/add','show')->name('products.add-product');
    Route::get('/product/edit/{id}','edit')->name('edit_product');
    Route::post('/product/insert','insert')->name('product.insert');
    Route::get('/product/{id}','view_products')->name('show_products');
    Route::post('/product/update/{id}','update')->name('update_product');
    Route::DELETE('/product/delete/{id}','delete')->name('delete_product');

});
// Contractor Controller
Route::controller(ContractorController::class)->group(function (){
    Route::get('/contractors','index')->name('contractor.all-contractors');
    Route::get('/contractor/add','add')->name('contractor.add');
    Route::post('/contractor/add','insert')->name('contractor.insert');
    Route::get('/contractor/edit/{id}','edit')->name('contractor.edit');
     Route::get('/contractor/show/{id}','show')->name('contractor.show');
    Route::post('/contractor/update/{id}','update')->name('contractor.update');
    Route::get('/contractor/delete/{id}','delete')->name('contractor.delete');

    Route::get('/manage-contractor','renderManage')->name('contractor.manage');
    Route::get('/contractor-detail/{id}','renderContractDetail')->name('contractor.contractor-detail');
    Route::get('/asign-contractor','renderAsignContractor')->name('contractor.asign-contractor');
    Route::post('/add/asign-contractor','asignContractor')->name('contractor.add-asign-contractor');
});
// Supplier Controller
Route::controller(SupplierController::class)->group(function (){
    Route::get('/suppliers','show')->name('supplier.show-all');
    Route::get('/supplier/add','add')->name('supplier.add');
    Route::post('/supplier/insert','insert')->name('supplier.insert');
    Route::get('/supplier/edit/{id}','edit')->name('supplier.edit');
    Route::get('/supplier/show/{id}','show_supplier')->name('supplier.show');
    Route::post('/supplier/update/{id}','update')->name('supplier.update');
    Route::get('/supplier/delete/{id}','delete')->name('supplier.delete');

    Route::get('/supplier-detail/{id}','renderSupplierDetail')->name('supplier.detail');
});
// Customer Controller
Route::controller(CustomerController::class)->group(function (){
    Route::get('/customers','show')->name('customer.all-customers');
    Route::get('/customer/add','add')->name('customer.add-customer');
    Route::get('/customer/edit/{id}','edit')->name('customer.edit');
    Route::post('/customer/insert','insert')->name('customer.insert');
    Route::post('/customer/update/{id}','update')->name('customer.update');
    Route::get('/customer/delete/{id}','delete')->name('customer.remove');
});
//Purchase Requistion
Route::controller(PurchaseRequistionController::class)->group(function (){
    Route::get('/purchase-requistions','index')->name('purchase-requistion.all');
    Route::get('/purchase-requistion/add','add')->name('purchase-requistion.add');
    Route::post('/purchase-requistion/insert','insert')->name('purchase-requistion.insert');
    Route::get('/purchase-requistion/edit/{id}/{purchase?}','edit')->name('purchase-requistion.edit');
    Route::get('/purchase-requistion/add-list/','add_requistion_list')->name('purchase-requistion.add-requistion-list');
    Route::post('/purchase-requistion/update/{id}/{purchase?}','update')->name('purchase-requistion.update');
    Route::get('/purchase-requistion/delete/item','delete_item')->name('purchase-requistion.delete_item');
    Route::get('/purchase-requistion/delete/{id}','remove_purchase_request')->name('purchase-requistion.remove');
    Route::GET('/purchase-requistion/show/{id}','show')->name('purchase-requistion.show');
    Route::POST('/purchase-requistion/confirm/{id}','confirm')->name('purchase-requistion.confirm');


});
// Purchase
Route::controller(PurchaseController::class)->group(function(){
    Route::get('/purchases','index')->name('purchase.all');
    Route::get('/purchase/add/{id}','show')->name('purchase.add');
    Route::post('/purchase/insert','insert')->name('purchase.insert');
    // Route::post('add_purchase','show')->name('add_purchase');
    Route::get('/purchase/delete/{id}','remove_purchase')->name('purchase.delete');

    Route::get('/purchase','renderPurchase')->name('purchase.render-purchase');
    Route::post('/purchase-select-project','selectProject')->name('purchase.select-project');
    Route::post('/purchase-select-supplier','selectSupplier')->name('purchase.select-supplier');


    // Route::get('/purchase/add','render')->name('purchase.add');



});
// Route::controller(PurchaseController::class)->group(function(){
//     Route::get('/purchases','index')->name('purchase.all');
//     Route::get('/purchase/add','show')->name('purchase.add');
//     Route::post('/purchase/insert','insert')->name('purchase.insert');
//     // Route::post('add_purchase','show')->name('add_purchase');
//     Route::get('/purchase/delete/{id}','remove_purchase')->name('purchase.delete');

//     Route::get('/purchase','renderPurchase')->name('purchase.render-purchase');
//     Route::post('/purchase-select-project','selectProject')->name('purchase.select-project');
//     Route::post('/purchase-select-supplier','selectSupplier')->name('purchase.select-supplier');


// });
// Items
Route::controller(ItemUnitController::class)->group(function (){
    //Item Routes
    Route::get('/items','showItem')->name('items.all');
    Route::get('/item/add','addItem')->name('items.add');
    Route::post('/item/insert','insertItem')->name('items.insert');
    Route::get('/item/edit/{id}','editItem')->name('items.edit');
    Route::post('/item/update/{id}','updateItem')->name('items.update');
    Route::get('/item/delete/{id}','remove_item')->name('items.delete');

    //Unit Routes
    Route::get('/units','showUnit')->name('unit.all');
    Route::get('/unit/add','addUnit')->name('unit.add');
    Route::post('/unit/insert','insertUnit')->name('unit.insert');
    Route::get('/unit/edit/{id}','editUnit')->name('unit.edit');
    Route::post('/unit/update/{id}','updateUnit')->name('unit.update');
    Route::get('/unit/delete/{id}','remove_unit')->name('unit.delete');
});
// Exports
Route::controller(ExportController::class)->group(function (){
    Route::get('/export/project','export_projects')->name("export.project");
    Route::get('/export/product','export_products')->name("export.product");
});
// Role And User Manage Frome this controller
Route::controller(UserController::class)->group(function(){
    //Role Routes
    Route::get('all_role','index')->name('all_role');
    Route::get('add_role','add')->name('add_role');
    Route::post('insert_role','insert')->name('insert_role');
    //User Controller
});
// Booking Forms
Route::controller(BookingController::class)->group(function(){
    Route::get('/application-form/all','view_all_forms')->name('form.all-app-forms');
    Route::post('/application-form/edit','edit_form')->name('form.edit-app-forms');
    Route::get('/application-form/remove/{id}','remove_form')->name('form.remove-app-forms');

    Route::post('/application-form/print','print_form')->name('form.print-app-forms');

    // Add App Form
    Route::get('/application-form','find_customer')->name('form.find-customer');
    Route::post('/change-flat-options','change_flat_option')->name('sub.change_flat_option');
    Route::post('/application-form/get-details','application_form')->name('form.application-get');
    Route::get('/application-form/{isset}/{customer}/{flat}/{edit?}','view_application_form')->name('form.application');
    Route::get('/application-form/edit/{id}','edit_application_form')->name('form.application-edit');
    Route::PUT('/application-form/update/{id}','update_application_form')->name('form.application-update');
    Route::post('/add-application-form','add_application_form')->name('form.add-application');
    Route::GET('/application-form/invoice/{id}','invoice')->name('form.application.invoice');
});


// transfer form

    Route::controller(TransferController::class)->group(function(){
        Route::GET('transfer/customers','customers')->name('form.transfer.customers');
        Route::GET('transfer','index')->name('form.transfer.index');
        Route::POST('transfer/form','form')->name('form.transfer.form');
        Route::POST('transfer/store','store')->name('form.transfer.store');
        Route::GET('transfer/{id}/edit','edit')->name('form.transfer.edit');
        Route::PUT('transfer/{id}/update','update')->name('form.transfer.update');
        Route::DELETE('transfer/{id}/destroy','destroy')->name('form.transfer.destroy');
        Route::get('flat/{customerId}', 'getFlat')->name('form.transfer.flat');


    });

    // customer payments

    Route::controller(CustomerPaymemtController::class)->group(function(){
        Route::GET('customer/payment/index','index')->name('customer.payments.index');
        Route::GET('customer/payment/create','create')->name('customer.payments.create');
        Route::POST('customer/payment/store','store')->name('customer.payments.store');
        Route::GET('customer/payment/edit/{id}','edit')->name('customer.payments.edit');
        Route::PUT('customer/payment/update/{id}','update')->name('customer.payments.update');
        Route::DELETE('customer/payment/destroy/{id}','destroy')->name('customer.payments.destroy');
        Route::get('customer/project/{customerId}', 'getProject')->name('customer.payments.project');
        Route::get('customer/flat/{customerId}/{project_id}', 'getFlat')->name('customer.payments.flat');

    });

// ================== Accounts ==================
// Invoice
Route::controller(InvoiceController::class)->group(function(){
    Route::get('invoice','renderInvoice')->name('account.invoice');

    Route::post('select-type','selectType')->name('invoice.selectType');
    Route::post('select-contractor','selectContractor')->name('invoice.selectContractor');
    Route::post('pay-to-contractor','payContractor')->name('invoice.pay-to-contractor');
    Route::post('render-contractor-invoices','renderContractorInvoice')->name('invoice.render-contractor-invoices');

    Route::post('select-supplier','selectSupplier')->name('invoice.selectSupplier');
    Route::post('select-project','selectProject')->name('invoice.selectProject');
    Route::post('pay-to-supplier','paySupplier')->name('invoice.pay-to-supplier');
    Route::post('render-supplier-invoices','renderSupplierInvoice')->name('invoice.render-supplier-invoices');



    Route::GET('get-invoice','invoice')->name('invoice');
    // invoice data
    Route::GET('invoice/data','invoice_data')->name('account.invoice.data');

});

// supplier payments
Route::controller(SupplierPaymentController::class)->group(function(){
    Route::GET('supplier/payments/index','index')->name('supplier.payments.index');
    Route::GET('supplier/payments/create','create')->name('supplier.payments.create');
    Route::POST('supplier/payments/store','store')->name('supplier.payments.store');
    Route::DELETE('supplier/payments/{id}/destroy','destroy')->name('supplier.payments.destroy');
    Route::GET('supplier/payments/get_project','get_project')->name('supplier.payments.get_project');
    Route::GET('supplier/payments/invoice/{payment_id}','invoice')->name('supplier.payments.invoice');

});
Route::controller(ContractorPaymentController::class)->group(function(){
    Route::GET('contractor/payments/index','index')->name('contractor.payments.index');
    Route::GET('contractor/payments/create','create')->name('contractor.payments.create');
    Route::POST('contractorr/payments/store','store')->name('contractor.payments.store');
    Route::DELETE('contractor/payments/{id}/destroy','destroy')->name('contractor.payments.destroy');
    Route::GET('contractor/payments/get_project','get_project')->name('contractor.payments.get_project');
    Route::GET('contractor/payments/invoice/{payment_id}','invoice')->name('contractor.payments.invoice');

});


Route::controller(ReportController::class)->group(function(){

     Route::GET('/reports/customer','customer_payment')->name('report.customer.payment');
     Route::POST('/reports/customer','customer_payment_print')->name('report.customer.payment.print');
     Route::get('/report/customer/project/{customerId}', 'getProject')->name('report.customer.payments.project');
     Route::get('/report/customer/flat/{customerId}/{project_id}', 'getFlat')->name('report.customer.payments.flat');

    //supplier


     Route::GET('/reports/supplier','supplier_payment')->name('report.supplier.payment');
     Route::POST('/reports/supplier','supplier_payment_print')->name('report.supplier.payment.print');
     Route::get('/report/supplier/project/{supplierId}', 'getSupplierProject')->name('report.supplier.payments.project');


    Route::GET('/reports/contractor','contractor_payment')->name('report.contractor.payment');
     Route::POST('/reports/contractor','contractor_payment_print')->name('report.contractor.payment.print');
     Route::get('/report/contractor/project/{contractorId}', 'getContractorProject')->name('report.contractor.payments.project');

     Route::GET('/monthly/report','monthly_report')->name('report.monthly');
     Route::GET('/daily/report','daily_report')->name('report.daily');
     Route::GET('/summary/report','summary_report')->name('report.summary');



});

    Route::controller(MemberController::class)->group(function(){
        Route::GET('member','index')->name('admin.members.index');
        Route::GET('member/create','create')->name('admin.members.create');
        Route::POST('member/store','store')->name('admin.members.store');
        Route::GET('member/edit/{id}','edit')->name('admin.members.edit');
        Route::PUT('member/update/{id}','update')->name('admin.members.update');
        Route::DELETE('member/destroy/{id}','destroy')->name('admin.members.destroy');
    });

    Route::controller(MemberPayment::class)->group(function(){
        Route::GET('member/payment','index')->name('admin.members-payment.index');
        Route::GET('member/payment/create','create')->name('admin.members-payment.create');
        Route::GET('member/payment/{id}/show','show')->name('admin.members-payment.show');
        Route::POST('member/payment/store','store')->name('admin.members-payment.store');
        // Route::GET('member/payment/edit/{id}','edit')->name('admin.members-payment.edit');
        // Route::PUT('member/payment/update/{id}','update')->name('admin.members-payment.update');
        // Route::DELETE('member/payment/destroy/{id}','destroy')->name('admin.members-payment.destroy');

    });



    Route::GET('admin/profile',[AdminProfileController::class,'profile'])->name('admin.profile');
    Route::POST('admin/profile/update',[AdminProfileController::class,'update'])->name('admin.profile.update');

});

