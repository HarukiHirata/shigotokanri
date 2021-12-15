<?php

namespace App\Http\Controllers;

use App\Attendance;
use Illuminate\Http\Request;
use Illuminate\Http\Facades\DB;
use Illuminate\Http\Facades\Hash;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('attendance.index');
    }

    public function search(Request $request) {
        $attendances = Attendance::where('employee_id', session('employee_id'))->where('month', $request->search_month)->get();
        return view('attendance.index', ['attendances' => $attendances]);
    }

    public function companyindex()
    {
        return view('attendance.companyindex');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('attendance.create');  
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
        $this->validate($request, Attendance::$rules);
        
        // インスタンス生成した後、フォームで入力された日付けと始業時間、終業時間を変数に代入して勤務時間を計算して変数に代入
        $attendance = new Attendance;
        $date = new Carbon($request->date);
        $time1 = new Carbon($request->start_time);
        $time2 = new Carbon($request->end_time);
        $working_hours = $time1->diffInHours($time2) - ($request->break_time / 60);

        // created_at,updated_atのカラムがないためタイムスタンプを無効化
        $attendance->timestamps = false;

        // データをインスタンスのプロパティに入れてDBへ保存。
        $attendance->employee_id = session('employee_id');
        $attendance->company_code = session('company_code');
        $attendance->date = $date;
        $attendance->month = $date->format('Y-m');
        $attendance->start_time = $time1;
        $attendance->end_time = $time2;
        $attendance->working_hours = $working_hours;
        $attendance->break_time = $request->break_time;
        $attendance->delete_flg = 0;
        $attendance->save();

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
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
