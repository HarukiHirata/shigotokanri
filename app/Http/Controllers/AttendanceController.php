<?php

namespace App\Http\Controllers;

use App\Attendance;
use Illuminate\Http\Request;
use Illuminate\Http\Facades\DB;
use Illuminate\Http\Facades\Hash;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attendances = Attendance::where('employee_id', session('employee_id'))->get();
        return view('attendance.index', ['attendances' => $attendances]);
    }

    public function companyindex()
    {
        $attendances = Attendance::where('company_id', session('company_id'))->get();
        return view('attendance.companyindex', ['attendances' => $attendances]);
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
        $date = $request->date;
        $time1 = new DateTime($request->start_time);
        $time2 = new DateTime($request->end_time);
        $working_hour = $time1->diff($time2);

        // データをインスタンスのプロパティに入れてDBへ保存した後、ホーム画面へ遷移
        $attendance->employee_id = session('employee_id');
        $attendance->date = $date;
        $attendance->month = date_format($date, 'Y-m');
        $attendance->start_time = $time1;
        $attendance->end_time = $time2;
        $attendance->working_hours = $working_hour->format('%h');
        $attendance->delete_flg = 0;
        $attendance->save();

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
