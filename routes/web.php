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

use App\Person;
use App\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

Route::get('pdf',function (){
    $data = \App\Serial::all('serial', 'check');
    $pdf = App::make('dompdf.wrapper');
    view()->share('serials',$data);
    $pdf->loadView('pdf')->setPaper('a4', 'landscape');
    return $pdf->stream();
})->name('pdf');

Route::get('fake', function (){
    factory(\App\Person::class, 10)->create();
    factory(\App\Serial::class, 10)->create();
});

Route::get('confirm/{id}',function ($id){
    $phone_number = \App\Person::find($id);
    $api = new \Ghasedak\GhasedakApi( 'a5affb19a701b2b44bc7f78310b9155f58643fa476e18631bd687f5619bb3b59');
    $random = rand(1000, 9999);
    $api->Verify($phone_number->phone, 1,'validate', $random);
    $report = new Report();
    $report->action = "کد تایید کاربر $phone_number->phone ، $random می باشد.";
    $report->save();
    alert()->success("کد تایید کاربر $phone_number->phone ، $random می باشد.")->persistent('باشه');
    return \redirect()->back();
})->name('person_confirm');

Route::get('recieve', function (Request $request){

    $api = new \Ghasedak\GhasedakApi( 'a5affb19a701b2b44bc7f78310b9155f58643fa476e18631bd687f5619bb3b59');
    $content = $request->get('message');
    $phone_number = $request->get('from');

    $person = new Person();
    $report = new Report();

    if(strlen($content) == 16){

        //check phone number if exist
        $person_phone= \App\Person::where('phone', '=', $phone_number)->first();
        if($person_phone == null)
        {
            $person->phone = $phone_number;
            $person->value = 0;
            $random = rand(100000, 999999);
            if(\App\Person::where('individual', '=', $random)){
                $random = rand(100000, 999999);
                $person->individual = $random;
            }else{
                $person->individual = $random;
            }
            $person->save();
            $report->action = "ثبت نام کاربر با شماره تماس $phone_number و با کد کاربری $person->individual انجام شد.";
            $report->save();
            $api->Verify($phone_number, 1,'register', $person->individual);
        }

        $person = \App\Person::where('phone', '=', $phone_number)->first();
        $person_parent = \App\Person::where('individual', '=', $person->parent)->first();

        if ($person != null){
            $serial = \App\Serial::where('serial', '=', $content)->first();
            if ($serial != null){
                if($serial->check == 1){
                    if($person->parent != null and $person->check == 0){
                        $setting = \App\Setting::find(1);
                        $person->value += $serial->value01 + $setting->value;
                        $person->check = 1;
                        $person->save();
                        $person_parent->value += $serial->value02;
                        $person_parent->save();
                        $serial->check = 0;
                        $serial->save();
                        $api->Verify($person_parent->phone, 1,'discount01', $serial->value02);
                    }else{
                        $person->value += $serial->value01;
                        $person->save();
                        $serial->check = 0;
                        $serial->save();
                    }
                    $api->Verify($phone_number, 1,'discount', $serial->value01);
                }else{
                    $api->Verify($phone_number, 1,'notexist', $content);
                }
            }else{
                $api->Verify($phone_number, 1,'notexist', $content);
            }
        }
    }
    elseif (strlen($content) == 6){
        //check phone number if exist
        $person_phone= \App\Person::where('phone', '=', $phone_number)->first();
        if($person_phone == null)
        {
            $person->phone = $phone_number;
            $person->value = 0;
            $random = rand(100000, 999999);
            if(\App\Person::where('individual', '=', $random)){
                $random = rand(100000, 999999);
                $person->individual = $random;
            }else{
                $person->individual = $random;
            }
            $person->save();
            $report->action = "ثبت نام کاربر با شماره تماس $phone_number و با کد کاربری $person->individual انجام شد.";
            $report->save();
        }

        $person_individual = \App\Person::where('individual', '=', $content)->first();
        $person_phone = \App\Person::where('phone', '=', $phone_number)->first();
        if($person_individual != null and $person_phone != null){
            $person->parent = $content;
            $person->save();
            if($person->parent != null and $person->value == 0){
                $api->Verify($phone_number, 1,'welcome', $phone_number);

            }else{
                $api->Verify($phone_number, 1,'register', $phone_number);
            }
        }else{
            $api->Verify($phone_number, 1,'noexist1', $content);
        }

    }elseif (strlen($content) == 1){

        //check phone number if exist
        $person_phone= \App\Person::where('phone', '=', $phone_number)->first();
        if($person_phone == null)
        {
            $person->phone = $phone_number;
            $person->value = 0;
            $random = rand(100000, 999999);
            if(\App\Person::where('individual', '=', $random)){
                $random = rand(100000, 999999);
                $person->individual = $random;
            }else{
                $person->individual = $random;
            }
            $person->save();
            $report->action = "ثبت نام کاربر با شماره تماس $phone_number و با کد کاربری $person->individual انجام شد.";
            $report->save();
            $api->Verify($phone_number, 1,'register', $person->individual);

        }
        if($content == '1'){
            $person = Person::where('phone', '=', $phone_number)->first();
            if($person->value == 0){
                $api->Verify($phone_number, 1,'Inventory', 'صفر');

            }else{
                $api->Verify($phone_number, 1,'Inventory', $person->value);
            }
        }elseif ($content == 2){
            $person = Person::where('phone', '=', $phone_number)->first();
            $api->Verify($phone_number, 1,'Introductioncode', $person->individual);
        }elseif ($content == 3){
            $person_parent = Person::where('phone', '=', $phone_number)->first();
            $person_subset = Person::where('parent', '=', $person_parent->individual)->get();
            if(count($person_subset) == 0){
                $api->Verify($phone_number, 1,'friends', 'صفر');

            }else{
                $api->Verify($phone_number, 1,'friends', count($person_subset));
            }
        }else{
            $api->Verify($phone_number, 1,'invalid', $phone_number);
        }
    }else{
        $api->Verify($phone_number, 1,'invalid', $phone_number);
    }
});

Route::get('/', function (){

    $people = \App\Person::all();
    $serials = \App\Serial::all();
    $reports = \App\Report::all();

    $people_count = $people->count();
    $serials_count = $serials->count();
    $reports_count = $reports->count();
    $serials_check_0_count = $serials->where('check', '=', 0)->count();
    $serials_check_1_count = $serials->where('check', '=', 1)->count();
    $serials_value01 = $serials->sum('value01');

    $setting = \App\Setting::find(1);
    $report = new Report();
    $user = Auth::user();

    if (isset($user->is_login)) {
        if ($user->is_login == 0){
            if (isset($user->username)) {
                $report->action = "{$user->username} وارد وبسایت شد.";
                $report->save();
            }
            $user->is_login = 1;
            $user->save();

        }
    }
    return view('statistics', compact(
        'setting',
        'people_count',
        'serials_count',
        'reports_count',
        'serials_check_0_count',
        'serials_check_1_count',
        'serials_value01'
    ));

})->name('main')->middleware('auth');

Route::get('logout',
    function () {
        $user = Auth::user();
        $report = new Report();
        auth()->logout();
        Session()->flush();
        if (isset($user->is_login)) {
            if ($user->is_login == 1) {
                if (isset($user->username)) {
                    $report->action = "{$user->username} از وبسایت خارج شد.";
                    $report->save();
                }
                $user->is_login = 0;
                $user->save();
            }
        }
        return Redirect::to('login');
    })->name('logout');

Route::group(['namespace' => 'Admin', 'prefix' => 'admin/person', 'middleware' => 'auth'], function (){
    Route::get('view_name', 'PersonController@index_name')->name('person_sb_name');
//    Route::get('view_name_rev', 'PersonController@index_name_rev')->name('person_sb_name_rev');
    Route::get('view_code', 'PersonController@index_code')->name('person_sb_code');
    Route::get('view_phone', 'PersonController@index_phone')->name('person_sb_phone');
    Route::get('view_mail', 'PersonController@index_mail')->name('person_sb_email');
    Route::get('view_created_at', 'PersonController@index_created_at')->name('person_sb_created_at');

    Route::get('create', 'PersonController@create')->name('person_create');
    Route::post('store', 'PersonController@store')->name('person_store');
    Route::get('edit/{id}', 'PersonController@edit')->name('person_edit');
    Route::put('update/{id}', 'PersonController@update')->name('person_update');
    Route::post('delete/{id}', 'PersonController@destroy')->name('person_destroy');
    Route::get('search', 'PersonController@search')->name('person_search');

});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin/serial', 'middleware' => 'auth'], function (){
    Route::get('view_serial', 'SerialController@index_serial')->name('serial_sb_serial');
    Route::get('view_val01', 'SerialController@index_val01')->name('serial_sb_val01');
    Route::get('view_val02', 'SerialController@index_val02')->name('serial_sb_val02');
    Route::get('view_created_at', 'SerialController@index_created_at')->name('serial_sb_created_at');

    Route::get('create', 'SerialController@create')->name('serial_create');
    Route::post('store', 'SerialController@store')->name('serial_store');
    Route::get('edit/{id}', 'SerialController@edit')->name('serial_edit');
    Route::put('update/{id}', 'SerialController@update')->name('serial_update');
    Route::post('delete/{id}', 'SerialController@destroy')->name('serial_destroy');
    Route::get('search', 'SerialController@search')->name('serial_search');

});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin/setting', 'middleware' => 'auth'], function (){
    Route::get('edit/name/{id}', 'MainController@edit_name')->name('setting_name_edit');
    Route::post('update/name/{id}', 'MainController@update_name')->name('setting_name_update');
    Route::get('edit/phone/{id}', 'MainController@edit_phone')->name('setting_phone_edit');
    Route::post('update/phone/{id}', 'MainController@update_phone')->name('setting_phone_update');

    Route::get('edit/value/{id}', 'MainController@edit_value')->name('setting_value_edit');
    Route::post('update/value/{id}', 'MainController@update_value')->name('setting_value_update');

    Route::post('update/password', 'MainController@update_password')->name('setting_password_update');

    Route::get('report_created_at', 'MainController@index_created_at')->name('report_created_at');
    Route::get('report_action', 'MainController@index_action')->name('report_action');
    Route::get('search', 'MainController@search')->name('report_search');

});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
