<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class IEEAppsAPIConnector extends Controller
{
    function join_personal_info_filler_iee_apps(Request $request){
        $request->session()->put('return_url', url()->previous());
        $request->session()->put('api_action_type', 'join_person_info_filler_callback');

        return redirect('https://login.iee.ihu.gr/authorization/?client_id=5f9aaa722fa20e7242786e19&response_type=code&scope=profile&redirect_uri=https://app.competition.iee.ihu.gr/api/callback');
    }

    function callback_join_personal_info_filler_iee_apps(Request $request){

        if($request->session()->has('api_action_type') && $request->session()->has('return_url')){
            $connector_action_type = $request->session()->get('application-join-type');
            $return_cb_url = $request->session()->get('return_url');

            if($request->has('error')){
                //Error Connector API (Denied from user or something else)
                $request->session()->put('connector_status_api', 'error');
                $request->session()->forget('return_url');
                $request->session()->forget('api_action_type');
                return redirect($return_cb_url);
            }else{
                if($request->has('code')){
                    $authcode = $request->get('code');
                    $response_token = Http::asForm()->post('https://login.iee.ihu.gr/token', [
                        'client_id' => '5f9aaa722fa20e7242786e19',
                        'client_secret' => '5fctx6pnqe1zykxf7m3f264rg6vitfg84p6neld2kgw3fg9g1r',
                        'grant_type' => 'authorization_code',
                        'code' => $authcode
                    ])->json();
                    if(array_key_exists('access_token', $response_token)){
                        $api_access_token_iee = $response_token['access_token'];
                        $profile_data_user = Http::withHeaders([
                            'x-access-token' => $api_access_token_iee,
                            'Content-Type' => 'application/json'
                        ])->get('https://api.iee.ihu.gr/profile')->json();
                        if(array_key_exists('am', $profile_data_user)){
                            $request->session()->put('connector_status_api', 'success');
                            $user_data_profile_api_arr = array();
                            $user_data_profile_api_arr['firstname'] = $profile_data_user['givenName;lang-el'];
                            $user_data_profile_api_arr['lastname'] = $profile_data_user['sn;lang-el'];
                            $user_data_profile_api_arr['email'] = $profile_data_user['mail'];
                            $user_data_profile_api_arr['uid'] = $profile_data_user['uid'];
                            $request->session()->put('join-person-personal-form-FILLDATA', $user_data_profile_api_arr);
                            $request->session()->forget('return_url');
                            $request->session()->forget('api_action_type');
                            return redirect($return_cb_url);
                        }else{
                            $request->session()->put('connector_status_api', 'error');
                            $request->session()->forget('return_url');
                            $request->session()->forget('api_action_type');
                            return redirect($return_cb_url);
                        }
                    }else{
                        $request->session()->put('connector_status_api', 'error');
                        $request->session()->forget('return_url');
                        $request->session()->forget('api_action_type');
                        return redirect($return_cb_url);
                    }
                }else{
                    $request->session()->put('connector_status_api', 'error');
                    $request->session()->forget('return_url');
                    $request->session()->forget('api_action_type');
                    return redirect($return_cb_url);
                }
            }
        }else{
            return abort(403);
        }
        $connector_action_type = $request->session()->get('application-join-type');

    }
}
