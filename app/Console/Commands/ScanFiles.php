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
        $all_directories = File::directories(public_path('csv'));
        foreach ($all_directories as $directory) {
            $dir_name = basename($directory);
            $files = File::files(public_path('csv'."/".$dir_name));
            foreach ($files as $file) {
                $file_path = $dir_name."/".basename($file);
                if(!Tfile::where('path', $file_path)->exists()) {
                    Excel::import(new TemperaturesImport($file_path), public_path('csv/'.$file_path));  
                }
            }
        }
    }
}
