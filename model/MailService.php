<?php

class MailService {

    private $html_root = "http://localhost-gpra";

    /**
     * @param $user User
     * @throws Exception
     */
    public function sendPasswordReset($user)
    {
        //create a ten digit code
        $length = 10;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $ds = DataService::getInstance();
        $ds->setResetCode($user->id, $randomString);
        $url = $this->html_root."/login/doReset?id=$user->id&code=$randomString";

        $mailer = $this->createMail("GPRA Portal: Password Reset");
        $body = "<p>A password reset was requested for your account. To reset your password, click the following link and enter a new password on that page.</p>
            <p>$url</p>
            <p>If you do not wish to reset your password, you may ignore this email.</p>";

        $mailer->msgHTML($body);
        $mailer->addAddress($user->email, $user->username);
        $mailer->send();
    }

    public function sendErrorMessage($msg, $func, $data, $page) {
        $user = getUsername();

        $mailer = $this->createMail("GPRA Portal Error");
        $body = "$msg<p>User: $user</p><p>Page: $page</p><p>Function: $func</p><p>Data: $data</p>";

        $mailer->msgHTML($body);
        $mailer->addAddress('tiddd@indiana.edu', 'David Tidd');
        $mailer->send();
    }

    /**
     * @param $subject string
     * @return PHPMailer
     */
    public function createMail($subject)
    {
        $mail = new PHPMailer();

        $mail->isSMTP();                       // telling the class to use SMTP

        $mail->SMTPDebug = 0;
        // 0 = no output, 1 = errors and messages, 2 = messages only.

        $mail->SMTPAuth = true;                // enable SMTP authentication
        $mail->SMTPSecure = "tls";              // sets the prefix to the servier
        $mail->Host = "mail-relay.iu.edu";        // sets IU as the SMTP server
        $mail->Port = 587;                     // set the SMTP port for the IU

        $mail->Username = 'iprctech';
        $mail->Password = 'You talking to me?';

        $mail->CharSet = 'UTF-8';
        $mail->setFrom('iprctech@indiana.edu', 'IPRC');
        $mail->Subject = $subject;
        $mail->ContentType = 'text/plain';
        $mail->isHTML(true);

        return $mail;
    }
}