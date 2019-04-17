<?php

class LoginController extends Controller
{
    public function getIndex()
    {
        $view = new View('login/login.php');
        return $view->render();
    }

    public function getRequestReset()
    {
        $view = new View('login/request_reset.php');
        return $view->render();
    }

    public function getResetSent()
    {
        $view = new View('login/reset_sent.php');
        return $view->render();
    }

    public function getDoReset()
    {
        $view = new View('login/do_reset.php');
        return $view->render();
    }

    /**
     * @throws Exception
     */
    public function postLogin() {
        $username = input('username');
        $password = input('password');

        //check if username and password are valid
        $ds = DataService::getInstance();
        $user = $ds->loginUser($username, $password);

        if ($user != null) {
            session_unset();
            session_destroy();
            session_cache_expire(300);
            session_start();
            Session::setUser($user);

            redirect('/');
        }
        else {
            flash('result', new Result(false, 'Username or password was incorrect.'));
            redirect('/login');
        }
    }

    public function getLogout() {
        session_unset();
        session_destroy();
        redirect('/login');
    }

    /**
     * @throws Exception
     */
    public function postSendReset() {
        //check if username is valid
        $ds = DataService::getInstance();
        $user = $ds->getUserByEmail(input('email'));

        if ($user != null) {
            $ms = new MailService();
            $ms->sendPasswordReset($user);
            redirect('/login/resetSent');
        }
        else {
            flash('result', new Result(false, 'Email not found.'));
            redirect('/login/requestReset');
        }
    }

    /**
     * @throws Exception
     */
    public function postChangePassword() {
        $id = input('id');
        $code = input('code');
        $password = input('password');
        $error = null;
        $ds = DataService::getInstance();

        $resetApproved = $ds->checkResetCode(input('id'), input('code'));
        if(!$resetApproved) {
            $error = new Result(false, "Reset code is invalid.");
        }
        else if(strlen($password) < 8) {
            $error = new Result(false, "Password must be at least 8 characters.");
        }
        else if($password != input('password_confirmation')) {
            $error = new Result(false, "The confirmation password must be the same.");
        }

        if($error != null) {
            flash('result', $error);
            redirect("/login/doReset?id=$id&code=$code");
        }
        else {
            $ds->updatePassword($password, $id);
            flash('result', new Result(true, "New password set successfully. Please log in."));
            redirect('/login');
        }
    }
}