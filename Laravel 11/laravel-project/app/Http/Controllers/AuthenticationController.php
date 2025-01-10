<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('auth.loginPage'));
    }

    public function register(Request $request)
    {
        $validatedData = $this->validateRegistration($request);

        session([
            'user_data' => $validatedData,
            'registration_fee' => rand(100000, 125000),
            'payment' => true,
            'payment_expires' => now()->addSecond(60)
        ]);

        return back()->withInput();
    }

    private function validateRegistration(Request $request)
    {
        return $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|unique:users,email|email',
            'password' => 'required|regex:/[0-9]/|regex:/[a-z]/|regex:/[A-Z]/|regex:/[@$!%*?&#]/',
            'gender' => 'required',
            'fields_of_work' => 'required|regex:/^(?:[a-zA-Z\s]+,){2,}[a-zA-Z\s]+$/',
            'linkedin_username' => 'required|regex:/^https:\/\/www.linkedin\.com\/in\/[a-zA-Z0-9\-_]+$/',
            'phone_number' => 'required|digits:12'
        ], [
            'name.required' => __('validation.name_required'),
            'name.min' => __('validation.name_min'),
            'email.required' => __('validation.email_required'),
            'email.unique' => __('validation.email_unique'),
            'email.email' => __('validation.email'),
            'password.required' => __('validation.password_required'),
            'password.regex:/[0-9]/' => __('validation.password_digit'),
            'password.regex:/[a-z]/' => __('validation.password_lowercase'),
            'password.regex:/[A-Z]/' => __('validation.password_uppercase'),
            'password.regex:/[@$!%*?&#]/' => __('validation.password_special'),
            'gender.required' => __('validation.gender_required'),
            'fields_of_work.required' => __('validation.fields_of_work_required'),
            'fields_of_work.regex' => __('validation.fields_of_work_regex'),
            'linkedin_username.required' => __('validation.linkedin_username_required'),
            'linkedin_username.regex' => __('validation.linkedin_username_regex'),
            'phone_number.required' => __('validation.phone_number_required'),
            'phone_number.digits' => __('validation.phone_number_digit')
        ]);
    }

    public function payment(Request $request)
    {
        if ($request->amount == session('registration_fee')) {
            return $this->handleSuccessfulPayment();
        } elseif ($request->amount < session('registration_fee')) {
            return $this->handleUnderpaid($request);
        } else {
            return $this->handleOverpaid($request);
        }
    }

    private function handleSuccessfulPayment()
    {
        $userData = session('user_data');
        User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => $userData['password'],
            'gender' => $userData['gender'],
            'fields_of_work' => json_encode(explode(',', $userData['fields_of_work'])),
            'linkedin_username' => $userData['linkedin_username'],
            'phone_number' => $userData['phone_number']
        ]);

        session()->flush();

        return redirect(route('auth.loginPage'))->with('success', __('lang.registration_success'));
    }

    private function handleUnderpaid(Request $request)
    {
        return back()->withErrors(['amount' => __('lang.underpaid', ['amount' => session('registration_fee') - $request->amount])]);
    }

    private function handleOverpaid(Request $request)
    {
        session(['overpaid' => $request->amount - session('registration_fee')]);

        return back();
    }

    public function overpaidPayment()
    {
        $userData = session('user_data');
        User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => $userData['password'],
            'gender' => $userData['gender'],
            'fields_of_work' => json_encode(explode(',', $userData['fields_of_work'])),
            'linkedin_username' => $userData['linkedin_username'],
            'phone_number' => $userData['phone_number'],
            'coin' => session('overpaid') + 100
        ]);

        session()->flush();

        return redirect(route('auth.loginPage'))->with('success', __('lang.registration_success'));
    }

    public function login(Request $request)
    {
        $credentials = $this->validateLogin($request);

        if (Auth::attempt($credentials)) {
            return redirect(route('home.page'));
        }

        return back()->withErrors(['password' => __('lang.invalid_credentials')]);
    }

    private function validateLogin(Request $request)
    {
        return $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => __('validation.email_required'),
            'email.email' => __('validation.email'),
            'password.required' => __('validation.password_required')
        ]);
    }
}
