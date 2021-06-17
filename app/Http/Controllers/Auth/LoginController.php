<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Auth;
use App\User;
use Illuminate\Support\Facades\Validator;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected $maxAttempts = 3;  // Default is 5
    protected $decayMinutes = 1; // Default is 1

    protected function validator(array $data)
    {
        $messages = [
            'name.unique' => 'Вы уже заходили к нам :) Чтобы войти, нажмите на ссылку "Форма входа" внизу.'
        ];

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string'],
        ], $messages);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username() //меняем e-mail на логин
    {
        return 'name';
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
          // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        $user = $request->except(['_token']);
        $reg_date = \Features::checkGigabyteUser($request->input('name'), $request->input('password'));
        $request->request->add(['reg_date' => $reg_date]);
        if (User::where('name', '=', $request->input('name'))->exists()) {
            if (Auth::attempt($user)) {
                $this->clearLoginAttempts($request);
                return redirect()->route('home');
            } else {
                $this->incrementLoginAttempts($request);
                toastr()->error('Неправильный логин или пароль!');
                return redirect()->route('enter');
            }
        } else if ($reg_date) {
            $this->validator($request->all())->validate();

            event(new Registered($user = $this->create($request->all())));

            $this->guard()->login($user);

            return $this->registered($request, $user)
                ?: redirect($this->redirectPath());
        } else {
            $this->incrementLoginAttempts($request);
            toastr()->error('Неправильный логин или пароль!');
            return redirect()->route('enter');
        }
    }

    protected function create(array $data)
    {

        return User::create([
            'name' => $data['name'],
            'password' => Hash::make($data['password']),
            'reg_date' => $data['reg_date']
        ]);
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
