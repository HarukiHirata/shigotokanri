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
    // 従業員ログイン処理
    public function emplogin(Request $request)
    {
        $employee = Employee::where('company_code', $request->company_code)->where('employee_code', $request->employee_code)->first();

        if (empty($employee)) {
            return back()->withInput()->with(['login_error' => '企業コードもしくは従業員コードが間違っています。']);
        } else {
            if (Hash::check($request->password, $employee->password)) {
                session(['employee_id' => $employee->id]);
                session(['name' => $employee->name]);
                session(['company_code' => $employee->company_code]);
                session(['employee_code' => $employee->employee_code]);
                session(['login_token' => str_random(6)]);

                session()->flash('toastr', config('toastr.loginsuccess'));
                return redirect()->route('/employee/home');
            } else {
                return back()->withInput()->with(['login_error' => 'パスワードが間違っています。']);
            }
        } 
    }

    // 従業員ログアウト処理
    public function emplogout()
    {
        session()->forget('employee_id');
        session()->forget('name');
        session()->forget('company_code');
        session()->forget('employee_code');
        session()->forget('login_token');
        session()->flash('toastr', config('toastr.logout'));
        return redirect()->route('top');
    }

    // 従業員一覧画面表示処理
    public function index()
    {
        $employees = $this->employeesbycompany();
        return view('admin.employeeindex', ['employees' => $employees]);
    }

    // 従業員一覧取得処理（管理者用の勤怠一覧画面で従業員のプルダウンの選択肢で使用）
    public function employeesbycompany() {
        $employees = Employee::where('company_code', session('company_code'))->get();
        return $employees;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // 従業員登録画面遷移処理
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
    // 従業員登録処理
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    // 従業員情報編集画面遷移処理
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
    // 従業員情報更新処理
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
    // 従業員情報削除処理
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
