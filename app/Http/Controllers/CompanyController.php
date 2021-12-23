<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\AdminController;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function companylogin(Request $request) {
        $company = Company::where('company_code', $request->company_code)->first();

        if (empty($company)) {
            session()->flash('toastr', config('toastr.loginfail'));
            return redirect()->route('/company/login');
        } else {
            if (Hash::check($request->password, $company->password)) {
                session(['company_code' => $company->company_code]);
                session(['company_name' => $company->name]);
                session()->flash('toastr', config('toastr.loginsuccess'));
                return redirect()->route('/company/home');
            } else {
                session()->flash('toastr', config('toastr.loginfail'));
                return redirect()->route('/company/login');
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
    public function store(Request $request)
    {
        $this->validate($request, Company::$rules);

        $company = new Company;

        $company_code_check = Company::where('company_code', $request->company_code)->first();

        if (empty($company_code_check)) {
            $company->company_code = $request->company_code;
            $company->name = $request->name;
            $company->email = $request->email;
            $company->password = Hash::make($request->password);
            $company->save();
            session(['company_code' => $company->company_code]);
            session(['company_name' => $company->name]);
            session()->flash('toastr', config('toastr.success'));
            return redirect()->route('/company/home');
        } else {
            session()->flash('toastr', config('toastr.fail'));
            return view('company.register');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
    }
}
