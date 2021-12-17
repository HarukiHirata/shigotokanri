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
        $admin = Admin::where('company_code', $request->company_code)->where('admin_code', $request->admin_code)->get();

        if (count($admin) == 0) {
            // 入力された企業コードの中で一致する管理者コードがない場合、メッセージをセッションに格納してログイン画面にリダイアル。
            session()->flash('toastr', config('toastr.loginfail'));
            return redirect()->route('/admin/login');
        } else {
            // 入力された企業コードの中で一致する管理者コードがあった場合パスワードチェック
            if (Hash::check($request->password, $admin[0]->password)) {
                // パスワード一致
                // セッションにログインユーザーの情報・メッセージを格納
                session(['name' => $admin[0]->name]);
                session(['company_code' => $admin[0]->company_code]);

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
        session()->flash('toastr', config('toastr.logout'));
        return redirect()->route('top');
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit(Admin $admin)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
