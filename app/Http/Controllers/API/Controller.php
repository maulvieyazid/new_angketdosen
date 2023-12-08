<?php

namespace App\Http\Controllers\API;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /*
    | Status Respon API
     */
    const STATUS_SUCCESS = 1;
    const STATUS_ERROR = 2;


    public function sendApiResponseSuccess($message)
    {
        return response()->json([
            'status'  => self::STATUS_SUCCESS,
            'message' => $message,
        ]);
    }

    public function sendApiResponseError($message)
    {
        return response()->json([
            'status'  => self::STATUS_ERROR,
            'message' => $message,
        ]);
    }
}
