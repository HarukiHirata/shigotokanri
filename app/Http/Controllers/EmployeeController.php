<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function emplogin(Request $request)
    {
        // 従業員テーブル参照
        $employee = Employee::where('company_code', $request->company_code)->where('employee_code', $request->employee_code)->get();

        if (count($employee) == 0) {
            // 入力された企業コードの中で一致する従業員コードがなかったり、入力された企業コードが存在しなかったりする場合、メッセージをセッションに格納してログイン画面にリダイアル。
            session()->flash('toastr', config('toastr.loginfail'));
            return redirect()->route('/employee/login');
        } else {
            // 入力された企業コードの中で一致する従業員コードがあった場合パスワードチェック
            if (Hash::check($request->password, $employee[0]->password)) {
                // パスワード一致
                // セッションにログインユーザーの情報・メッセージを格納
                session(['employee_id' => $employee[0]->id]);
                session(['name' => $employee[0]->name]);
                session(['company_code' => $employee[0]->company_code]);
                session(['employee_code' => $employee[0]->employee_code]);

                session()->flash('toastr', config('toastr.loginsuccess'));
                return redirect()->route('/employee/home');
            } else {
                // パスワード不一致の場合はメッセージをセッションに格納してログイン画面にリダイアル。
                session()->flash('toastr', config('toastr.loginfail'));
                return redirect()->route('/employee/login');
            }
        } 
    }

    public function emplogout()
    {
        // セッション削除してトップ画面ヘリダイアル。
        session()->forget('employee_id');
        session()->forget('name');
        session()->forget('company_code');
        session()->forget('employee_code');
        session()->flash('toastr', config('toastr.logout'));
        return redirect()->route('top');
    }

    public function index()
    {
        $employees = $this->employeesbycompany();
        return view('admin.employeeindex', ['employees' => $employees]);
    }

    public function employeesbycompany() {
        $employees = Employee::where('company_code', session('company_code'))->get();
        return $employees;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.employeeregister');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // バリデーション
        $this->validate($request, Employee::$rules);

        // インスタンス生成後、タイムスタンプを無効化。
        $employee = new Employee;
        $employee->timestamps = false;

        // 従業員コードにダブりがないかチェック。
        $employee_code_check = Employee::where('company_code', session('company_code'))->where('employee_code', $request->employee_code)->first();

        if (empty($employee_code_check)) {
            // 従業員コードにダブりがない場合、フォームで入力された値やセッションの企業コードなどをインスタンスのプロパティに入れてDBへ保存。
            $employee->name = $request->name;
            $employee->employee_code = $request->employee_code;
            $employee->company_code = session('company_code');
            $employee->email = $request->email;
            $employee->password = Hash::make($request->password);
            $employee->delete_flg = 0;
            $employee->save();

            // 登録成功のメッセージをセッションに保存して従業員一覧画面へ遷移。
            session()->flash('toastr', config('toastr.success'));
            return redirect()->route('employeeindex');
        } else {
            session()->flash('toastr', config('toastr.fail'));
            return view('admin.employeeregister');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::where('id', $id)->first();
        return view('admin.employeeedit', ['employee' => $employee]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
