<?php

class ErrorController extends Controller
{
    public function getIndex()
    {
        $view = new View('error/index.php');
        return $view->render();
    }

    public function getHelp()
    {
        $view = new View('error/help.php');
        return $view->render();
    }

    public function getFeedbackSent()
    {
        $view = new View('error/help_sent.php');
        return $view->render();
    }

    /**
     * @throws Exception
     */
    public function postSendFeedback() {
        $message = input('message');
        $ms = new MailService();
        $ms->sendUserFeedback(Session::getUser(), $message);
        redirect('/error/feedbackSent');
    }
}