<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Imports\LenelImport;
use App\User;

use File;
use Excel;

class ScanEmployees extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scan:employees';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will be import the employee data from csv/lenelsync.csv';

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
        ini_set('max_execution_time', '0');
        $file_path = 'csv/lenelsync.csv';
        if(file_exists(public_path($file_path))) {
            Excel::import(new LenelImport(), public_path($file_path));
        }
    }
}
