<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class Callnewcontroller extends Controller
{
    public function incomingClientAdd()
    {
        $users = [
            ['userid' => 1, 'name' => 'Alex'],
            ['userid' => 2, 'name' => 'Jane'],
        ];

      
        return response(["status"=>200,"stat"=>"stat","msg"=>"API Executed Successfully","data"=>$users], 200);
    }
    public function redirectingeg(Request $request)
    {
        //validation
        $validator  = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'required|image',
        ]);

        if ($validator->fails()) {
            print_r($validator->errors());
        } else{
            //if everthing is ok
           
            $file = $request->file('image');
            $path=$request->all();
            Storage::put('file', $file);
            echo response(["msg"=>"API ececuted succesfully","data"=>$path],200);
            
        }

    
    }


    public function FileGetting()
    {
        // Path to the directory containing images within storage
        $directoryPath = 'file';
    
        // Get the list of files in the directory
        $files = Storage::files($directoryPath);
    
        // Check if there are any files
        if (!empty($files)) {
            $imageDataArray = [];
    
            // Loop through each file
            foreach ($files as $file) {
                // Read the image file content and encode it as base64
                $imageData = base64_encode(Storage::get($file));
    
                // Get the filename without the directory path
                $filename = pathinfo($file, PATHINFO_BASENAME);
    
                // Add image data to the array
                $imageDataArray[] = [
                    'filename' => $filename,
                 
                ];
            }
    
            // Create a data array with the array of image data
            $responseData = [
                "status" => 200,
                "stat" => "stat",
                "msg" => "API Executed Successfully",
                "data" => $imageData,
            ];
    
            // Return the response with the array of image data
            return response($responseData, 200);
        } else {
            // If no files are found, return an error response
            return response(["status" => 404, "msg" => "No images found"], 404);
        }
    }
}
    