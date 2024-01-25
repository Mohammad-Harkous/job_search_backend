<?php

namespace App\Traits;

trait HttpResponses {
 
    protected function success($data, $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $data['message'], // Retrieve the message from the data array in this way the message will be retrieved from the message we provide in the response
            'data' => $data 
        ], $code);
    }

    protected function error($data, $message = null, $code) {
        return response()->json([
            'status' => 'Error has occurred...',
            'message' => $message,
            'data' => $data
        ], $code);
    }
    
}