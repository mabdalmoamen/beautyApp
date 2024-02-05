<?php

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('signup', 'App\Http\Controllers\AuthController@signup');
    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('me', 'App\Http\Controllers\AuthController@me');
    Route::post('/reset-password-request', 'App\Http\Controllers\PasswordResetRequestController@sendPasswordResetEmail');
    Route::post('/change-password', 'App\Http\Controllers\ChangePasswordController@passwordResetProcess');
});
Route::delete('types/massDestroy/{types}', 'App\Http\Controllers\Api\TypeController@massDestroy');

Route::apiResource('purchases', 'App\Http\Controllers\Api\PurchaseController');
Route::apiResource('table', 'App\Http\Controllers\Api\TableController');
Route::apiResource('bills/tables', 'App\Http\Controllers\Api\TableOrderController');
Route::apiResource('bookings', 'App\Http\Controllers\Api\TableOrderController');
Route::Get('bills/sendToView/{id}', 'App\Http\Controllers\PrintBill@sendToView');
Route::apiResource('cashier/bills/tables', 'App\Http\Controllers\Api\CashierTableOrderController');
Route::apiResource('cashier/pendingBills', 'App\Http\Controllers\Api\CashierTableOrderController');

Route::apiResource('shift', 'App\Http\Controllers\Api\ShiftController');
Route::Get('shift/report/{form}/{to}', 'App\Http\Controllers\Api\ShiftController@shiftReport');
Route::Get('/action/units/{unitID}/{typeId}', 'App\Http\Controllers\Api\ActionController@findUnitByTypeIdAndUnitId');
Route::Get('codies/{tables}', 'App\Http\Controllers\Api\ActionController@resetFunc');
Route::Get('showIntable/{id}', 'App\Http\Controllers\Api\ActionController@showIntable');
Route::Get('checkHaveRole/{role}', 'App\Http\Controllers\Api\UserController@checkHaveRole');

//Route::apiResource('typeStocks', 'App\Http\Controllers\Api\BillController');
// billController
Route::apiResource('bills', 'App\Http\Controllers\Api\BillController');
Route::Get('/bill/shift', 'App\Http\Controllers\Api\BillController@getLastEndedCash');
Route::Get('/bill/report/{period}/{form}/{to}/{perPage}', 'App\Http\Controllers\Api\BillController@billsReport');
Route::Get('/bill/calc/{period}/{form}/{to}', 'App\Http\Controllers\Api\BillController@billsReportCalc');

// billController
Route::Get('cashier/bill/shift', 'App\Http\Controllers\Api\CashierBillController@getLastEndedCash');
Route::Get('cashier/bill/report/{period}/{form}/{to}/{perPage}', 'App\Http\Controllers\Api\CashierBillController@billsReport');
Route::Get('cashier/bill/calc/{period}/{form}/{to}', 'App\Http\Controllers\Api\CashierBillController@billsReportCalc');

Route::apiResource('points', 'App\Http\Controllers\Api\PointsController');
Route::get('validatePoint/{id}', 'App\Http\Controllers\Api\PointsController@validatePoint');

Route::apiResource('cashier/types', 'App\Http\Controllers\Api\CashierTypeController');
Route::apiResource('types', 'App\Http\Controllers\Api\TypeController');
Route::Get('/types/report/{period}/{form}/{to}/{typeid}', 'App\Http\Controllers\Api\TypeController@TypesReport');

Route::get('findTypeByBarcode/{id}', 'App\Http\Controllers\Api\TypeController@findTypeByBarcode');
Route::apiResource('mainTypes', 'App\Http\Controllers\Api\MainTypesController');
Route::Get('printers', 'App\Http\Controllers\Api\MainTypesController@printers');
Route::get('setDefaultprinter/{name}', 'App\Http\Controllers\Api\MainTypesController@setDefaultprinter');

Route::apiResource('customers', 'App\Http\Controllers\Api\CustomerController');
Route::apiResource('customerPay', 'App\Http\Controllers\Api\CustomerPayController');

Route::apiResource('suppliers', 'App\Http\Controllers\Api\SupplierController');
Route::apiResource('mixins', 'App\Http\Controllers\Api\MixinsController');
Route::apiResource('typeStocks', 'App\Http\Controllers\Api\TypeStockController');
Route::apiResource('payMethods', 'App\Http\Controllers\Api\PayMethodsController');
Route::apiResource('users', 'App\Http\Controllers\Api\UserController');
Route::apiResource('usersRole', 'App\Http\Controllers\Api\RolesController');

Route::apiResource('workers', 'App\Http\Controllers\Api\WorkerController');
Route::apiResource('roles', 'App\Http\Controllers\Api\MixinsRolesController');
Route::apiResource('user/roles', 'App\Http\Controllers\Api\UserRolesController');
Route::apiResource('offers', 'App\Http\Controllers\Api\OfferController');
Route::apiResource('units', 'App\Http\Controllers\Api\UnitsController');
Route::apiResource('mainunits', 'App\Http\Controllers\Api\MainUnitsController');
Route::apiResource('barcodes', 'App\Http\Controllers\Api\BarcodesController');

Route::apiResource('saleType', 'App\Http\Controllers\Api\SalesTypeController');
Route::apiResource('expenses', 'App\Http\Controllers\Api\ExpenseController');

Route::get('active/user/roles/{id}', 'App\Http\Controllers\Api\UserController@roles');
Route::get('user/roles/{id}', 'App\Http\Controllers\Api\MixinsRolesController@findRoleByUserId');
Route::Get('last/id', 'App\Http\Controllers\Api\ActionController@lastId');


//Reports Route
Route::Get('/expense/report/{period}/{form}/{to}', 'App\Http\Controllers\Api\ExpenseController@expensesReport');
Route::Get('/expense/calc/{period}/{form}/{to}', 'App\Http\Controllers\Api\ExpenseController@expensesReportCalc');

Route::Get('/purbill/calc/{period}/{form}/{to}', 'App\Http\Controllers\Api\PurchaseController@billsReportCalc');
Route::Get('/bill/purchases/report/{period}/{form}/{to}', 'App\Http\Controllers\Api\PurchaseController@purchasesBillReport');
Route::Get('/process/report/{period}/{form}/{to}', 'App\Http\Controllers\Api\ActionController@processBillsReport');
Route::Get('/process/calc/{period}/{form}/{to}', 'App\Http\Controllers\Api\ActionController@processBillsReportCalc');

Route::Get('/customer/report/{form}/{to}/{id}', 'App\Http\Controllers\Api\CustomerController@customerReport');
Route::Get('/customer/pay/{form}/{to}/{id}', 'App\Http\Controllers\Api\CustomerController@customerCashReport');

//ActionController
Route::Get('/action/{id}', 'App\Http\Controllers\Api\ActionController@addToExitStock');
Route::Get('/action/find/{id}', 'App\Http\Controllers\Api\ActionController@findTypeByCodeOrId');
Route::Get('/action/like/{like}', 'App\Http\Controllers\Api\ActionController@findTypeByLike');
Route::Get('/action/findBillWithTypeId/{like}', 'App\Http\Controllers\Api\ActionController@findBillWithTypeId');
Route::Get('/action/paybill/{bill}/{pay}', 'App\Http\Controllers\Api\ActionController@payBill');

Route::Get('/supplierPay', 'App\Http\Controllers\Api\ActionController@index');
Route::Get('/supplierPay/{id}/{pay}', 'App\Http\Controllers\Api\ActionController@supplierPay');
Route::Get('/AllCategories', 'App\Http\Controllers\Api\ActionController@getAllCategories');

Route::Get('/action/check/{id}', 'App\Http\Controllers\Api\ActionController@checkIfTypeAddedToItemRequestToday');
Route::Get('/item/request/report/{form}/{to}/{status}', 'App\Http\Controllers\Api\ActionController@allRequests');
Route::Get('/action/all/customers', 'App\Http\Controllers\Api\ActionController@findCustomers');

Route::Get('action/customerPay/{type}', 'App\Http\Controllers\Api\ActionController@PaidDetails');
Route::Get('action/offerType/{id}', 'App\Http\Controllers\Api\ActionController@getOfferType');
Route::Get('action/findBillById/{id}', 'App\Http\Controllers\Api\ActionController@findBillById');

Route::apiResource('gusto/stocks', 'App\Http\Controllers\Api\GustoTypeStockController');

Route::apiResource('stocks', 'App\Http\Controllers\Api\StockController');

Route::apiResource('currency', 'App\Http\Controllers\Api\CurrencyController');
Route::apiResource('attendance', 'App\Http\Controllers\Api\UserAttendanceController');
Route::Get('/attendance/report/{period}/{from}/{to}/{uid}', 'App\Http\Controllers\Api\UserAttendanceController@report');
Route::Get('/branches/{period}/{from}/{to}', 'App\Http\Controllers\Api\ActionController@AllBranchesReport');
