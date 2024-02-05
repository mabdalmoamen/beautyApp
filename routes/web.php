<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
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

Route::get('/', function () {
    return view('index');
});

use App\Http\Controllers\SMSController;

// reports
Route::get('report', 'App\Http\Controllers\ReportController@report')->middleware('api');
Route::get('worker/report', 'App\Http\Controllers\Api\WorkerController@report')->middleware('api');
Route::get('print/test', '\App\Http\Controllers\PrintBill@test')->name('testPrint');

Route::get('Fbills', 'App\Http\Controllers\BillController@index')->name('Fbill');
Route::get('RTypes', 'App\Http\Controllers\GeneralController@TypeReport')->middleware('api');
Route::get('types/home', 'App\Http\Controllers\GeneralController@types')->middleware('api');
Route::get('update', 'App\Http\Controllers\BillController@update')->name('update');
Route::get('updated', 'App\Http\Controllers\BillController@updated')->name('updated');
Route::get('typesToExcel', 'App\Http\Controllers\BillController@types')->name('typesToExcel');
// Trash
// Route::get('trash', 'App\Http\Controllers\TrashController@index')->name('trash');
Route::get('trash/types', 'App\Http\Controllers\TrashController@types')->name('trash.types');
Route::get('trash/bills', 'App\Http\Controllers\TrashController@bills')->name('trash.bills');
Route::get('restore/{id}', 'App\Http\Controllers\TrashController@restore')->name('restore');
Route::get('restore/bills/{id}', 'App\Http\Controllers\TrashController@restoreBill')->name('restore.bill');
Route::get('delete/bills/{id}', 'App\Http\Controllers\TrashController@delete')->name('delete.bill');

Route::get('send-mail', function () {
    $email_to = DB::table('mixins_info')->select('email_to')->where('id', 1)->first();
    \Mail::to($email_to->email_to)->send(new \App\Mail\ReportMail());
    dd("Email is Sent.");
});
Route::get('/printTokitchen/{id}', '\App\Http\Controllers\PrintBill@index')->name('printTokitchen');
Route::Get('bills/sendToView/{id}', 'App\Http\Controllers\PrintBill@sendToView');
// Route::get('/bills', '\App\Http\Controllers\UsersController\BillController@index')->name('bills');
Route::get('/printTokitchendir/{id}', '\App\Http\Controllers\PrintBill@indexdir')->name('printTokitchendir');

Route::get('chang/lang', function ($request, Closure $next) {
    $language = DB::table('mixins_info')->select('default_lang')->where('id', 1)->first();
    if ($language->default_lang === "ar") {
        DB::table('mixins_info')->where('id', '1')->update(['default_lang' => 'en']);
    } else {
        DB::table('mixins_info')->where('id', '1')->update(['default_lang' => 'ar']);
    }
    $language = DB::table('mixins_info')->select('default_lang')->where('id', 1)->first();
    Cookie::queue('locale',  $language->default_lang, time() + (20 * 365 * 24 * 60 * 60));
    if (isset($language->default_lang)) {
        app()->setLocale($language);
    }
    return $next($request);
});
Route::get('get-coc', [App\Http\Controllers\Api\ActionController::class, 'getCookie']);

Route::get('sendWhatsApp', [SMSController::class, 'sendWhatsApp']);
Route::get('sendSMS', [SMSController::class, 'sendSms']);
Route::get('/{vue_capture?}', function () {
    return view('index');
})->where('vue_capture', '[\/\w\.-]*');
Auth::routes();

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
