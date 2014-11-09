<?php
 
class AdminController extends BaseController {
 
    public function getIndex()
    {
        return View::make('admin.admin-login');
    }
 
    public function postIndex()
    {
        $email = Input::get('email');
        $password = Input::get('password');
 
        if (Auth::attempt(['email' => $email, 'password' => $password]))
        {
            return Redirect::intended('/user');
        }
 
        return Redirect::back()
            ->withInput()
            ->withErrors('That email/password combo does not exist.');
    }
 
    public function getLogin()
    {
        return Redirect::to('/');
    }
 
    public function getLogout()
    {
        Auth::logout();
 
        return Redirect::to('/');
    }
 
}