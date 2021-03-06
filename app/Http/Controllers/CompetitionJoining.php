<?php

namespace App\Http\Controllers;

use App\Models\SubmissionTeams;
use App\Rules\Uppercase;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Psy\Util\Json;
use App\Models\User;
use App\Models\Submission;


class CompetitionJoining extends Controller
{
    function join_person(Request $request){
        if($request->session()->has('connector_status_api')){
            $csapi_get_value = $request->session()->get('connector_status_api');
            $request->session()->forget('api_action_type', 'join_person_info_filler_callback');
            $request->session()->forget('connector_status_api');
            if($request->session()->has('join-person-personal-form-FILLDATA')){
                $personal_data_filler_arr = $request->session()->get('join-person-personal-form-FILLDATA');
                return view('join-person', ['csapi' => $csapi_get_value, 'personal_data_filler_arr' => $personal_data_filler_arr]);
            }else{
                return view('join-person', ['csapi' => $csapi_get_value]);
            }

        }else{
            if($request->session()->has('join-person-personal-form-FILLDATA')){
                $personal_data_filler_arr = $request->session()->get('join-person-personal-form-FILLDATA');
                return view('join-person', ['csapi' => '', 'personal_data_filler_arr' => $personal_data_filler_arr]);
            }else{
                return view('join-person', ['csapi' => '']);
            }
        }

    }

    function join_person_submit(Request $request){


        $request->flash();
        $fn_form = $request->input('join-person-user-firstname');
        $ln_form = $request->input('join-person-user-lastname');
        $kas_form = $request->input('join-person-user-uid');
        $email_form = $request->input('join-person-user-email');
        $password_form = Hash::make($request->input('join-person-user-password'));
        $teamappname_form = $request->input('join-person-teamapp-name');
        $appname_form = $request->input('join-person-app-name');
        $apptags_form = json_encode($request->input('join-person-app-tags'));
        $appdesc_form = $request->input('join-person-app-desc');
        $submission_hash_id = sha1(md5(($teamappname_form."/".$appname_form."@".$kas_form)));

        if($request->session()->has('join-person-personal-form-FILLDATA')) {
            $array_session_personal = $request->session()->get('join-person-personal-form-FILLDATA');
            $newdat_personal = [];
            $newdat_personal['firstname'] = $fn_form;
            $newdat_personal['lastname'] = $ln_form;
            $newdat_personal['email'] = $email_form;
            $newdat_personal['uid'] = $kas_form;
            $request->session()->forget('join-person-personal-form-FILLDATA');
            $request->session()->put('join-person-personal-form-FILLDATA', $newdat_personal);
        }


        $customMessages = [
            'required' => 'Το πεδίο αυτό είναι υποχρεωτικό και δεν πρέπει να είναι κενό',
            'join-person-user-uid.starts_with' => 'Ο αριθμός μητρώου θα πρέπει υποχρεωτικά να ξεκινάει με κάποιο απο τα παρακάτω: iee, it, el',
            'join-person-user-uid.max' => 'Ο αριμός μητρώου δεν πρέπει να ξεπερνάει τους 10 αλφαριθμητικούς χαρακτήρες',
            'email' => 'Μή έγκυρη διεύθυνση email',
            'alpha' => 'Επιτρέπονται μόνο η αλφαβητική χαρακτήρες',
            'max' => 'Η έκταση του κειμένου δεν πρέπει να ξεπερνάει τους :max χαρακτήρες',
            'join-person-app-tags.array' => 'Πρέπει να επιλέξετε τουλάχιστον 1 ετικέτα εφαρμογής',
            'join-person-app-tags.required' => 'Πρέπει να επιλέξετε τουλάχιστον 1 ετικέτα εφαρμογής',
            'join-person-app-desc.max' => 'Η περιγραφή της εφαρμογής δεν πρέπει να ξεπερνάει τους 800 χαρακτήρες',
            'join-person-user-uid.unique' => 'Ο συγκεκριμένος Αριθμός Μητρώου ανήκει ήδη σε κάποιον χρήστη',
            'join-person-user-email.unique' => 'Το συγκεκριμένο email ανήκει ήδη σε κάποιον χρήστη',
            'join-person-teamapp-name.unique' => 'Το όνομα της ομάδας χρησιμοποιείται ήδη',
            'join-person-app-name.unique' => 'Το όνομα της εφαρμογής χρησιμοποιείται ήδη'
        ];

        $validatedData = $request->validate([
            'join-person-user-firstname' => ['required', 'alpha', 'bail', 'string', 'max:10', new Uppercase],
            'join-person-user-lastname' => ['required', 'alpha', 'bail', 'string', 'max:22', new Uppercase],
            'join-person-user-uid' => 'required|bail|starts_with:iee,it,el|string|max:10|unique:App\Models\User,kas',
            'join-person-user-email' => ['required','email:rfc,dns','max:30','unique:App\Models\User,email'],
            'join-person-user-password' => 'required|bail|string|max:20',
            'join-person-teamapp-name' => 'required|bail|string|max:60|unique:App\Models\Submission,teamname',
            'join-person-app-name' => 'required|bail|string|max:60|unique:App\Models\Submission,appname',
            'join-person-app-tags' => 'required|array|bail',
            'join-person-app-desc' => 'required|bail|string|max:800'
        ], $customMessages);







        $newuser_model = User::firstOrNew(
            [
                'email' => $email_form,
                'kas' => $kas_form
            ],
            [
            'firstname' => $fn_form,
            'lastname' => $ln_form,
            'password' => $password_form,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);




        if($newuser_model->exists){
            throw ValidationException::withMessages([
                'join-person-user-email' => '2Το συγκεκριμένο email ανήκει ήδη σε κάποιον χρήστη',
                'join-person-user-uid' => '2Ο συγκεκριμένος Αριθμός Μητρώου ανήκει ήδη σε κάποιον χρήστη'
            ]);
        }else{
            $newuser_model->save();
            $newsubmission_model = Submission::firstOrNew(
                [
                    'studentacc_id' => $newuser_model->id,
                    'teamname' => $teamappname_form,
                    'appname' => $appname_form,
                ],
                [
                'submision_id' => $submission_hash_id,
                'apptags' => $apptags_form,
                'appdesc' => $appdesc_form,
                'join_type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            if($newsubmission_model->exists){

                throw ValidationException::withMessages([
                    'join-person-teamapp-name' => 'Το όνομα της ομάδας χρησιμοποιείται ήδη',
                    'join-person-app-name' => 'Το όνομα της εφαρμογής χρησιμοποιείται ήδη'
                ]);
            }else{
                $newsubmission_model->save();
                return redirect(url('/join/status/'.$submission_hash_id));
            }
        }






    }


    function join_team(Request $request){
        if($request->session()->has('connector_status_api')){
            $csapi_get_value = $request->session()->get('connector_status_api');
            $request->session()->forget('api_action_type', 'join_person_info_filler_callback');
            $request->session()->forget('connector_status_api');
            if($request->session()->has('join-person-personal-form-FILLDATA')){
                $personal_data_filler_arr = $request->session()->get('join-person-personal-form-FILLDATA');
                return view('join-team', ['csapi' => $csapi_get_value, 'personal_data_filler_arr' => $personal_data_filler_arr]);
            }else{
                return view('join-team', ['csapi' => $csapi_get_value]);
            }

        }else{
            if($request->session()->has('join-person-personal-form-FILLDATA')){
                $personal_data_filler_arr = $request->session()->get('join-person-personal-form-FILLDATA');
                return view('join-team', ['csapi' => '', 'personal_data_filler_arr' => $personal_data_filler_arr]);
            }else{
                return view('join-team', ['csapi' => '']);
            }
        }

    }

    function join_team_submit(Request $request){


        $request->flash();
        $fn_form = $request->input('join-person-user-firstname');
        $ln_form = $request->input('join-person-user-lastname');
        $kas_form = $request->input('join-person-user-uid');
        $email_form = $request->input('join-person-user-email');
        $password_form = Hash::make($request->input('join-person-user-password'));
        $teamappname_form = $request->input('join-person-teamapp-name');
        $appname_form = $request->input('join-person-app-name');
        $apptags_form = json_encode($request->input('join-person-app-tags'));
        $appdesc_form = $request->input('join-person-app-desc');
        $submission_hash_id = sha1(md5(($teamappname_form."/".$appname_form."@".$kas_form)));

        if($request->session()->has('join-person-personal-form-FILLDATA')) {
            $array_session_personal = $request->session()->get('join-person-personal-form-FILLDATA');
            $newdat_personal = [];
            $newdat_personal['firstname'] = $fn_form;
            $newdat_personal['lastname'] = $ln_form;
            $newdat_personal['email'] = $email_form;
            $newdat_personal['uid'] = $kas_form;
            $request->session()->forget('join-person-personal-form-FILLDATA');
            $request->session()->put('join-person-personal-form-FILLDATA', $newdat_personal);
        }


        $customMessages = [
            'required' => 'Το πεδίο αυτό είναι υποχρεωτικό και δεν πρέπει να είναι κενό',
            'join-person-user-uid.starts_with' => 'Ο αριθμός μητρώου θα πρέπει υποχρεωτικά να ξεκινάει με κάποιο απο τα παρακάτω: iee, it, el',
            'join-person-user-uid.max' => 'Ο αριμός μητρώου δεν πρέπει να ξεπερνάει τους 10 αλφαριθμητικούς χαρακτήρες',
            'email' => 'Μή έγκυρη διεύθυνση email',
            'alpha' => 'Επιτρέπονται μόνο η αλφαβητική χαρακτήρες',
            'max' => 'Η έκταση του κειμένου δεν πρέπει να ξεπερνάει τους :max χαρακτήρες',
            'join-person-app-tags.array' => 'Πρέπει να επιλέξετε τουλάχιστον 1 ετικέτα εφαρμογής',
            'join-person-app-tags.required' => 'Πρέπει να επιλέξετε τουλάχιστον 1 ετικέτα εφαρμογής',
            'join-person-app-desc.max' => 'Η περιγραφή της εφαρμογής δεν πρέπει να ξεπερνάει τους 800 χαρακτήρες',
            'join-person-user-uid.unique' => 'Ο συγκεκριμένος Αριθμός Μητρώου ανήκει ήδη σε κάποιον χρήστη',
            'join-person-user-email.unique' => 'Το συγκεκριμένο email ανήκει ήδη σε κάποιον χρήστη',
            'join-person-teamapp-name.unique' => 'Το όνομα της ομάδας χρησιμοποιείται ήδη',
            'join-person-app-name.unique' => 'Το όνομα της εφαρμογής χρησιμοποιείται ήδη'
        ];

        $validatedData = $request->validate([
            'join-person-user-firstname' => ['required', 'alpha', 'bail', 'string', 'max:10', new Uppercase],
            'join-person-user-lastname' => ['required', 'alpha', 'bail', 'string', 'max:22', new Uppercase],
            'join-person-user-uid' => 'required|bail|starts_with:iee,it,el|string|max:10|unique:App\Models\User,kas',
            'join-person-user-email' => ['required','email:rfc,dns','max:30','unique:App\Models\User,email'],
            'join-person-user-password' => 'required|bail|string|max:20',
            'join-person-teamapp-name' => 'required|bail|string|max:60|unique:App\Models\Submission,teamname',
            'join-person-app-name' => 'required|bail|string|max:60|unique:App\Models\Submission,appname',
            'join-person-app-tags' => 'required|array|bail',
            'join-person-app-desc' => 'required|bail|string|max:800'
        ], $customMessages);







        $newuser_model_team = User::firstOrNew(
            [
                'email' => $email_form,
                'kas' => $kas_form
            ],
            [
                'firstname' => $fn_form,
                'lastname' => $ln_form,
                'password' => $password_form,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);




        if($newuser_model_team->exists){
            throw ValidationException::withMessages([
                'join-person-user-email' => 'Το συγκεκριμένο email ανήκει ήδη σε κάποιον χρήστη',
                'join-person-user-uid' => 'Ο συγκεκριμένος Αριθμός Μητρώου ανήκει ήδη σε κάποιον χρήστη'
            ]);
        }else{
            $newuser_model_team->save();
            $invite_code_hash = md5(sha1($teamappname_form."/".$appname_form."@".$kas_form."/".$email_form));
            $newsubmission_model_team = Submission::firstOrNew(
                [
                    'studentacc_id' => $newuser_model_team->id,
                    'teamname' => $teamappname_form,
                    'appname' => $appname_form,
                ],
                [
                    'submision_id' => $submission_hash_id,
                    'apptags' => $apptags_form,
                    'appdesc' => $appdesc_form,
                    'join_type' => 2,
                    'invite_code' => $invite_code_hash,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            if($newsubmission_model_team->exists){
                throw ValidationException::withMessages([
                    'join-person-teamapp-name' => 'Το όνομα της ομάδας χρησιμοποιείται ήδη',
                    'join-person-app-name' => 'Το όνομα της εφαρμογής χρησιμοποιείται ήδη'
                ]);
            }else{
                $newsubmission_model_team->save();
                return redirect(url('/join/status/'.$submission_hash_id));
            }
        }
    }

    function join_memeber_to_team(Request $request, $invitecode){
        $submission_data = Submission::where([
            ['invite_code', '=', $invitecode],
            ['invite_active', '=', 1]
        ])->first();
        if($submission_data !== null){
            $user_for_this_submision = $submission_data->admin;
            if($request->session()->has('connector_status_api')){
                $csapi_get_value = $request->session()->get('connector_status_api');
                $request->session()->forget('api_action_type', 'join_person_info_filler_callback');
                $request->session()->forget('connector_status_api');
                if($request->session()->has('join-person-personal-form-FILLDATA')){
                    $personal_data_filler_arr = $request->session()->get('join-person-personal-form-FILLDATA');
                    return view('team-invite-link', ['csapi' => $csapi_get_value, 'personal_data_filler_arr' => $personal_data_filler_arr, 'status' => 'success', 'user_data' => $user_for_this_submision->toArray(), 'submision_data' => $submission_data->toArray(), 'invcodedata' => $invitecode] );
                }else{
                    return view('team-invite-link', ['csapi' => $csapi_get_value, 'status' => 'success', 'user_data' => $user_for_this_submision->toArray(), 'submision_data' => $submission_data->toArray(), 'invcodedata' => $invitecode]);
                }

            }else{
                if($request->session()->has('join-person-personal-form-FILLDATA')){
                    $personal_data_filler_arr = $request->session()->get('join-person-personal-form-FILLDATA');
                    return view('team-invite-link', ['csapi' => '', 'personal_data_filler_arr' => $personal_data_filler_arr, 'status' => 'success', 'user_data' => $user_for_this_submision->toArray(), 'submision_data' => $submission_data->toArray(), 'invcodedata' => $invitecode]);
                }else{
                    return view('team-invite-link', ['csapi' => '', 'status' => 'success', 'user_data' => $user_for_this_submision->toArray(), 'submision_data' => $submission_data->toArray(), 'invcodedata' => $invitecode]);
                }
            }
        }else{
            return view('team-invite-link', ['status' => 'error']);
        }

    }

    function join_memeber_to_team_submit(Request $request, $invitecode){
        $submission_data = Submission::where([
            ['invite_code', '=', $invitecode],
            ['invite_active', '=', 1]
        ])->first();
        if($submission_data !== null){
            $submision_team_id = $submission_data['id'];
            $submision_team_admin_id = $submission_data->admin['id'];
        }else{
            return view('team-invite-link', ['status' => 'error']);
        }
        $request->flash();
        $fn_form = $request->input('join-person-user-firstname');
        $ln_form = $request->input('join-person-user-lastname');
        $kas_form = $request->input('join-person-user-uid');
        $email_form = $request->input('join-person-user-email');
        $password_form = Hash::make($request->input('join-person-user-password'));

        if($request->session()->has('join-person-personal-form-FILLDATA')) {
            $array_session_personal = $request->session()->get('join-person-personal-form-FILLDATA');
            $newdat_personal = [];
            $newdat_personal['firstname'] = $fn_form;
            $newdat_personal['lastname'] = $ln_form;
            $newdat_personal['email'] = $email_form;
            $newdat_personal['uid'] = $kas_form;
            $request->session()->forget('join-person-personal-form-FILLDATA');
            $request->session()->put('join-person-personal-form-FILLDATA', $newdat_personal);
        }


        $customMessages = [
            'required' => 'Το πεδίο αυτό είναι υποχρεωτικό και δεν πρέπει να είναι κενό',
            'join-person-user-uid.starts_with' => 'Ο αριθμός μητρώου θα πρέπει υποχρεωτικά να ξεκινάει με κάποιο απο τα παρακάτω: iee, it, el',
            'join-person-user-uid.max' => 'Ο αριμός μητρώου δεν πρέπει να ξεπερνάει τους 10 αλφαριθμητικούς χαρακτήρες',
            'email' => 'Μή έγκυρη διεύθυνση email',
            'alpha' => 'Επιτρέπονται μόνο η αλφαβητική χαρακτήρες',
            'max' => 'Η έκταση του κειμένου δεν πρέπει να ξεπερνάει τους :max χαρακτήρες',
            'join-person-user-uid.unique' => 'Ο συγκεκριμένος Αριθμός Μητρώου ανήκει ήδη σε κάποιον χρήστη',
            'join-person-user-email.unique' => 'Το συγκεκριμένο email ανήκει ήδη σε κάποιον χρήστη'
        ];

        $validatedData = $request->validate([
            'join-person-user-firstname' => ['required', 'alpha', 'bail', 'string', 'max:10', new Uppercase],
            'join-person-user-lastname' => ['required', 'alpha', 'bail', 'string', 'max:22', new Uppercase],
            'join-person-user-uid' => 'required|bail|starts_with:iee,it,el|string|max:10|unique:App\Models\User,kas',
            'join-person-user-email' => ['required','email:rfc,dns','max:30','unique:App\Models\User,email'],
            'join-person-user-password' => 'required|bail|string|max:20'
        ], $customMessages);







        $newuser_model_team = User::firstOrNew(
            [
                'email' => $email_form,
                'kas' => $kas_form
            ],
            [
                'firstname' => $fn_form,
                'lastname' => $ln_form,
                'password' => $password_form,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);




        if($newuser_model_team->exists){
            throw ValidationException::withMessages([
                'join-person-user-email' => 'Το συγκεκριμένο email ανήκει ήδη σε κάποιον χρήστη',
                'join-person-user-uid' => 'Ο συγκεκριμένος Αριθμός Μητρώου ανήκει ήδη σε κάποιον χρήστη'
            ]);
        }else{
            $newuser_model_team->save();
            $newmember_to_team_join = SubmissionTeams::firstOrNew(
              ['member_id' => $newuser_model_team->id],
              [
                  'team_id' => $submision_team_id,
                  'admin_id' => $submision_team_admin_id,
                  'member_id' => $newuser_model_team->id
              ]
            );
            if($newmember_to_team_join->exists){
                throw ValidationException::withMessages([
                    'join-person-user-email' => 'Το συγκεκριμένο email ανήκει ήδη σε αυτήν την ομάδα',
                    'join-person-user-uid' => 'Ο συγκεκριμένος Αριθμός Μητρώου ανήκει ήδη σε αυτήν την ομάδα'
                ]);
            }else{
                $newmember_to_team_join->save();
                return view('team-invite-link', ['status' => 'success_submit']);
            }
        }
    }
}
