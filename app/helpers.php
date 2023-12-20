<?php

use Illuminate\Http\Response as Response;

if (!function_exists('responseJson')) {
    function responseJson($data, $token = null, $status = 200, $message = 'Success'): Response
    {
        $response = array_filter([
            'pagination' => isset($data['total_pages']) ? [
                'total_pages' => $data['total_pages'],
                'current_page' => $data['current_page'],
            ] : null,
            'data' => $data,
            'message' => $message,
            'statusCode' => $status,
            'access_token' => $token,
        ], fn($value) => !is_null($value));

        return response($response, $status);
    }
}
