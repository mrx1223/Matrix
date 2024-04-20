<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Project;
use App\Models\ProjectCost;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    function isSetCureency($currency): bool
    {
        $is_set = 0;
        $currentCurrency = Currency::where("cureency", $currency)->orWhere('id', $currency)->first();
        $currentCurrency && $is_set = 1;
        return $is_set;
    }
    function createProject(Request $request)
    {

        $request->validate([
            "name" => "required|string|max:255",
            "description" => "required|string|max:10000",
            "project_cost" => "required|array",
            "currency" => "required",
            "project_cost.*.cost" => "required|numeric|min:1",
            "project_cost.*.description" => "string|max:255",
        ]);
        if (!$this->isSetCureency($request->currency)) {
            return Controller::error(message: "العملة غير موجودة في النظام");
        }
        $Project = Project::create([
            "name" => $request->name,
            'description' => $request->description
        ]);
        foreach ($request->project_cost as $key => $value) {
            ProjectCost::create([
                "project_id" => $Project->id,
                "cost" => Controller::price(total_price: $value["cost"], currency: $request->currency),
                "description" => $value["description"] ?? null
            ]);
        }
        return Controller::success(data: $Project);
    }
    function updateProject(Request $request, $id)
    {
        $Project = Project::find($id);
        if (!$Project) {
            return Controller::error(message: "not found");
        }
        $Project->name = $request->Project ?? $Project->name;
        $Project->price = $request->price ?? $Project->price;
        $Project->updated_at = now();
        $Project->save();
        return Controller::success(data: $Project);
    }
    function deleteProject($id)
    {
        $Project = Project::find($id);
        if (!$Project) {
            return Controller::error(message: "not found");
        }
        foreach ($Project->projectCost as $key => $value) {
            $value->delete();
        }
        $Project->delete();
        return Controller::success();
    }
    function getAllProject()
    {
        return Controller::success(data: Project::with("projectCost")->get());
    }
    function getProjectWithPaginate()
    {
        return Controller::success(data: Project::with("projectCost")->paginate($_GET["paginate"] ?? 10));
    }
}
