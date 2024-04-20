<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Project;
use App\Models\ProjectCost;
use Illuminate\Http\Request;

class ProjectCostController extends Controller
{
    function isSetCureency($currency): bool
    {
        $is_set = 0;
        $currentCurrency = Currency::where("cureency", $currency)->orWhere('id', $currency)->first();
        $currentCurrency && $is_set = 1;
        return $is_set;
    }
    function addCostToCurrentProject(Request $request, $id)
    {
        $request->validate([
            "currency" => "required",
            "cost" => "required|numeric|min:1",
            "description" => "string|max:255",
        ]);
        $project = Project::find($id);
        if (!$project) {
            return Controller::error(message: "not found");
        }
        if (!$this->isSetCureency($request->currency)) {
            return Controller::error(message: "العملة غير موجودة في النظام");
        }
        $projectCost =  ProjectCost::create([
            "project_id" => $project->id,
            "cost" => Controller::price(total_price: $request->cost, currency: $request->currency),
            "description" => $value["description"] ?? null
        ]);
        return Controller::success(data: $projectCost);
    }
    function deleteProjectCost($id)
    {
        $projectCost = ProjectCost::find($id);
        if ($projectCost) {
            $projectCost->delete();
            return Controller::success();
        }
        return Controller::error(message: "not found");
    }
}
