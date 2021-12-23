<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function adminlogin(Request $request)
    {
        // 管理者テーブル参照
        $admin = Admin::where('company_code', $request->company_code)->where('admin_code', $request->admin_code)->first();

        if (empty($admin)) {
            // 入力された企業コードの中で一致する管理者コードがない場合、メッセージをセッションに格納してログイン画面にリダイアル。
            session()->flash('toastr', config('toastr.loginfail'));
            return redirect()->route('/admin/login');
        } else {
            // 入力された企業コードの中で一致する管理者コードがあった場合パスワードチェック
            if (Hash::check($request->password, $admin->password)) {
                // パスワード一致
                // セッションにログインユーザーの情報・メッセージを格納
                session(['name' => $admin->name]);
                session(['company_code' => $admin->company_code]);
                session(['admin_code' => $admin->admin_code]);
                session(['role' => $admin ->role]);

                session()->flash('toastr', config('toastr.loginsuccess'));
                return redirect()->route('/admin/home');
            } else {
                // パスワード不一致の場合はメッセージをセッションに格納してログイン画面にリダイアル。
                session()->flash('toastr', config('toastr.loginfail'));
                return redirect()->route('/admin/login');
            }
        } 
    }

    public function adminlogout()
    {
        // セッション削除してトップ画面へリダイアル。
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
    public function store(Request $request)
    {
        $this->validate($request, Admin::$rules);

        $admin = new Admin;

        $admin_code_check = Admin::where('company_code', session('company_code'))->where('admin_code', $request->admin_code)->first();

        if (empty($admin_code_check)) {
            $admin->company_code = session('company_code');
            $admin->name = $request->name;
            $admin->admin_code = $request->admin_code;
            $admin->email = $request->email;
            $admin->role = $request->role;
            $admin->password = Hash::make($request->password);
            $admin->delete_flg = 0;
            $admin->save();
            return redirect()->route('/company/home');
        } else {
            session()->flash('toastr', config('toastr.fail'));
            return view('company.adminregister');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
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
    public function update(Request $request, Admin $admin)
    {
        $this->validate($request, Admin::$rules);

        $admin_code_check = Admin::where('company_code', session('company_code'))->where('admin_code', $request->admin_code)->first();

        if (empty($admin_code_check)) {
            $admin = Admin::find($request->admin_id);
            $admin->name = $request->name;
            $admin->admin_code = $request->admin_code;
            $admin->email = $request->email;
            $admin->role = $request->role;
            $admin->save();
            return redirect()->route('/company/home');
        } else {
            session()->flash('toastr', config('toastr.fail'));
            $admin = Admin::where('id', $request->admin_id)->first();
            return view('company.adminregister', ['admin' => $admin]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $admin = Admin::find($request->admin_id);
        $admin->delete_flg = 1;
        $admin->save();

        session()->flash('toastr', config('toastr.delete_success'));
        return redirect()->route('/company/home');
    }
}
