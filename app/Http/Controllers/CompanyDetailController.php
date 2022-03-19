<?php

namespace App\Http\Controllers;

use App\Models\CompanyDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CompanyDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $data = CompanyDetail::find(1);
        return view('company',compact('data')); 
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
        $request->validate([
            'company_name' => 'required',
            'company_detail' => 'required',
        ]);
        $model = CompanyDetail::findOrfail(1);
        $model->company_detail = $request->post('company_detail');
        $model->company_name = $request->post('company_name');
        $model->email = $request->post('email');
        $model->phone = $request->post('phone');
        $model->depot = $request->post('depot');
        $model->depot_code = $request->post('depot_code');
        $model->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CompanyDetail  $companyDetail
     * @return \Illuminate\Http\Response
     */
    public function show(CompanyDetail $companyDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CompanyDetail  $companyDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(CompanyDetail $companyDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CompanyDetail  $companyDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CompanyDetail $companyDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CompanyDetail  $companyDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompanyDetail $companyDetail)
    {
        //
    }
}
