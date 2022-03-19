<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        if (admin_varify(Auth::user()->type)) {
            return view('create-user');
        }else{
            return redirect('/dashboard');
        }
        
    }
    // public function logout(){
    //     Session::forget('removeTeamMember');
        
    // }
    public function store(Request $req){
        return 'done';
    }
}
