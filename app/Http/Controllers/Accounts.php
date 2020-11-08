<?php

namespace App\Http\Controllers;

use App\Models\SubmissionTeams;
use App\Rules\Uppercase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    function dashboard_home(){
        $submissions_table = [];
        $submissions_team_table = [];
        $have_team_groups = 0;

        if(Auth::check()){
            //Auth::loginUsingId(26); //18 25

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

                return view('dashboard', ['submisions_table' => $submissions_table, 'teammembers_table' => $submissions_team_table, 'haveteamgroups' => $have_team_groups]);
            }else{
                $find_join_teams =SubmissionTeams::query()->where(['member_id' => Auth::id()])->get()->toArray();
                foreach ($find_join_teams as $fjt1){
                    $submissions_table_arr3 = Submission::find($fjt1['team_id'])->toArray();
                    array_push($submissions_table, $submissions_table_arr3);
                }
                return view('dashboard', ['submisions_table' => $submissions_table, 'teammembers_table' => '', 'haveteamgroups' => 0]);
            }



        }else{
            return redirect('/login');
        }

    }

    function user_logout(){
        Auth::logout();
        return redirect('/login');
    }
}
