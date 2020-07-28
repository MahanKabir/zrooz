<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Person;
use App\Report;
use App\Serial;
use App\Setting;
use Carbon\Carbon;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class SerialController extends Controller
{
    public function index_serial(){
        $serials = Serial::orderBy('serial')->paginate(10);
        $setting = Setting::find(1);
        return view('serial.view', compact('serials', 'setting'));
    }

    public function index_val01(){
        $serials = Serial::orderBy('value01')->paginate(10);
        $setting = Setting::find(1);
        return view('serial.view', compact('serials', 'setting'));
    }

    public function index_val02(){
        $serials = Serial::orderBy('value01')->paginate(10);
        $setting = Setting::find(1);
        return view('serial.view', compact('serials', 'setting'));
    }

    public function index_created_at(){
        $serials = Serial::orderBy('created_at', 'desc')->paginate(10);
        $setting = Setting::find(1);
        return view('serial.view', compact('serials', 'setting'));
    }

    public function create(){
        $setting = Setting::find(1);
        return view('serial.create', compact('setting'));
    }
    public function store(Request $request){
        $serial = new Serial();
        $report = new Report();
        try{
            $request->validate([
                'serial' => 'required|unique:serials|min:16|max:16',
            ], [
                'serial.required' => "شماره سریال وارد نشده است.",
                'serial.unique' => 'شماره سریال تکراری است.',
                'serial.min' => 'شماره سریال باید ۱۶ کاراکتر باشد.',
                'serial.max' => 'شماره سریال باید ۱۶ کاراکتر باشد.',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e){
            $report->action = "شماره سریال مورد نظر ثبت نشد.";
            $report->save();
            throw $e;
        }

        $serial->serial = $this->convertToEnglishNumber($request->serial);
        if($request->value01 == ""){
            $serial->value01 = 0;
        }else{
            $serial->value01 = $this->convertToEnglishNumber($request->value01);
        }
        if($request->value02 == ""){
            $serial->value02 = 0;
        }else{
            $serial->value02 = $this->convertToEnglishNumber($request->value02);
        }
        $serial->save();
        $report->action = "شماره سریال {$request->serial} ثبت شد.";
        $report->save();

        alert()->success('سریال مورد نظر با موفقیت ثبت شد.');

        return redirect()->back();


    }
    public function edit($id){
        $serial = Serial::find($id);
        $setting = Setting::find(1);
        return view('serial.edit', compact('serial', 'setting'));
    }
    public function update(Request $request, $id){

        $report = new Report();
        $serial = Serial::find($id);
        try{
            $request->validate([
                'serial' => 'required|min:16|max:16',
            ], [
                'serial.required' => "شماره سریال وارد نشده است.",
                'serial.min' => 'شماره سریال باید ۱۶ کاراکتر باشد.',
                'serial.max' => 'شماره سریال باید ۱۶ کاراکتر باشد.',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e){
            $report->action = "شماره سریال مورد نظر ویرایش نشد.";
            $report->save();
            throw $e;
        }

        $serial_field = $this->convertToEnglishNumber($serial->serial);
        $value01 = $serial->value01;
        $value02 = $serial->value02;

        $serial->serial = $request->serial;
        if($request->value01 == ""){
            $serial->value01 = 0;
        }else{
            $serial->value01 = $this->convertToEnglishNumber($request->value01);
        }

        if($request->value02 == ""){
            $serial->value02 = 0;
        }else{
            $serial->value02 = $this->convertToEnglishNumber($request->value02);
        }
        $serial->save();

        $data = array();

        if($serial_field != $request->serial){
            array_push($data,
                array(
                    'action' => "سریال از {$serial_field} به {$request->get('serial')} تغییر کرد.",
                    'created_at' => Carbon::now()));
        }
        if($value01 != $request->value01){
            array_push($data,
                array(
                    'action' => "تخفیف کاربر از {$value01} به {$request->get('value01')} تغییر کرد.",
                    'created_at' => Carbon::now()));
        }
        if($value02 != $request->value02){
            array_push($data,
                array(
                    'action' => "تخفیف معرف از {$value02} به {$request->get('value02')} تغییر کرد.",
                    'created_at' => Carbon::now()));
        }
        Report::insert($data);

        alert()->success('سریال مورد نظر با موفقیت ویرایش شد.');

        return redirect(route('serial_sb_serial'));

    }
    public function destroy($id){
        $report = new Report();
        $serial = Serial::find($id);
        $serial->check = 0;
        $saved = $serial->save();
        if(!$saved){
            $report->action = "سریال مورد نظر باطل شد.";
            $report->save();
        }else{
            $report->action = "شماره سریال {$serial->serial} باطل شد.";
            $report->save();
        }
        alert()->success('سریال مورد نظر باطل شد.');
        return redirect(route('serial_sb_serial'));
    }

    public function search(Request $request){

        $search = $request->get('search');
        $setting = Setting::find(1);
        $query = Serial::query();
        if($request->has('sortBy')){
            $query->orderBy($request->get('sortBy'));

        }
        if($request->has('search')){
            $query->where('serial', 'like','%'.$search.'%')
                ->orWhere('value01', 'like','%'.$search.'%')
                ->orWhere('value02', 'like','%'.$search.'%');
        }
        $serials = $query->paginate('10');


        return view('serial.search', compact('serials', 'setting'));
    }

    function convertToEnglishNumber($str){
        $english = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');

        $convertedStr = str_replace($persian, $english, $str);
        return $convertedStr;
    }
}
