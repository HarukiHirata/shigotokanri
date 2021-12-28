<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\AdminController;
use App\Http\Requests\CompanyRequest;

class CompanyController extends Controller
{
    public function companylogin(Request $request) {
        $company = Company::where('company_code', $request->company_code)->first();

        if (empty($company)) {
            session()->flash('toastr', config('toastr.loginfail'));
            return back()->withInput()->with(['login_error' => '企業コードが間違っています。']);
        } else {
            if (Hash::check($request->password, $company->password)) {
                session(['company_code' => $company->company_code]);
                session(['company_name' => $company->name]);
                session()->flash('toastr', config('toastr.loginsuccess'));
                return redirect()->route('/company/home');
            } else {
                session()->flash('toastr', config('toastr.loginfail'));
                return back()->withInput()->with(['login_error' => 'パスワードが間違っています。']);
            }
        }
    }

    public function companylogout() {
        session()->forget('company_code');
        session()->forget('company_name');
        if (!empty(session('admins'))) {
            session()->forget('admins');
        }
        session()->flash('toastr', config('toastr.logout'));
        return redirect()->route('top');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        DB::transaction(function () use ($request) {
            $company = new Company;
            $company->company_code = $request->company_code;
            $company->name = $request->name;
            $company->email = $request->email;
            $company->password = Hash::make($request->password);
            $company->save();
        });
        session(['company_code' => $request->company_code]);
        session(['company_name' => $request->name]);
        session()->flash('toastr', config('toastr.success'));
        return redirect()->route('/company/home');
    }
}
