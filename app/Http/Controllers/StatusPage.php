<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;
use App\Rules\Uppercase;
use Carbon\Carbon;
use Psy\Util\Json;


class StatusPage extends Controller
{


    function show_submision_status(Request $request, $submisionid){
         $submission_data_find_id = Submission::where('submision_id', '=', $submisionid)->first();
         if($submission_data_find_id !== null){
             $user_for_this_submision = $submission_data_find_id->user;
             if($user_for_this_submision !== null){
                 return view('joinstatus', ['status' => 'success', 'submision_data' => $submission_data_find_id->toArray(), 'user_data' => $user_for_this_submision->toArray()]);
             }else{
                 return view('joinstatus', ['status' => 'error']);
             }

         }else{
             return view('joinstatus', ['status' => 'error']);
         }


    }
}
