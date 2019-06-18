<?php

// autoload_classmap.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'Answer' => $baseDir . '/model/Answer.php',
    'Assessment' => $baseDir . '/model/Assessment.php',
    'AssessmentTypes' => $baseDir . '/model/AssessmentTypes.php',
    'Auth' => $baseDir . '/middleware/Auth.php',
    'Client' => $baseDir . '/model/Client.php',
    'ConnectionManager' => $baseDir . '/model/ConnectionManager.php',
    'Controller' => $baseDir . '/controller/Controller.php',
    'CsrfVerifier' => $baseDir . '/middleware/CsrfVerifier.php',
    'DataService' => $baseDir . '/model/DataService.php',
    'Episode' => $baseDir . '/model/Episode.php',
    'ErrorController' => $baseDir . '/controller/ErrorController.php',
    'GPRA' => $baseDir . '/model/GPRA.php',
    'GPRAController' => $baseDir . '/controller/GPRAController.php',
    'GPRAOptionSets' => $baseDir . '/model/GPRAOptionSets.php',
    'GPRASections' => $baseDir . '/model/GPRASections.php',
    'GPRAValidator' => $baseDir . '/validators/GPRAValidator.php',
    'Grant' => $baseDir . '/model/Grant.php',
    'HomeController' => $baseDir . '/controller/HomeController.php',
    'League\\OAuth2\\Client\\Provider\\Google' => $baseDir . '/model/mail/get_oauth_token.php',
    'Log' => $baseDir . '/model/Log.php',
    'LoginController' => $baseDir . '/controller/LoginController.php',
    'MailService' => $baseDir . '/model/MailService.php',
    'PHPMailer' => $baseDir . '/model/mail/class.phpmailer.php',
    'PHPMailerOAuth' => $baseDir . '/model/mail/class.phpmaileroauth.php',
    'PHPMailerOAuthGoogle' => $baseDir . '/model/mail/class.phpmaileroauthgoogle.php',
    'POP3' => $baseDir . '/model/mail/class.pop3.php',
    'Question' => $baseDir . '/model/Question.php',
    'QuestionOption' => $baseDir . '/model/QuestionOption.php',
    'ReportController' => $baseDir . '/controller/ReportController.php',
    'RequireGrant' => $baseDir . '/middleware/RequireGrant.php',
    'Result' => $baseDir . '/model/Result.php',
    'SMTP' => $baseDir . '/model/mail/class.smtp.php',
    'Session' => $baseDir . '/model/Session.php',
    'User' => $baseDir . '/model/User.php',
    'ValidationError' => $baseDir . '/validators/ValidationError.php',
    'Validator' => $baseDir . '/validators/Validator.php',
    'View' => $baseDir . '/view/View.php',
    'phpmailerException' => $baseDir . '/model/mail/class.phpmailer.php',
);