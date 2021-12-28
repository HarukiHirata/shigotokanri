<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\EmployeeRequest;
use App\Http\Controllers\AttendanceController;

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
        $employee = Employee::where('company_code', $request->company_code)->where('employee_code', $request->employee_code)->first();

        if (empty($employee)) {
            // 入力された企業コードの中で一致する従業員コードがなかったり、入力された企業コードが存在しなかったりする場合、メッセージをセッションに格納してログイン画面にリダイアル。
            session()->flash('toastr', config('toastr.loginfail'));
            return back()->withInput()->with(['login_error' => '企業コードもしくは従業員コードが間違っています。']);
        } else {
            // 入力された企業コードの中で一致する従業員コードがあった場合パスワードチェック
            if (Hash::check($request->password, $employee->password)) {
                // パスワード一致
                // セッションにログインユーザーの情報・メッセージを格納
                session(['employee_id' => $employee->id]);
                session(['name' => $employee->name]);
                session(['company_code' => $employee->company_code]);
                session(['employee_code' => $employee->employee_code]);

                session()->flash('toastr', config('toastr.loginsuccess'));
                return redirect()->route('/employee/home');
            } else {
                // パスワード不一致の場合はメッセージをセッションに格納してログイン画面にリダイアル。
                session()->flash('toastr', config('toastr.loginfail'));
                return back()->withInput()->with(['login_error' => 'パスワードが間違っています。']);
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
    public function store(EmployeeRequest $request)
    {
        DB::transaction(function () use ($request) {
            $employee = new Employee;
            $employee->name = $request->name;
            $employee->employee_code = $request->employee_code;
            $employee->company_code = session('company_code');
            $employee->email = $request->email;
            $employee->password = Hash::make($request->password);
            $employee->delete_flg = 0;
            $employee->save();
        });

        session()->flash('toastr', config('toastr.success'));
        return redirect()->route('employeeindex');
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
    public function update(EmployeeRequest $request, Employee $employee)
    {        
        DB::transaction(function () use ($request) {
            $employee = Employee::find($request->employee_id);
            $employee->name = $request->name;
            $employee->employee_code = $request->employee_code;
            $employee->email = $request->email;
            $employee->save();
        });

        session()->flash('toastr', config('toastr.success'));
        return redirect()->route('employeeindex');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::transaction(function () use ($request) {
            $employee = Employee::find($request->employee_id);
            $employee->delete_flg = 1;
            $employee->save();
        });

        $attendances = new AttendanceController;
        $attendances->destroybyemployeeid($request->employee_id);

        session()->flash('toastr', config('toastr.delete_success'));
        return redirect()->route('employeeindex');
    }
}
