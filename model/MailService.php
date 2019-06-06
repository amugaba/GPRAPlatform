<?php
require_once __DIR__.'/config.php';

class MailService {

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
        $url = HTTP_ROOT."/login/doReset?id=$user->id&code=$randomString";

        $mailer = $this->createMail("GPRA Portal: Password Reset");
        $body = "<p>A password reset was requested for your account. To reset your password, click the following link and enter a new password on that page.</p>
            <p>$url</p>
            <p>If you do not wish to reset your password, you may ignore this email.</p>";

        $mailer->msgHTML($body);
        $mailer->addAddress($user->email, $user->username);
        $mailer->send();
    }

    /**
     * @param $user User
     * @param $message string
     * @throws Exception
     */
    public function sendUserFeedback($user, $message) {
        $ds = DataService::getInstance();
        $logs = $ds->getLogsByUser($user->email, 10);
        $logHTML = "";
        foreach ($logs as $log) {
            $logHTML .= "
            <tr>
                <td>$log->datetime</td>
                <td>$log->message</td>
            </tr>";
        }

        $msgHTML = "
        <style>
            table {border: thin solid black}
            td {border: thin solid black; padding: 5px}
            th {border: thin solid black; padding: 5px; font-weight: bold; background-color: #c0c0c0}
        </style>
        <h2>Feedback/Issue Received</h2>
        <b>User:</b> $user->name : $user->email<br><br>
        <b>Message:</b> $message<br><br>
        <h4>Recent Logs</h4>
        <table>
            <tr>
                <th>DateTime</th>
                <th>Message</th>
            </tr>
            $logHTML
        </table>";

        $mail = $this->createMail('GPRA Platform Feedback from '.$user->name);
        $mail->addAddress('tiddd@indiana.edu','David Tidd');
        $mail->msgHTML($msgHTML);
        $mail->send();
    }

    /**
     * @param $subject string
     * @return PHPMailer
     * @throws Exception
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