<?php

use Illuminate\Http\Response as Response;

if (!function_exists('responseJson')) {
    function responseJson($data, $token = null, $status = 200, $message = 'Success'): Response
    {
        $response = array_filter([
            'message' => $message,
            'data' => $data,
            'statusCode' => $status,
            'access_token' => $token,
        ], fn($value) => !is_null($value));

        return response($response, $status);
    }
}
