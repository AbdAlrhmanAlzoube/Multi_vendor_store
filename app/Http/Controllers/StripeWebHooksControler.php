<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StripeWebHooksControler extends Controller
{
    public function handle(Request $request)
    {
        Log::debug("webhook event recevied",$request->all());
    } 
}
