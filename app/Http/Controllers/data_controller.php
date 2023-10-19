<?php

namespace App\Http\Controllers;

use App\Models\city_model;
use App\Models\country_model;
use App\Models\info_model;
use App\Models\state_model;
use Illuminate\Http\Request;

class data_controller extends Controller
{
    function country_data_fun()
    {
        $data = country_model::all();
        return response()->json(['data' => "$data"]);
    }
    function country_id_fun($id)
    {
        $state_data = state_model::where('country_id', $id)->get();
        return response()->json(['states' => $state_data]);
    }
    function state_id_fun($id)
    {
        $city_data = city_model::where('state_id', $id)->get();
        return response()->json(['cities' => $city_data]);
    }
    function form_data_fun(Request $request)
    {
            if ($request->add_data == "add_data") {
                $data = new info_model;
                $data->fullname = $request->fullname;
                $data->email = $request->email;
                $data->password = $request->password;
                $data->country = $request->country;
                $data->state = $request->state;
                $data->city = $request->city;
                $data->country_name = $request->country_name;
                $data->state_name = $request->state_name;
                $data->city_name = $request->city_name;

                if ($data->save()) {

                    return response()->json(['msg' => "Data Added"]);
                } else {
                    return response()->json(['msg' => "NOT Added"]);
                }
            } else if ($request->add_data == "update_form") {

                $data = info_model::find($request->user_id);
                $data->fullname = $request->fullname;
                $data->email = $request->email;
                $data->password = $request->password;
                $data->country = $request->country;
                $data->state = $request->state;
                $data->city = $request->city;
                $data->country_name = $request->country_name;
                $data->state_name = $request->state_name;
                $data->city_name = $request->city_name;

                if ($data->update()) {

                    return response()->json(['msg' => "Data Updated"]);
                } else {
                    return response()->json(['msg' => "NOT Updated"]);
                }
            }
    }
    function show_data_fun()
    {
        $data = info_model::orderBy('id', 'desc')->get();
        return response()->json(['data' => $data]);
    }
    function delete_fun($id)
    {
        $data = info_model::find($id);
        $data->delete();
        return response()->json(['msg' => "Data Deleted"]);
    }
    function update_fun($id)
    {

        $data = info_model::find($id);
        return response()->json($data);
    }
}
