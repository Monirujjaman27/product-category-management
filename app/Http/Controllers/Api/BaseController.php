<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\File;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($message, $data = [])
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];
        !empty($data) ? $response['data'] = $data : NULL;
        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
            'code' =>  $code,
        ];
        if (!empty($errorMessages)) $response['errors'] = $errorMessages;
        return response()->json($response);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     * @param  $file_path_name
     * 👉 delete file from the param 
     */
    function unlink_image($file_path_name)
    {
        if (isset($file_path_name) && $file_path_name != "" && file_exists($file_path_name)) unlink($file_path_name);
    }

    /**
     * return file path and file name.
     *
     * @return \Illuminate\Http\Response
     * 👉  Uploads file ou update file 
     * return file name with path
     */
    function fileUpload($new_file, $path, $old_file_name = NULL)
    {
        $path = "uploads/$path/";
        if (!file_exists(public_path($path))) {
            mkdir(public_path($path), 0777, TRUE);
        }
        if (isset($old_file_name) && $old_file_name != "" && file_exists($old_file_name)) {
            unlink($old_file_name);
        }
        $file_name = $new_file->getClientOriginalName();
        if (file_exists(public_path($path . $file_name))) {
            if (!File::exists($path . $file_name)) File::makeDirectory($path, 0777, true, true);
            $file_name  = rand(00, 99) . $file_name;
        } else {
            $file_name  = $file_name;
        }
        $new_file->move($path, $file_name);
        return $path . $file_name;
    }
}
