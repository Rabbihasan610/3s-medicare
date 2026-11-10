<?php

namespace App\Traits;

trait ApiResponse {

    public function success($message = "Data fetch success")
    {
        return response()->json([
            "status"  => true,
            "message" => $message,
        ], 200);
    }

    public function successResponse($data, $message = "Data fetch success")
    {
        return response()->json([
            "status"  => true,
            "message" => $message,
            "data"    => $data
        ], 200);
    }

    public function validationError($errors)
    {
        return response()->json([
            "status"    => false,
            "errors"    => $errors
        ], 422);
    }

    public function notFound($error)
    {
        return response()->json([
            "status"    => false,
            "error"   => $error
        ], 404);
    }

    public function serverError()
    {
        $error = __('Something went wrong');

        return response()->json([
            "status"    => false,
            "error"   => $error
        ], 500);
    }
}
