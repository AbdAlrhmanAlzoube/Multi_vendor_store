<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{

  // public function __construct()
  // {
  //     $this->middleware(['auth']);
  // }
    public function index()
    {

      // $user=Auth::user();
      // dd($user);
        return view('dashboard.index');
      //  return View::make()
      //return response()->view();
      //return Respons::view();
    }

}
