<?php

namespace App\Http\Controllers;

use App\Models\SubmissionTeams;
use App\Rules\Uppercase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Submission;

class Accounts extends Controller
{
    function index(){
        return view('login');
    }

    function login(Request $request){
        $request->flash();
        $email_form = $request->input('email');
        $password_form = $request->input('password');
        $now = Carbon::now()->format("Y-m-d H:i:s");
        $remember = md5(sha1($email_form."/".Hash::make($password_form)."@".$now));

        $customMessages = [
            'required' => 'Το πεδίο αυτό είναι υποχρεωτικό και δεν πρέπει να είναι κενό',
            'email' => 'Μή έγκυρη διεύθυνση email',
            'alpha' => 'Επιτρέπονται μόνο η αλφαβητική χαρακτήρες',
            'max' => 'Η έκταση του κειμένου δεν πρέπει να ξεπερνάει τους :max χαρακτήρες'
        ];

        $validatedData = $request->validate([
            'email' => ['required','email:rfc,dns','max:30'],
            'password' => 'required|bail|string|max:20'
        ], $customMessages);

        if(Auth::attempt(['email' => $email_form, 'password' => $password_form], $remember)){
            return redirect()->intended('user/dashboard');
        }else{
            throw ValidationException::withMessages([
                'email' => 'Εσφαλμένο email σύνδεσης',
                'password' => 'Εσφαλμένος κωδικός σύνδεσης'
            ]);
        }

    }

    function dashboard_home(Request $request){

        $submissions_table = [];
        $submissions_team_table = [];
        $have_team_groups = 0;
        if($request->session()->has('pjstatus')){
            $cv = $request->session()->get('pjstatus');
        }else{
            $cv = null;
        }
        if(Auth::check()){
            //Auth::loginUsingId(18); //18 25 55

            if(User::find(Auth::id())->submision->toArray() !== []){
                 $submissions_table_arr = User::find(Auth::id())->submision->toArray();
                 foreach ($submissions_table_arr as $sta1){
                     array_push($submissions_table, $sta1);
                     if($sta1['join_type'] === 2){
                        if(Submission::find($sta1['id'])->team->toArray() !== null){
                            $submissions_team_table_arr = Submission::find($sta1['id'])->team->toArray();
                            foreach ($submissions_team_table_arr as $stta2){
                                $have_team_groups = 1;
                                array_push($submissions_team_table, $stta2);
                            }
                        }
                     }
                 }

                return view('dashboard', ['submisions_table' => $submissions_table, 'teammembers_table' => $submissions_team_table, 'haveteamgroups' => $have_team_groups, 'pjstatus' => $cv]);
            }else{
                $find_join_teams =SubmissionTeams::query()->where(['member_id' => Auth::id()])->get()->toArray();
                foreach ($find_join_teams as $fjt1){
                    $submissions_table_arr3 = Submission::find($fjt1['team_id'])->toArray();
                    array_push($submissions_table, $submissions_table_arr3);
                }
                return view('dashboard', ['submisions_table' => $submissions_table, 'teammembers_table' => '', 'haveteamgroups' => 0, 'pjstatus' => $cv]);
            }



        }else{
            return redirect('/login');
        }

    }

    function user_logout(){
        Auth::logout();
        return redirect('/login');
    }

    function project_space_form_submit(Request $request){
        $request->flash();
        $submissions_table = [];
        $submissions_team_table = [];
        $have_team_groups = 0;
        $teamname_form_edit = $request->input('info-project-team-edit-teamname');
        $projectname_form_edit = $request->input('info-project-team-edit-appname');
        $projectdesc_form_edit = $request->input('info-project-team-edit-appdesc');
        $projectspace_form_edit = $request->input('info-project-team-edit-projectspace');



        if(Auth::check()){
            //Auth::loginUsingId(55); //18 25 55

            if(User::find(Auth::id())->submision->toArray() !== []){
                $submissions_table_arr = User::find(Auth::id())->submision->toArray();
                foreach ($submissions_table_arr as $sta1){
                    array_push($submissions_table, $sta1);
                    if($sta1['join_type'] === 2){
                        if(Submission::find($sta1['id'])->team->toArray() !== null){
                            $submissions_team_table_arr = Submission::find($sta1['id'])->team->toArray();
                            foreach ($submissions_team_table_arr as $stta2){
                                $have_team_groups = 1;
                                array_push($submissions_team_table, $stta2);
                            }
                        }
                    }
                }


            }else{
                $find_join_teams =SubmissionTeams::query()->where(['member_id' => Auth::id()])->get()->toArray();
                foreach ($find_join_teams as $fjt1){
                    $submissions_table_arr3 = Submission::find($fjt1['team_id'])->toArray();
                    array_push($submissions_table, $submissions_table_arr3);
                }
            }

            $query_builder_update = [];

            if($submissions_table[0]['teamname'] != $teamname_form_edit){
                $query_builder_update['teamname'] = $teamname_form_edit;
            }

            if($submissions_table[0]['appname'] != $projectname_form_edit){
                $query_builder_update['appname'] = $projectname_form_edit;
            }

            if($submissions_table[0]['appdesc'] != $projectdesc_form_edit){
                $query_builder_update['appdesc'] = $projectdesc_form_edit;
            }

            if($submissions_table[0]['projectspace'] != $projectspace_form_edit){
                $query_builder_update['projectspace'] = $projectspace_form_edit;
            }

            //dd($query_builder_update);
            if($query_builder_update !== []){
                $subarreditform = User::find(Auth::id())->submision->toArray()[0]['submision_id'];

                $update_project_info = DB::table('comp_join')->where('submision_id', '=', $subarreditform)->update($query_builder_update);
                if($update_project_info === 1){
                    $request->session()->put('pjstatus', 1);
                    return redirect('/user/dashboard');
                }else{
                    $request->session()->put('pjstatus', 0);
                    return redirect('/user/dashboard');
                }
            }else{
                $request->session()->put('pjstatus', 1);
                return redirect('/user/dashboard');
            }



        }else{
            return redirect('/login');
        }

    }
}
