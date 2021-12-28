<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AdminRequest;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function adminlogin(Request $request)
    {
        $admin = Admin::where('company_code', $request->company_code)->where('admin_code', $request->admin_code)->first();

        if (empty($admin)) {
            session()->flash('toastr', config('toastr.loginfail'));
            return back()->withInput()->with(['login_error' => '企業コードもしくは管理者コードが間違っています。']);
        } else {
            if (Hash::check($request->password, $admin->password)) {
                session(['name' => $admin->name]);
                session(['company_code' => $admin->company_code]);
                session(['admin_code' => $admin->admin_code]);
                session(['role' => $admin ->role]);

                session()->flash('toastr', config('toastr.loginsuccess'));
                return redirect()->route('/admin/home');
            } else {
                session()->flash('toastr', config('toastr.loginfail'));
                return back()->withInput()->with(['login_error' => 'パスワードが間違っています。']);
            }
        } 
    }

    public function adminlogout()
    {
        session()->forget('name');
        session()->forget('company_code');
        session()->forget('admin_code');
        session()->forget('role');
        session()->flash('toastr', config('toastr.logout'));
        return redirect()->route('top');
    }

    public function index()
    {
        $admins = Admin::where('company_code', session('company_code'))->get();
        return view('company.home', ['admins' => $admins]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company.adminregister');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRequest $request)
    {
        DB::transaction(function () use ($request) {
            $admin = new Admin;
            $admin->company_code = session('company_code');
            $admin->name = $request->name;
            $admin->admin_code = $request->admin_code;
            $admin->email = $request->email;
            $admin->role = $request->role;
            $admin->password = Hash::make($request->password);
            $admin->delete_flg = 0;
            $admin->save();
        });
        return redirect()->route('/company/home');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admin = Admin::where('id', $id)->first();
        return view('company.adminedit', ['admin' => $admin]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(AdminRequest $request, Admin $admin)
    {
        DB::transaction(function () use ($request) {
            $admin = Admin::find($request->admin_id);
            $admin->name = $request->name;
            $admin->admin_code = $request->admin_code;
            $admin->email = $request->email;
            $admin->role = $request->role;
            $admin->save();
        });
        return redirect()->route('/company/home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::transaction(function () use ($request) {
            $admin = Admin::find($request->admin_id);
            $admin->delete_flg = 1;
            $admin->save();
        });

        session()->flash('toastr', config('toastr.delete_success'));
        return redirect()->route('/company/home');
    }
}