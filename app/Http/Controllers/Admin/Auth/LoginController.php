<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Session;
use App\CentralLogics\Helpers;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin', ['except' => 'logout']);
    }

    public function login()
    {
        /* $custome_recaptcha = new CaptchaBuilder;
        $custome_recaptcha->build();
        Session::put('custome_recaptcha', $custome_recaptcha->getPhrase()); */
        return view('admin-views.auth.login');
    }

    public function submit(Request $request)
    {
         /* $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

       $recaptcha = Helpers::get_business_settings('recaptcha');
        if (isset($recaptcha) && $recaptcha['status'] == 1) {
            $request->validate([
                'g-recaptcha-response' => [
                    function ($attribute, $value, $fail) {
                        $secret_key = Helpers::get_business_settings('recaptcha')['secret_key'];
                        $response = $value;
                        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $response;
                        $response = \file_get_contents($url);
                        $response = json_decode($response);
                        if (!$response->success) {
                            $fail(trans('messages.ReCAPTCHA Failed'));
                        }
                    },
                ],
            ]);
        } else if(session('custome_recaptcha') != $request->custome_recaptcha) */
       /*  {
            Toastr::error(trans('messages.ReCAPTCHA Failed'));
            return back();
        } */
        /*$email_saisir = $request->email;
        $password_saisir = $request->password;

        $adminAuth = Http::get('http://192.168.1.102:8000/api/adminLogin', [
            'email_saisir' => $email_saisir,
            'password_saisir' => $password_saisir
        ])->body();
        $email = $adminAuth["id"];*/
        /*$array = json_decode($adminAuth, true);
        $email = $array["email"];
        return $email;*/

        /*$response = Http::asForm()
                       ->withoutVerifying()
                       ->acceptJson()
                       ->timeout(50)
                       ->get('http://192.168.1.102:8000/api/adminLogin', [
                      'email_saisir' => $email_saisir,
                      'password_saisir' => $password_saisir,
                      ]);
       return $response;*/


     
        /*if ($test1 == $email_saisir) {
            # code...
            if ($test2 == $password_saisir) {
                # code...
                return redirect()->route('admin.dashboard');
            }
        }*/
        
        if (auth('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->back()->withInput($request->only('email', 'remember'))
            ->withErrors(['Credentials does not match.']);
        
        
        /*dd($adminAuth);
        if ($adminAuth == 'succes') {
            # code...
            return redirect()->route('admin.dashboard');
        }*/
    }

    public function logout(Request $request)
    {
        auth()->guard('admin')->logout();
        return redirect()->route('admin.auth.login');
    }
}
