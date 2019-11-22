<?php

class LoginController extends Controller
{
    const MAX_INVALID_LOGINS = 10;
    const TIME_BETWEEN_PASSWORD_RESETS = 15552000; //180 days

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

    public function getError()
    {
        $view = new View('login/error.php');
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

        //if login succeeds, check that login permitted
        //a password reset is required if too many invalid logins or if it has been too long since the last reset
        if ($user != null) {
            if($user->invalid_logins >= LoginController::MAX_INVALID_LOGINS) {
                flash('result', new Result(false, 'Account locked due to too many failed logins. Please reset your password'));
                redirect('/login');
            }
            else if($user->last_reset != null && strtotime('now') - strtotime($user->last_reset) > LoginController::TIME_BETWEEN_PASSWORD_RESETS) {
                flash('result', new Result(false, '180 days has passed since last password change. Please reset your password'));
                redirect('/login');
            }
            else {
                $ds->logValidLogin($user);
                session_unset();
                session_destroy();
                session_cache_expire(300);
                session_start();
                Session::setUser($user);
                redirect('/');
            }
        }
        else {
            $num_invalid = $ds->logInvalidLogin($username);
            if($num_invalid >= LoginController::MAX_INVALID_LOGINS)
                flash('result', new Result(false, 'Login failed too many times. Please reset your password'));
            else
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

        $resetApproved = $ds->checkResetCode($id, $code);
        $user = $ds->getUserById($id);
        if(!$resetApproved) {
            $error = new Result(false, "Reset code is invalid.");
        }
        else if(strlen($password) < 8) {
            $error = new Result(false, "Password must be at least 8 characters.");
        }
        else if($password != input('password_confirmation')) {
            $error = new Result(false, "The confirmation password must be the same.");
        }
        else if($ds->isPasswordSame($user, $password)) {
            $error = new Result(false, "This password cannot be the same as your previous password.");
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