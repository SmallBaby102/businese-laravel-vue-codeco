<?php

namespace App\Http\Controllers;

use App\Models\StatusMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class StatusMasterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('status-master'); 
    }

}
