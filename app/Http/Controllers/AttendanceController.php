<?php

namespace App\Http\Controllers;

use App\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Http\Requests\AttendanceRequest;
use App\Http\Controllers\EmployeeController;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // 従業員用の勤怠一覧
    public function index() {
        return view('attendance.index');
    }

    // 従業員用の勤怠検索メソッド
    public function search(Request $request) {
        if (!empty($request->search_month)) {
            $attendances = Attendance::where('employee_id', session('employee_id'))->where('month', $request->search_month)->get();
        } else {
            $attendances = Attendance::where('employee_id', session('employee_id'))->get();
        }
        $nullmessage = '';
        if (count($attendances) == 0) {
            $nullmessage = '検索結果がありませんでした。';
        }
        return view('attendance.index', ['attendances' => $attendances, 'nullmessage' => $nullmessage]);
    }

    // 管理者用の勤怠一覧
    public function companyindex()
    {
        $employee = new EmployeeController;
        $employees = $employee->employeesbycompany();
        return view('attendance.companyindex', ['employees' => $employees]);
    }

    //  管理者用の勤怠検索メソッド
    public function searchforadmin(Request $request) {
        $nullmessage = '';
        if (!empty($request->employee_id)) {
            $attendances = Attendance::with('employee')->where('employee_id', $request->employee_id)->where('month', $request->search_month)->get();
        } else {
            $attendances = Attendance::with('employee')->where('company_code', session('company_code'))->where('month', $request->search_month)->get();
        }
        if (count($attendances) == 0) {
            $nullmessage = '検索結果がありませんでした。';
        }
        $employee = new EmployeeController;
        $employees = $employee->employeesbycompany();
        return view('attendance.companyindex', ['attendances' => $attendances, 'nullmessage' => $nullmessage, 'employees' => $employees]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // 勤怠登録画面
    public function create()
    {
        $today = Carbon::today('Asia/Tokyo');
        $year = $today->format('Y');
        $month = $today->format('m');
        $day = $today->format('d');
        return view('attendance.create', ['year' => $year, 'month' => $month, 'day' => $day]);  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // 勤怠登録機能
    public function store(AttendanceRequest $request)
    {   
        DB::transaction(function () use ($request) {
            // インスタンス生成した後、フォームで入力された日付けと始業時間、終業時間を変数に代入して勤務時間を計算して変数に代入
            $attendance = new Attendance;
            $date = Carbon::createFromDate($request->year, $request->month, $request->day);
            $start_time = Carbon::create($request->year, $request->month, $request->day, $request->start_time_h, $request->start_time_m, 00);
            $end_time = Carbon::create($request->year, $request->month, $request->day, $request->end_time_h, $request->end_time_m, 00);
            $working_hours = ($start_time->diffInMinutes($end_time) - $request->break_time) / 60;

            dd($date);

            // データをインスタンスのプロパティに入れてDBへ保存。
            $attendance->employee_id = session('employee_id');
            $attendance->company_code = session('company_code');
            $attendance->date = $date>format('Y-m-d');
            $attendance->month = $date->format('Y-m');
            $attendance->start_time = $start_time->format('H:m');
            $attendance->end_time = $end_time->format('H:m');
            $attendance->working_hours = $working_hours;
            $attendance->break_time = $request->break_time;
            $attendance->delete_flg = 0;
            $attendance->save();
        });

        // 登録成功のメッセージをセッションに保存してホーム画面へ遷移
        session()->flash('toastr', config('toastr.success'));
        return redirect()->route('/employee/home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    // 従業員用の勤怠編集画面
    public function edit($id)
    {
        $attendance = Attendance::where('id', $id)->first();
        return view('attendance.edit', ['attendance' => $attendance]);
    }

    // 管理者用の勤怠編集画面
    public function editforadmin($id) {
        $attendance = Attendance::with('employee')->where('id', $id)->first();
        return view('attendance.editforadmin', ['attendance' => $attendance]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    // 勤怠更新機能（従業員・管理者用の画面で共通）
    public function update(Request $request, Attendance $attendance)
    {
        // バリデーション
        $this->validate($request, Attendance::$rules);

        DB::transaction(function () use ($request) {
            // インスタンス生成した後、フォームで入力された日付けと始業時間、終業時間を変数に代入して勤務時間を計算して変数に代入
            $attendance = Attendance::find($request->attendance_id);
            $date = new Carbon($request->date);
            $time1 = new Carbon($request->start_time);
            $time2 = new Carbon($request->end_time);
            $working_hours = ($time1->diffInMinutes($time2) - $request->break_time) / 60;

            // データをインスタンスのプロパティに入れてDBへ保存。
            $attendance->date = $date;
            $attendance->month = $date->format('Y-m');
            $attendance->start_time = $time1;
            $attendance->end_time = $time2;
            $attendance->working_hours = $working_hours;
            $attendance->break_time = $request->break_time;
            $attendance->delete_flg = 0;
            $attendance->save();
        });

        // 登録成功のメッセージをセッションに保存してホーム画面へ遷移
        if ($request->transition == 'admin') {
            session()->flash('toastr', config('toastr.success'));
            return redirect()->route('attendindexbycmp');
        } elseif ($request->transition == 'employee') {
            session()->flash('toastr', config('toastr.success'));
            return redirect()->route('attendindex');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    // 勤怠履歴削除機能（従業員・管理者用の画面で共通）
    public function destroy(Request $request)
    {
        DB::transaction(function () use ($request) {
            $attendance = Attendance::find($request->attendance_id);
            $attendance->delete_flg = 1;
            $attendance->save();
        });

        if ($request->transition == 'admin') {
            session()->flash('toastr', config('toastr.delete_success'));
            return redirect()->route('attendindexbycmp');
        } elseif ($request->transition == 'employee') {
            session()->flash('toastr', config('toastr.delete_success'));
            return redirect()->route('attendindex');
        }
    }

    public function destroybyemployeeid($employee_id) {
        DB::transaction(function () use ($employee_id) {
            Attendance::where('employee_id', $employee_id)->update(['delete_flg' => 1]);
        });
    }
}
