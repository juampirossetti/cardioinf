<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

use Carbon\Carbon;

class DeleteOldReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DeleteOldReservations:deletereservations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete reservations that have more than 3 minutes old';

    protected $timeOld = 10;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   
        // $date = new DateTime;
        // $date->modify('-5 minutes');
        // $formatted_date = $date->format('Y-m-d H:i:s');
        
        $formatted_date = Carbon::now()->subMinutes($this->timeOld)->toDateTimeString();
        
        DB::table('temp_reservations')->where('created_at','<',$formatted_date)->delete();


    }
}
