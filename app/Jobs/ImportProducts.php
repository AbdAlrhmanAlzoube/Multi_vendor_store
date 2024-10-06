<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportProducts implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected $count)
    {
        
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Product::factory($this->count)->create();
        } catch (\Exception $e) {
            
        }
        
        // Send notifcation to user that import is done!
    }
}
