<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Person;
use App\Report;
use App\Serial;
use App\Setting;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MainController extends Controller
{
    public function index(){
        $setting = Setting::find(1);
        return view('setting.view', compact('setting'));
    }

    //Name
    public function edit_name($id){
        $setting = Setting::find($id);
        return view('setting.edit', compact('setting'));
    }
    public function update_name(Request $request, $id){
        $report = new Report();

        $setting = Setting::find($id);
        $setting->name = $request->get('name');
        $saved = $setting->save();

        if(!$saved){
            $report->action = "نام فروشگاه تغییر نیافت.";
            $report->save();
        }else{
            $report->action = "نام فروشگاه به {$setting->name} تغییر یافت.";
            $report->save();
        }
        alert()->success('تغییر نام فروشگاه با موفقیت انجام شد.');
        return redirect()->back();
    }

    //Phone
    public function edit_phone($id){
        $setting = Setting::find($id);
        return view('setting.edit', compact('setting'));
    }
    public function update_phone(Request $request, $id){
        $report = new Report();

        $setting = Setting::find($id);
        $setting->phone = $request->get('phone');
        $setting->save();
        $saved = $setting->save();

        if(!$saved){
            $report->action = "شماره تماس فروشگاه تغییر نیافت.";
            $report->save();
        }else{
            $report->action = "شماره تماس فروشگاه به {$setting->phone} تغییر یافت.";
            $report->save();
        }
        alert()->success('تغییر شماره تماس فروشگاه با موفقیت انجام شد.');
        return redirect()->back();
    }

    //Value
    public function edit_value($id){
        $setting = Setting::find($id);
        return view('setting.edit', compact('setting'));
    }
    public function update_value(Request $request, $id){
        $report = new Report();

        $setting = Setting::find($id);
        $setting->value = $request->get('value');
        $setting->save();
        $saved = $setting->save();

        if(!$saved){
            $report->action = "تخفیف ثبت نام تغییر نیافت.";
            $report->save();
        }else{
            $report->action = "تخفیف ثبت نام به {$setting->value} تغییر یافت.";
            $report->save();
        }
        alert()->success('تغییر تخفیف ثبت نام با موفقیت انجام شد.');
        return redirect()->back();
    }

    //Change Password
    public function update_password(Request $request){
        $report = new Report();

        $user= Auth::user();
        if(empty($request->password)){
            alert()->error('تغییر گذرواژه وبسایت با موفقیت انجام نشد.')->persistent('باشه');
            $report->action = "پسورد وبسایت تغییر نیافت.";
            $report->save();
            return redirect(route('setting_name_view'));
        }else{
            $user->password = Hash::make($request->get('password'));
            $saved = $user->save();
            if(!$saved){
                $report->action = "پسورد وبسایت تغییر نیافت.";
                $report->save();
            }else{
                $report->action = "پسورد وبسایت تغییر یافت.";
                $report->save();
            }
            alert()->success('تغییر شماره تماس فروشگاه با موفقیت انجام شد.');
            return redirect()->back();
        }
    }


    public function index_created_at(){
        $reports = Report::orderBy('created_at', 'desc')->paginate(20);
        $setting = Setting::find(1);
        return view('report', compact('reports', 'setting'));
    }

    public function index_action(){
        $reports = Report::orderBy('action', 'desc')->paginate(20);
        $setting = Setting::find(1);
        return view('report', compact('reports', 'setting'));
    }

    public function search(Request $request){
        $search = $request->get('search');
        $setting = Setting::find(1);
        $query = Report::query();
        if($request->has('sortBy')){
            $query->orderBy($request->get('sortBy'));

        }
        if($request->has('search')){
            $query->where('action', 'like','%'.$search.'%');

        }
        $reports = $query->paginate('20');


        return view('report.search', compact('reports', 'setting'));
    }

}
