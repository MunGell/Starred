<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Token;

use Validator;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use \Auth;

class AuthController extends Controller
{
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'id' => 'required|numeric|unique:users',
            'login' => 'required|max:255|unique:users',
            'avatar' => 'required|url',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::updateOrCreate(['id' => $data['id']], [
            'login' => $data['nickname'],
            'avatar' => $data['avatar'],
        ]);

        Token::updateOrCreate([
            'id' => $data['id']
        ], [
            'token' => $data['token'],
            'auth' => bcrypt($data['token']),
        ]);

        return $user;
    }

    public function getLogin()
    {
        // @todo: temp: offline mode
        Auth::loginUsingId(812976);
        return redirect('/');

        return Socialite::with('github')->redirect();
    }

    public function getCallback()
    {
        $github_user = Socialite::with('github')->user();
        $user = $this->registrar->create((array) $github_user);
        $this->auth->loginUsingId($user->id);

        return redirect('/');
    }
}
