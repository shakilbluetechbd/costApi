<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;


class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'result'    => $result,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages ="Operation Failed", $code = 404)
    {
        $response = [
            'success' => false,
            'error' => $error,
        ];


        if (!empty($errorMessages)) {
            $response['message'] = $errorMessages;
        }


        return response()->json($response, $code);
    }
}
