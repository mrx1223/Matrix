<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\ProjectCost;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    function getCureency($currency): bool
    {
        $currentCurrency = Currency::where("currency", $currency)->orWhere('id', $currency)->first();
        return $currentCurrency;
    }
    function isHaveDefult(): bool
    {
        $isHave = 0;
        $currency = Currency::where("price", 1)->first();
        $currency && $isHave = 1;
        return $isHave;
    }
    function createCurrency(Request $request)
    {

        $request->validate([
            "currency" => "required|string|max:255",
            "price" => "required|numeric|min:1",

        ]);

        if (!$this->isHaveDefult() && $request->price != 1) {
            return Controller::error(message: "يجب ارسال العملة الاساسية اولأ بسعر 1");
        }

        $currency = Currency::create([
            "currency" => $request->currency,
            'price' => $request->price
        ]);
        return Controller::success(data: $currency);
    }
    function updateCurrency(Request $request, $id)
    {
        $currency = Currency::find($id);
        $currency->currency = $request->currency ?? $currency->currency;
        $currency->price = $request->price ?? $currency->price;
        $currency->updated_at = now();
        $currency->save();
        return Controller::success(data: $currency);
    }
    function deleteCurrency($id)
    {
        $currency = Currency::find($id);
        if ($currency && $currency->price != 1) {
            $currency->delete();
            return Controller::success();
        }
        return Controller::error(message: "لم تتم العملية بنجاح");
    }
    function getAllCurrency()
    {
        return Controller::success(data: Currency::get());
    }
    function getCurrencyWithPaginate()
    {
        return Controller::success(data: Currency::paginate($_GET["paginate"] ?? 10));
    }
    function chageMoney(Request $request)
    {
        $request->validate([
            "first_currency" => "required",
            "secound_currency" => "required",
            "money" => "required"
        ]);
        $firstCurrency = $this->getCureency($request->first_currency);
        $secoundCurrency = $this->getCureency($request->secound_currency);
        if ($firstCurrency || $secoundCurrency) {
            return Controller::error(message: "العملة غير موجودة في النظام");
        }
        return Controller::success(data: ($firstCurrency * $request->money / $secoundCurrency));
    }
    function getProjectCost($id)
    {
        $projectCost = ProjectCost::where("project_id", $id)->sum('cost');
        return Controller::success(data: $projectCost);
    }
    function getProjectCostWithCurrency(Request $request, $id)
    {
        $currentCurrency = Currency::where("cureency", $request->currency)->orWhere('id', $request->currency)->first();
        if (!$currentCurrency) {
            return Controller::error(message: "العملة غير موجودة في النظام");
        }
        $projectCost = ProjectCost::where("project_id", $id)->sum('cost');
        return Controller::success(data: $projectCost * $currentCurrency->price);
    }
}
