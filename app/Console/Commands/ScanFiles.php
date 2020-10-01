<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Imports\TemperaturesImport;
use App\Tfile;

use File;
use Excel;

class ScanFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scan:files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $entrance_directories = File::directories(public_path('csv'));
        foreach ($entrance_directories as $entrance) {
            $entrance_name = basename($entrance);
            $date_directories = File::directories(public_path('csv/'.$entrance_name.'/logs'));
            
            foreach ($date_directories as $directory) {
                $dir_path = $entrance_name.'/logs/'.basename($directory);
                $files = File::files(public_path('csv/'.$dir_path));
                foreach ($files as $file) {
                    $file_path = $dir_path."/".basename($file);
                    $extension = pathinfo(basename($file), PATHINFO_EXTENSION);
                    if(!Tfile::where('path', $file_path)->exists() && $extension == 'csv') {
                        Excel::import(new TemperaturesImport($file_path, $entrance_name), public_path('csv/'.$file_path));  
                    }
                }
            }
        }
    }
}
