<?php

namespace Webkul\Ecom\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Webkul\Ecom\Models\EcomImport;

class RunImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var EcomImport
     */
    protected $import;

    /**
     * Create a new job instance.
     *
     * @param EcomImport $import
     */
    public function __construct(EcomImport $import)
    {
        $this->import = $import;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->import->import_lastrun_status_id = 3;
        $this->import->save();
        self::serverImitation(30);
        $this->import->import_lastrun_status_id = 4;
        $this->import->save();


//        dd('run', $this->import);
    }

    public static function serverImitation($s){
        $time = time();
        $exit = false;
        while (!$exit){
            if ($time + $s <= time()){
                $exit = true;
                break;
            }
        }
    }
}
