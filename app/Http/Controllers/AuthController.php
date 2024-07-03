<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth as FirebaseAuth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $auth;

    public function __construct()
    {
        $firebaseCredentials = config('services.firebase.credentials');
        
        if (!$firebaseCredentials) {
            throw new \Exception('Firebase credentials are not set.');
        }

        $this->auth = (new Factory)
            ->withServiceAccount($firebaseCredentials)
            ->createAuth();
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        try {
            $signInResult = $this->auth->signInWithEmailAndPassword($email, $password);
            $idToken = $signInResult->idToken();

            // Verify ID token
            $verifiedIdToken = $this->auth->verifyIdToken($idToken);
            $uid = $verifiedIdToken->claims()->get('sub');
            $user = $this->auth->getUser($uid);

            // Store user information in the session or any other logic
            $request->session()->put('user', $user);

            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['message' => 'Invalid email or password.']);
        }
    }

    public function dashboard()
    {
        if (!Session::has('user')) {
            return redirect()->route('login');
        }

        return view('dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user');
        Auth::logout();
        return redirect()->route('login');
    }
}
