<?php

namespace App\Http\Controllers;

use App\Rules\Uppercase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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
        return view('dashboard');
    }
}
