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
         $submission_data_find_id = Submission::find(1);
         dd($submission_data_find_id->user);
    }
}
