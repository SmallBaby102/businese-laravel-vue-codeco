<?php

namespace App\Http\Controllers;

use App\Models\LineMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LineMasterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('line-master'); 
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LineMaster  $lineMaster
     * @return \Illuminate\Http\Response
     */
    public function show(LineMaster $lineMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LineMaster  $lineMaster
     * @return \Illuminate\Http\Response
     */
    public function edit(LineMaster $lineMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LineMaster  $lineMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LineMaster $lineMaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LineMaster  $lineMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(LineMaster $lineMaster)
    {
        //
    }
}
