<?php
    namespace App\Http\Controllers\AuthAdmin;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use Illuminate\Foundation\Auth\AuthenticatesUsers;
    use Auth;
    class LoginController extends Controller
    {
        use AuthenticatesUsers;
        protected $redirectTo = '/admin';
        protected $redirectAfterLogout = '/admin';
        public function __construct()
        {
            $this->middleware('guest', ['except' => 'logout']);
        }
        public function showLoginForm()
        {
            return view('auth.admin-login');
        }

        public function username() //меняем e-mail на логин
        {
            return 'name';
        }


        protected function guard()
        {
            return Auth::guard('admin');
        }
}
