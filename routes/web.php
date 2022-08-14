<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CashflowController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ItemStatusController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentVoucherController;
use App\Http\Controllers\PaymentVoucherListController;
use App\Http\Controllers\PayslipController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\QuotationItemController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TopLeaveController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/easter', [DashboardController::class, 'easter']);

    Route::get('/profile', [UserController::class, 'show']);
    Route::patch('/profile/update/{user}', [UserController::class, 'update']);
    Route::get('/profile/upload', [PhotoController::class, 'create']);
    Route::patch('/profile/upload/{user}', [PhotoController::class, 'update']);
    Route::get('/staff', [StaffController::class, 'index']);

    Route::get('/leaves', [LeaveController::class, 'index']);
    Route::get('/leaves/create', [LeaveController::class, 'create']);
    Route::post('/leaves/create/{user}', [LeaveController::class, 'store']);

    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/location/{branch}', [OrderController::class, 'index_location']);
    Route::get('/orders/create', [OrderController::class, 'create']);
    Route::post('/orders/create', [OrderController::class, 'insert']);
    Route::get('/orders/view/{order}', [OrderController::class, 'view']);
    Route::get('/orders/view/{order}/edit', [OrderController::class, 'edit']);
    Route::get('/orders/view/{order}/pickup', [OrderController::class, 'pickup']);
    Route::patch('/orders/pickup/{order}', [OrderController::class, 'update_pickup']);
    Route::patch('/orders/edit/{order}', [OrderController::class, 'update']);
    Route::delete('/orders/{order}/delete', [OrderController::class, 'delete']);
    Route::patch('/orders/{order}/additional', [OrderController::class, 'update_additional']);
    Route::patch('/orders/view/{order}/mark-done', [OrderController::class, 'update_done']);
    Route::patch('/orders/view/{order}/mark-undone', [OrderController::class, 'update_undone']);
    Route::get('/orders/no-pickup', [OrderController::class, 'index_nopickup']);
    Route::get('/orders/view/{order}/refresh', [OrderController::class, 'refresh']);
    Route::get('/order/go', fn () => redirect('/orders/view/' . request('id')));

    Route::get('/quote', [QuotationController::class, 'index']);
    Route::get('/quote/create', [QuotationController::class, 'create']);
    Route::post('/quote/create', [QuotationController::class, 'insert']);
    Route::get('/quote/{quote}', [QuotationController::class, 'view']);
    Route::delete('/quote/{quote}', [QuotationController::class, 'delete']);
    Route::get('/quote/{quote}/print', [QuotationController::class, 'print']);
    Route::patch('/quote/{quote}/print', [QuotationController::class, 'update_footer']);
    Route::post('/quote/{quote}/export', [QuotationController::class, 'export']);

    Route::post('/quote/{quote}/add-item', [QuotationItemController::class, 'insert']);
    Route::delete('/quote/{quote}/{list}/delete', [QuotationItemController::class, 'delete']);

    Route::get('/payment/{order}', [OrderController::class, 'print']);

    Route::get('/orders/{order}/invoice', [InvoiceController::class, 'invoice']);
    Route::patch('/orders/{order}/invoice', [InvoiceController::class, 'edit_invoice']);
    Route::get('/orders/{order}/purchase-order', [InvoiceController::class, 'po']);
    Route::get('/orders/{order}/delivery-order', [InvoiceController::class, 'do']);
    Route::patch('/orders/{order}/delivery-order', [InvoiceController::class, 'edit_do']);

    Route::get('/orders/{order}/payments', [PaymentController::class, 'index']);
    Route::post('/orders/{order}/payments', [PaymentController::class, 'insert']);
    Route::delete('/orders/{order}/payments/{payment}', [PaymentController::class, 'destroy']);

    Route::get('/orders/{order}/add-item', [OrderItemController::class, 'create']);
    Route::post('/orders/{order}/add-item', [OrderItemController::class, 'insert']);
    Route::get('/orders/item/{item}', [OrderItemController::class, 'view']);
    Route::get('/orders/item/{item}/edit', [OrderItemController::class, 'edit']);
    Route::patch('/orders/item/{item}/update', [OrderItemController::class, 'update']);
    Route::delete('/orders/item/{item}/delete', [OrderItemController::class, 'delete']);
    Route::patch('/orders/item/{item}/user', [OrderItemController::class, 'update_user']);
    Route::patch('/orders/item/{item}/status', [OrderItemController::class, 'update_status']);
    Route::patch('/orders/item/{item}/takeover', [OrderItemController::class, 'update_takeover']);
    Route::post('/orders/item/{item}/foto', [OrderItemController::class, 'update_photo']);
    Route::post('/orders/item/picture/{picture}/del', [OrderItemController::class, 'delete_photo']);

    Route::post('/orders/item/{item}/design', [ItemStatusController::class, 'update_design']);
    Route::post('/orders/item/{item}/approved', [ItemStatusController::class, 'update_approved']);
    Route::post('/orders/item/{item}/approved-guar', [ItemStatusController::class, 'update_approved_guar']);
    Route::post('/orders/item/{item}/approved-production', [ItemStatusController::class, 'update_approved_prod']);
    Route::post('/orders/item/{item}/approved-subcon', [ItemStatusController::class, 'update_approved_sub']);
    Route::post('/orders/item/{item}/update-subcon', [OrderItemController::class, 'update_sub']);
    // Route::post('/orders/item/{item}/printing', [ItemStatusController::class, 'update_printing']);
    Route::post('/orders/item/{item}/done', [ItemStatusController::class, 'update_done']);
    Route::get('/orders/item/status/{status}', [ItemStatusController::class, 'show_status']);
    Route::get('/order/item/zero-value', [ItemStatusController::class, 'show_zero']);
    // Route::get('/orders/item/status/is_approved/{production}', [ItemStatusController::class, 'show_production']);

    Route::get('/customers', [CustomerController::class, 'index']);
    Route::get('/customers/create', [CustomerController::class, 'create']);
    Route::post('/customers/create', [CustomerController::class, 'insert']);
    Route::get('/customer/{customer}/edit', [CustomerController::class, 'edit']);
    Route::patch('/customer/{customer}/edit', [CustomerController::class, 'update']);
    Route::get('/customer/{customer}', [CustomerController::class, 'select']);
    Route::patch('/customer/{customer}/agent', [CustomerController::class, 'agent']);

    Route::get('/branches', [BranchController::class, 'index']);
    Route::get('/branches/{branch}/update', [BranchController::class, 'view']);
    Route::patch('/branches/{branch}/update', [BranchController::class, 'update']);

    Route::get('/suppliers', [SupplierController::class, 'index']);
    Route::get('/suppliers/{supplier}/update', [SupplierController::class, 'view']);
    Route::patch('/suppliers/{supplier}/update', [SupplierController::class, 'update']);
    Route::get('/suppliers/create', [SupplierController::class, 'create']);
    Route::post('/suppliers/create', [SupplierController::class, 'store']);

    Route::get('/to-do', [TaskController::class, 'index']);
    Route::get('/staff/prev-works', [TaskController::class, 'previous']);
    Route::get('/print', [TaskController::class, 'view_print']);
    Route::get('/print-list', [TaskController::class, 'print_print']);
    Route::get('/items/print-sticker/{item}', [TaskController::class, 'print_sticker']);
    Route::get('/print/all-stickers', [TaskController::class, 'print_allstickers']);
    Route::get('/view-designer', [TaskController::class, 'view_designer']);

    Route::get('/cashflow', [CashflowController::class, 'index']);
    Route::get('/cashflow/{branch}', [CashflowController::class, 'view']);
    Route::post('/cashflow/{branch}/add', [CashflowController::class, 'add']);
    Route::delete('/cashflow/delete/{cashflow}', [CashflowController::class, 'delete']);

    Route::get('/payslips', [PayslipController::class, 'index']);

    Route::get('/reports', [ReportController::class, 'index']);
    Route::get('/reports/{year}', [ReportController::class, 'yearly']);
    Route::get('/reports/{year}/{branch}', [ReportController::class, 'branch_yearly']);

    Route::get('/payment-vouchers', [PaymentVoucherController::class, 'index']);
    Route::post('/payment-vouchers/add', [PaymentVoucherController::class, 'create']);
    Route::get('/payment-vouchers/{voucher}', [PaymentVoucherController::class, 'view']);
    Route::get('/payment-vouchers/{voucher}/edit', [PaymentVoucherController::class, 'edit']);
    Route::patch('/payment-vouchers/{voucher}/edit', [PaymentVoucherController::class, 'update']);
    Route::patch('/payment-vouchers/{voucher}/approve', [PaymentVoucherController::class, 'approve']);
    Route::patch('/payment-vouchers/{voucher}/paid', [PaymentVoucherController::class, 'paid']);
    Route::post('/payment-vouchers/{voucher}/img', [PaymentVoucherController::class, 'img']);

    Route::post('/payment-vouchers/{voucher}/add', [PaymentVoucherListController::class, 'create']);
    Route::delete('/payment-vouchers/{voucher}/{list}', [PaymentVoucherListController::class, 'delete']);
});

Route::group(['middleware' => ['auth', 'admin']], function () {

    Route::get('/admin', [DashboardController::class, 'index_admin']);

    Route::get('/staff/show/{user}', [StaffController::class, 'show']);
    Route::patch('/staff/active/{user}', [StaffController::class, 'update']);

    Route::get('/leaves/approval', [LeaveController::class, 'show']);
    Route::get('/leaves/list', [LeaveController::class, 'list']);
    Route::delete('/leave/{leave}/delete', [LeaveController::class, 'destroy']);
    Route::patch('/leaves/approval/{leave}', [LeaveController::class, 'update']);
    Route::delete('/leaves/approval/{leave}', [LeaveController::class, 'delete']);

    Route::get('/top/leave-types', [LeaveTypeController::class, 'index']);
    Route::patch('/top/leave-types/{type}', [LeaveTypeController::class, 'update']);

    Route::get('/admin/payslips', [PayslipController::class, 'indexadmin']);
    Route::post('/admin/payslips/add', [PayslipController::class, 'create']);
    Route::delete('/admin/payslips/{payslip}', [PayslipController::class, 'delete']);
});

Route::group(['middleware' => ['auth', 'owner']], function () {

    Route::get('/top/leaves/approval', [TopLeaveController::class, 'show']);
    Route::patch('/top/leaves/approval/{leave}', [TopLeaveController::class, 'update']);
    Route::delete('/top/leaves/approval/{leave}', [TopLeaveController::class, 'delete']);
});

require __DIR__ . '/auth.php';
require __DIR__ . '/agent.php';
