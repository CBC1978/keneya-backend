<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSettingRequest;
use App\Http\Requests\EditSettingRequest;
use App\Models\settings;
use Illuminate\Http\Request;


class SettingController extends Controller
{
    public function index(Request $request){


        try {
            $query = settings::query();
            $perPage = 10;
            $page = $request->input('page',1);
            $search = $request->input('search');

            if ($search){
                $query->whereRaw("name LIKE '%".$search."%'");
            }
            $total = $query->count();

            $result = $query->offset(($page-1)*$perPage)->limit($perPage)->get();
            return response()->json([
                "status_code"=>200,
                "status_message"=>" Tous les paramètres sont récupérés",
                "current_page"=>$page,
                "last_page"=>ceil($total/$perPage),
                "items"=>$result,
            ]);
        }catch (\Exception $e){
            return response()->json($e);
        }
    }

    public function store(CreateSettingRequest $request){
        try {
            $setting = new settings();
            $setting->name = $request->name;
            $setting->amount = $request->amount;
            $setting->description = $request->description;

            $setting->save();

            return response()->json([
                "status_code"=>200,
                "status_message"=>" Le paramètre est créé",
                "data"=>$setting
            ]);
        }catch (\Exception $e){
            return response()->json($e);
        }
    }

    public function update(EditSettingRequest $request, settings $setting)
    {
        try {
            $setting->name = $request->name;
            $setting->amount = $request->amount;
            $setting->description = $request->description;

            $setting->save();
        }catch (\Exception $e){
            return response()->json($e);
        }
    }

    public function delete(settings $setting)
    {
        try {
            $setting->delete();
            return response()->json([
                "status_code"=>200,
                "status_message"=>" Le paramètre est supprimé",
                "data"=>$setting
            ]);
        }catch (\Exception $e){
            return response()->json($e);
        }
    }
}
