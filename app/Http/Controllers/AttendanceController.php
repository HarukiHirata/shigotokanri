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

    // 従業員用の勤怠一覧表示画面遷移処理
    public function index() {
        return view('attendance.index');
    }

    // 従業員用の勤怠検索処理
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

    // 管理者用の勤怠一覧表示画面遷移処理
    public function companyindex()
    {
        $employee = new EmployeeController;
        $employees = $employee->employeesbycompany();
        return view('attendance.companyindex', ['employees' => $employees]);
    }

    //  管理者用の勤怠検索処理
    public function searchforadmin(Request $request) {
        if (!empty($request->employee_id) && !empty($request->search_month)) {
            $attendances = Attendance::with('employee')->where('employee_id', $request->employee_id)->where('month', $request->search_month)->get();
        } elseif (!empty($request->employee_id) && empty($request->search_month)) {
            $attendances = Attendance::with('employee')->where('employee_id', $request->employee_id)->get();
        } elseif (empty($request->employee_id) && !empty($request->search_month)) {
            $attendances = Attendance::with('employee')->where('company_code', session('company_code'))->where('month', $request->search_month)->get();
        } else {
            $attendances = Attendance::with('employee')->where('company_code', session('company_code'))->get();
        }
        $nullmessage = '';
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
    // 勤怠登録画面遷移処理
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
    // 勤怠登録機能遷移処理
    public function store(AttendanceRequest $request)
    {
        if (checkdate($request->month, $request->day, $request->year)) {
            DB::transaction(function () use ($request) {
                $attendance = new Attendance;
                $date = $request->year.'-'.$request->month.'-'.$request->day;
                $month = $request->year.'-'.sprintf("%02d", $request->month);
                $start_time = Carbon::create($request->year, $request->month, $request->day, $request->start_time_h, $request->start_time_m, 00);
                $end_time = Carbon::create($request->year, $request->month, $request->day, $request->end_time_h, $request->end_time_m, 00);
                $working_hours = ($start_time->diffInMinutes($end_time) - $request->break_time) / 60;
    
                $attendance->employee_id = session('employee_id');
                $attendance->company_code = session('company_code');
                $attendance->date = $date;
                $attendance->month = $month;
                $attendance->start_time = $start_time->format('H:i');
                $attendance->end_time = $end_time->format('H:i');
                $attendance->working_hours = $working_hours;
                $attendance->break_time = $request->break_time;
                $attendance->delete_flg = 0;
                $attendance->save();
            });
    
            session()->flash('toastr', config('toastr.success'));
            return redirect()->route('/employee/home');
        } else {
            return back()->withInput()->with(['date_error' => '無効な日付です。']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    // 従業員用の勤怠編集画面遷移処理
    public function edit($id)
    {
        $attendance = Attendance::where('id', $id)->first();
        $date = explode("-", $attendance->date);
        $year = $date[0];
        $month = $date[1];
        $day = $date[2];
        $start_time = explode(":", $attendance->start_time);
        $start_time_h = $start_time[0];
        $start_time_m = $start_time[1];
        $end_time = explode(":", $attendance->end_time);
        $end_time_h = $end_time[0];
        $end_time_m = $end_time[1];
        return view('attendance.edit', [
            'attendance' => $attendance,
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'start_time_h' => $start_time_h,
            'start_time_m' => $start_time_m,
            'end_time_h' => $end_time_h,
            'end_time_m' => $end_time_m,
        ]);
    }

    // 管理者用の勤怠編集画面遷移処理
    public function editforadmin($id) {
        $attendance = Attendance::with('employee')->where('id', $id)->first();
        $date = explode("-", $attendance->date);
        $year = $date[0];
        $month = $date[1];
        $day = $date[2];
        $start_time = explode(":", $attendance->start_time);
        $start_time_h = $start_time[0];
        $start_time_m = $start_time[1];
        $end_time = explode(":", $attendance->end_time);
        $end_time_h = $end_time[0];
        $end_time_m = $end_time[1];
        return view('attendance.editforadmin', [
            'attendance' => $attendance,
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'start_time_h' => $start_time_h,
            'start_time_m' => $start_time_m,
            'end_time_h' => $end_time_h,
            'end_time_m' => $end_time_m,
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    // 勤怠更新処理（従業員・管理者用の画面で共通）
    public function update(AttendanceRequest $request, Attendance $attendance)
    {
        if (checkdate($request->month, $request->day, $request->year)) {
            DB::transaction(function () use ($request) {
                $attendance = Attendance::find($request->attendance_id);
                $date = $request->year.'-'.$request->month.'-'.$request->day;
                $month = $request->year.'-'.$request->month;
                $start_time = Carbon::create($request->year, $request->month, $request->day, $request->start_time_h, $request->start_time_m, 00);
                $end_time = Carbon::create($request->year, $request->month, $request->day, $request->end_time_h, $request->end_time_m, 00);
                $working_hours = ($start_time->diffInMinutes($end_time) - $request->break_time) / 60;
    
                $attendance->date = $date;
                $attendance->month = $month;
                $attendance->start_time = $start_time->format('H:i');
                $attendance->end_time = $end_time->format('H:i');
                $attendance->working_hours = $working_hours;
                $attendance->break_time = $request->break_time;
                $attendance->save();
            });
    
            if ($request->transition == 'admin') {
                session()->flash('toastr', config('toastr.success'));
                return redirect()->route('attendindexbycmp');
            } elseif ($request->transition == 'employee') {
                session()->flash('toastr', config('toastr.success'));
                return redirect()->route('attendindex');
            }
        } else {
            return back()->withInput()->with(['date_error' => '無効な日付です。']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    // 勤怠履歴削除処理（従業員・管理者用の画面で共通）
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

    // 勤怠履歴削除処理（従業員情報が削除された場合にその従業員の勤怠履歴を削除）
    public function destroybyemployeeid($employee_id) {
        DB::transaction(function () use ($employee_id) {
            Attendance::where('employee_id', $employee_id)->update(['delete_flg' => 1]);
        });
    }
}
