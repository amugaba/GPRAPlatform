<?php

class LoginController extends Controller
{
    const MAX_INVALID_LOGINS = 10;
    const TIME_BETWEEN_PASSWORD_RESETS = 15552000; //180 days
    const NUM_OLD_PASSWORDS = 6; //number of old passwords to save and check against
    const PASSWORD_MIN_LENGTH = 8;
    const PASSWORD_MAX_LENGTH = 24;
    const PASSWORD_NUM_SPECIAL = 4;

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
            if($user->invalid_logins >= self::MAX_INVALID_LOGINS) {
                flash('result', new Result(false, 'Account locked due to too many failed logins. Please reset your password'));
                redirect('/login');
            }
            else if($user->last_reset != null && strtotime('now') - strtotime($user->last_reset) > self::TIME_BETWEEN_PASSWORD_RESETS) {
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
            if($num_invalid >= self::MAX_INVALID_LOGINS)
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

        $num_special = preg_match('/[A-Z]/', $password) + preg_match('/[a-z]/', $password)
            + preg_match('/[0-9]/', $password) + preg_match('/['.preg_quote("!#$\"%&'()*+,-./:;<=>?@[\]^_`{|}~", '/').']/', $password);

        if(!$resetApproved) {
            $error = new Result(false, "Reset code is invalid.");
        }
        else if(strlen($password) < self::PASSWORD_MIN_LENGTH || strlen($password) > self::PASSWORD_MAX_LENGTH) {
            $error = new Result(false, "Password must be between ".self::PASSWORD_MIN_LENGTH." and "
                .self::PASSWORD_MAX_LENGTH." characters long.");
        }
        else if($num_special < self::PASSWORD_NUM_SPECIAL) {
            $error = new Result(false, "Password must contain an uppercase letter, a lowercase letter, a number, a special character.");
        }
        else if($password != input('password_confirmation')) {
            $error = new Result(false, "The confirmation password must be the same.");
        }
        else if($ds->matchesPastPasswords($user, $password, self::NUM_OLD_PASSWORDS)) {
            $error = new Result(false, "This password cannot be the same as any of your previous "
                .self::NUM_OLD_PASSWORDS." passwords.");
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