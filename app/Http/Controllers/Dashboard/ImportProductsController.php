<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Jobs\ImportProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ImportProductsController extends Controller
{
    
    public function create()
    {
        return view('dashboard.products.import');
    }

    public function store(Request $request)
    {
        $job = new ImportProducts($request->post('count')); //object
        // $job->onQueue('import')->onConnection('database');
        $job->onQueue('import')->delay(now()->addSeconds(5));
        ImportProducts::dispatch($job);

        return redirect()
            ->route('dashboard.products.index')
            ->with('success', 'Import is runing...');
    }
}
