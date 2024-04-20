<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public static function success($data = null, $message = 'Success', $statusCode = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    } // end of success

    public static function error($message = 'Error', $statusCode = 400): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => null,
        ], $statusCode);
    } // end of error
    public static function price($total_price, $currency)
    {
        $returnValue = $total_price;
        if ($currency != "$" || $currency != 1) {
            $currentCurrency = Currency::where("cureency", $currency)->orWhere('id', $currency)->first();
            return $returnValue = number_format($total_price / $currentCurrency->dollar_price, 2);
        } else {
            return $returnValue;
        }
    }
}
