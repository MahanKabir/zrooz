<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Notifications\SMS;
use App\Person;
use App\Report;
use App\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Morilog\Jalali\Jalalian;

class PersonController extends Controller
{


    public function index_name(){
        $persons = Person::orderBy('name')->paginate(20);
        $setting = Setting::find(1);
        return view('person.view', compact('persons', 'setting'));
    }

//    public function index_name_rev(){
//        $persons = Person::orderBy('name', 'desc')->get();
//        $setting = Setting::find(1);
//        return view('person.view', compact('persons', 'setting'));
//    }
    public function index_code(){
        $persons = Person::orderBy('code')->paginate(20);
        $setting = Setting::find(1);
        return view('person.view', compact('persons', 'setting'));
    }
    public function index_phone(){
        $persons = Person::orderBy('phone')->paginate(20);
        $setting = Setting::find(1);
        return view('person.view', compact('persons', 'setting'));
    }
    public function index_mail(){
        $persons = Person::orderBy('email')->paginate(20);
        $setting = Setting::find(1);
        return view('person.view', compact('persons', 'setting'));
    }
    public function index_date(){
        $persons = Person::orderBy('date')->paginate(20);
        $setting = Setting::find(1);
        return view('person.view', compact('persons', 'setting'));
    }
    public function index_created_at(){
        $persons = Person::orderBy('created_at', 'desc')->paginate(20);
        $setting = Setting::find(1);
        return view('person.view', compact('persons', 'setting'));
    }

    public function create(){
        $setting = Setting::find(1);
        return view('person.create', compact('setting'));
    }
    public function store(Request $request){
        $person = new Person();
        $report = new Report();

        try{
            $request->validate([
                'phone' => 'required|unique:people|between:11, 13',
            ], [
                'phone.required' => "شماره تلفن وارد نشده است.",
                'phone.unique' => 'شماره تلفن تکراری است.',
                'phone.between' => 'شماره تلفن به درستی وارد نشده است.',
            ]);
        }catch(\Illuminate\Validation\ValidationException $e) {
            //Add custom validation error routine
            $report->action = "اطلاعات کاربر مورد نظر ثبت نشد.";
            $report->save();
            throw $e;
        }

        $person->name = $request->name;
        $person->code = $this->convertToEnglishNumber($request->code);
        $persian_phone = $this->convertToEnglishNumber($request->phone);

        $person->phone = str_replace("+98", "0",$persian_phone);
        $person->individual = rand(100000, 999999);
        $person->email = $request->email;
        if($request->value == ""){
            $person->value = 0;
        }else{
            $person->value = $this->convertToEnglishNumber($request->value);
        }

        $person->address = $request->address;

        if($request->image){
            $file = $request->file('image')->store('public/images/person/');
            $person->image = asset('storage/images/person/'.pathinfo($file, PATHINFO_BASENAME));
        }
        $person->save();
        $report->action = "اطلاعات کاربر با شماره تلفن همراه {$person->phone} ثبت شد.";
        $report->save();

        alert()->success('اطلاعات کاربر با موفقیت ثبت شد.');

        return redirect()->back();
    }

    public function edit($id){
        $person = Person::find($id);
        $setting = Setting::find(1);

        return view('person.edit', compact('person', 'setting'));
    }
    public function update(Request $request, $id){
        $person = Person::find($id);
        $report = new Report();

        $name = $person->name;
        $code = $person->code;
        $phone = str_replace("+98", "0", $person->phone);
        $email = $person->email;
        $value = $person->value;
        $person->individual = rand(100000, 999999);
        $address = $person->address;

        try{
            $request->validate([
                'phone' => 'required|between:11, 13',
            ], [
                'phone.required' => "شماره تلفن وارد نشده است.",
                'phone.between' => 'شماره تلفن به درستی وارد نشده است.',
            ]);
        }catch(\Illuminate\Validation\ValidationException $e) {
            //Add custom validation error routine
            $report->action = "اطلاعات کاربر مورد نظر ویرایش نشد.";
            $report->save();
            throw $e;
        }
        $person->name = $request->name;
        $person->code = $this->convertToEnglishNumber($request->code);
        $person->phone = $this->convertToEnglishNumber($request->phone);
        $person->email = $request->email;
        if($request->value == ""){
            $person->value = 0;
        }else{
            $person->value = $this->convertToEnglishNumber($request->value);
        }

        $person->address = $request->address;
        if($request->image){
            $file = $request->file('image')->store('public/images/person/');
            $person->image = asset('storage/images/person/'.pathinfo($file, PATHINFO_BASENAME));
        }
        $person->save();

        $data = array();

        if($name != $request->name){
            array_push($data,
                array(
                    'action' => "نام کاربر از {$name} به {$request->get('name')} تغییر کرد.",
                    'created_at' => Carbon::now()));
        }
        if($code != $request->code){
            array_push($data,
                array(
                    'action' =>  "کدملی کاربر از {$code} به {$request->get('code')} تغییر کرد.",
                    'created_at' => Carbon::now()));
        }
        if($phone != $request->phone){
            array_push($data,
                array(
                    'action' => "تلفن همراه کاربر از {$phone} به {$request->get('phone')} تغییر کرد.",
                    'created_at' => Carbon::now()));
        }
        if($email != $request->email){
            array_push($data,
                array(
                    'action' => "ایمیل کاربر از {$email} به {$request->get('email')} تغییر کرد.",
                    'created_at' => Carbon::now()));
        }
        if($value != $request->value){
            array_push($data,
                array(
                    'action' => "کد تخفیف کاربر از {$value} به {$request->get('value')} تغییر کرد.",
                    'created_at' => Carbon::now()));
        }

        if($address != $request->address){
            array_push($data,
                array(
                    'action' => "نشانی کاربر از {$address} به {$request->get('address')} تغییر کرد.",
                    'created_at' => Carbon::now()));
        }
        Report::insert($data);
        alert()->success('اطلاعات کاربر با موفقیت ویرایش شد.');

        return redirect(route('person_sb_name'));
    }

    public function destroy($id){
        $report = new Report();

        $person = Person::find($id);
        $deleted = $person->delete();
        if(!$deleted){
            $report->action = "اطلاعات کاربر حذف نشد.";
            $report->save();
        }else{
            $report->action = "اطلاعات کاربر با شماره تماس $person->phone حذف شد.";
            $report->save();
        }
        alert()->success('اطلاعات کاربر با موفقیت حذف شد.');
        return redirect()->back();
    }

    public function search(Request $request){
        $search = $request->get('search');
        $setting = Setting::find(1);
        $query = Person::query();
        if($request->has('sortBy')){
            $query->orderBy($request->get('sortBy'));

        }
        if($request->has('search')){
            $query->where('name', 'like','%'.$search.'%')
                ->orWhere('code', 'like','%'.$search.'%')
                ->orWhere('phone', 'like','%'.$search.'%')
                ->orWhere('email', 'like','%'.$search.'%');
        }
        $people = $query->paginate('10');


        return view('person.search', compact('people', 'setting'));

    }

    function convertToEnglishNumber($str){
        $english = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');

        $convertedStr = str_replace($persian, $english, $str);
        return $convertedStr;
    }

    public function convertToPersianNumber($str){
        $english = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');

        $convertedStr = str_replace($english, $persian, $str);
        return $convertedStr;
    }
}
