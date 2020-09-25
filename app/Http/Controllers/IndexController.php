<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Imports\TemperaturesImport;
use App\Tfile;

use File;
use Excel;

class IndexController extends Controller
{
    
    pu
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    public function check_files(Request $request) {
        $this->scanFiles();
        // $this->import();
    }

    public function import() 
    {
        Excel::import(new TemperaturesImport('asdfasf'), public_path('csv/2020-09-01/combined.csv'));        
    }

    public function scanFiles(){
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
