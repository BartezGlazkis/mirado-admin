<?php

use Illuminate\Http\Request;

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

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

Route::group(['middleware' => ['auth']], function () {
    Route::post('commerce/add/sale', 'CommerceController@addSale');
    Route::get('commerce/pdf', 'DynamicPDFController@index');
    Route::get('/', 'CommerceController@index');
    Route::get('/commerce', 'CommerceController@index');
    Route::get('/commerce/get', 'CommerceController@getKpList');
    Route::post('/commerce/more', 'CommerceController@getKpBlocks');
    Route::post('/commerce/position/add', 'CommerceController@addPosition');
    Route::post('/commerce/position/delete', 'CommerceController@deletePosition');
    Route::post('/commerce/delete', 'CommerceController@delete');
    Route::post('/commerce/add', 'CommerceController@add');
    Route::post('/commerce/edit', 'CommerceController@edit');
    Route::get('/commerce/pdf/{kp_id}', 'DynamicPDFController@makePdf');

    

    Route::get('sale', 'SaleController@index');

    Route::get('/price', 'PriceListController@index');
    Route::post('/price/get', 'PriceListController@getPositions');


    Route::get('/units/get', function () {
        $units = DB::table('units')->get();
        return response()->json($units);
    });

    Route::get('/suppliers/get', function () {
        $suppliers = DB::table('suppliers')->get();
        return response()->json($suppliers);
    });

    Route::get('/manufacturers/get', function () {
        $manufacturers = DB::table('manufacturers')->get();
        return response()->json($manufacturers);
    });

    Route::get('/categories/get', function () {
        $categories = DB::table('categories')->get();
        return response()->json($categories);
    });

    Route::get('/subcategories/get/{category}', function ($category) {
        $subCategories = DB::table('subCategories')->where('category', $category)->get();
        return response()->json($subCategories);
    });

    Route::get('/commerce/{kp}', function ($kp, Request  $request) {
        if ($request->user()->is('admin')) {
            $kp = DB::table('kp_list')
                ->where('id', $kp)
                ->first();
            return response()->json($kp);
        } else {
            $kp = DB::table('kp_list')
                ->where([
                    'id' => $kp,
                    'user_id' => $request->user()->id()
                ])
                ->first();
            return response()->json($kp);
        }
    });

    Route::get('/blocks/{kp}', function ($kp) {
        $blocks = DB::table('blocks')
            ->join('kp_blocks as kb', 'kb.block_id', '=', 'blocks.id')
            ->select('blocks.id', 'blocks.name')
            ->where('kb.kp_id', $kp)
            ->get();
        return response()->json($blocks);
    });

    Route::get('/blocks', function () {
        $blocks = DB::table('blocks')->select('id', 'name')->get();
        return response()->json($blocks);
    });

    Route::get('/positions/{subCategory}', function ($subCategory) {
        $positions = DB::table('price_position')->where('subCategory', $subCategory)->get();
        return response()->json($positions);
    });

    Route::get('subcategory/{id}', function ($id) {
        $subCategory = DB::table('subCategories')->where('id', $id)->first();
        return response()->json($subCategory);
    });

    Route::get('category/{id}', function ($id) {
        $category = DB::table('categories')->where('id', $id)->first();
        return response()->json($category);
    });
});

Route::group(['middleware' => ['admin']], function () {

    Route::post('price/edit', 'PriceListController@edit');
    Route::post('price/delete', 'PriceListController@delete');
    Route::post('price/add', 'PriceListController@add');

    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');

    Route::get('rate', 'RateController@index');
    Route::post('rate/add', 'RateController@add');
    Route::post('rate/delete', 'RateController@delete');

    Route::get('/users', 'UsersController@index');
    Route::post('/users/delete', 'UsersController@delete');
    Route::post('/users/edit', 'UsersController@edit');

    Route::get('/settings/{table}', 'SettingsController@index')->where('table', '(units|categories|manufacturers|suppliers|blocks)');
    Route::post('/settings/add/{table}', 'SettingsController@add')->where('table', '(units|categories|manufacturers|suppliers|blocks)');
    Route::post('/settings/edit/{table}', 'SettingsController@edit')->where('table', '(units|categories|manufacturers|suppliers|blocks)');
    Route::post('/settings/delete/{table}', 'SettingsController@delete')->where('table', '(units|categories|manufacturers|suppliers|blocks)');
    Route::get('/settings/subcategories', 'SettingsController@subCategories');
    Route::post('/settings/add/subcategories', 'SettingsController@subCategoryAdd');
    Route::post('/settings/delete/subcategories', 'SettingsController@subCategoryDelete');
    Route::post('/settings/edit/subcategories', 'SettingsController@subCategoryEdit');
});
