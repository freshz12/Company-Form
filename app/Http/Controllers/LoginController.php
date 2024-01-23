<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Login;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index()
    {
        // $username = '';
        return view('login');
    }

    public function authenticate(Request $request)
    {

        $credentials = $request->only('EmailAddress', 'password');

        $user = $credentials['EmailAddress'];
        $password = $credentials['password'];

        $user = strtolower($user);
        $user = str_replace("", "", $user);

        // active directory host
        $ldap_host = "";

        // active directory DN (base location of ldap search)
        $ldap_dn = "";

        // domain, for purposes of constructing $user
        $ldaprdn = '';

        // connect to active directory
        $ldap = ldap_connect($ldap_host);
        // configure ldap params



        if ($ldap) {
            ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
            ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);

            try {
                if (ldap_bind($ldap, $ldaprdn, $password)) {

                    $filter = "";
                    $result = ldap_search($ldap, $ldap_dn, $filter) or exit("Unable to search LDAP server");
                    $entries = ldap_get_entries($ldap, $result);
                    // dd( $entries);
                    ldap_unbind($ldap);

                    $username = $entries[0][''][0];
                    $emailaddress = $entries[0][''][0];

                    $user = User::where('EmailAddress', $emailaddress)->first();
                    $active = $user->Status;


                    if ($user) {

                        if ($active !== '' && $active == 'AKTIF') {
                            Auth::login($user);
                            $request->session()->regenerate();

                            if (auth()->check() == 1) {
                                return redirect()->intended('/home');
                            }
                        } else {
                            return back()->with('gagal', 'Your account is no longer active');
                        }

                    } else {
                        return back()->with('gagal', 'You do not have access to this application');
                    }
                } else {
                    // LDAP bind failed due to invalid credentials
                    return back()->with('gagal', 'Invalid credentials. Please check your username and password.');
                }
            } catch (Exception $e) {
                $errorMessage = $e->getMessage();
                return back()->with('gagal', 'LDAP Connection Failed');
            }

        } else {
            return back()->with('gagal', 'LDAP Connection Failed');
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();


        return redirect('/login')->with('gud', 'Logged Out Succesfully');
    }
}