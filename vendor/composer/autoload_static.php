<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitcc6118f8e79a1b1ee9819aea0cba4464
{
    public static $files = array (
        'bd9634f2d41831496de0d3dfe4c94881' => __DIR__ . '/..' . '/symfony/polyfill-php56/bootstrap.php',
        'b33e3d135e5d9e47d845c576147bda89' => __DIR__ . '/..' . '/php-di/php-di/src/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Polyfill\\Util\\' => 22,
            'Symfony\\Polyfill\\Php56\\' => 23,
            'SuperClosure\\' => 13,
        ),
        'P' => 
        array (
            'Psr\\Container\\' => 14,
            'PhpParser\\' => 10,
            'PhpDocReader\\' => 13,
            'Pecee\\' => 6,
        ),
        'I' => 
        array (
            'Invoker\\' => 8,
        ),
        'D' => 
        array (
            'DI\\' => 3,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Polyfill\\Util\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-util',
        ),
        'Symfony\\Polyfill\\Php56\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-php56',
        ),
        'SuperClosure\\' => 
        array (
            0 => __DIR__ . '/..' . '/jeremeamia/SuperClosure/src',
        ),
        'Psr\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/container/src',
        ),
        'PhpParser\\' => 
        array (
            0 => __DIR__ . '/..' . '/nikic/php-parser/lib/PhpParser',
        ),
        'PhpDocReader\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-di/phpdoc-reader/src/PhpDocReader',
        ),
        'Pecee\\' => 
        array (
            0 => __DIR__ . '/..' . '/pecee/simple-router/src/Pecee',
        ),
        'Invoker\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-di/invoker/src',
        ),
        'DI\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-di/php-di/src',
        ),
    );

    public static $classMap = array (
        'Answer' => __DIR__ . '/../..' . '/model/Answer.php',
        'Assessment' => __DIR__ . '/../..' . '/model/Assessment.php',
        'AssessmentTypes' => __DIR__ . '/../..' . '/model/AssessmentTypes.php',
        'Auth' => __DIR__ . '/../..' . '/middleware/Auth.php',
        'Client' => __DIR__ . '/../..' . '/model/Client.php',
        'ConnectionManager' => __DIR__ . '/../..' . '/model/ConnectionManager.php',
        'Controller' => __DIR__ . '/../..' . '/controller/Controller.php',
        'CsrfVerifier' => __DIR__ . '/../..' . '/middleware/CsrfVerifier.php',
        'DataService' => __DIR__ . '/../..' . '/model/DataService.php',
        'Episode' => __DIR__ . '/../..' . '/model/Episode.php',
        'ErrorController' => __DIR__ . '/../..' . '/controller/ErrorController.php',
        'GPRA' => __DIR__ . '/../..' . '/model/GPRA.php',
        'GPRAController' => __DIR__ . '/../..' . '/controller/GPRAController.php',
        'GPRAOptionSets' => __DIR__ . '/../..' . '/model/GPRAOptionSets.php',
        'GPRASections' => __DIR__ . '/../..' . '/model/GPRASections.php',
        'GPRAValidator' => __DIR__ . '/../..' . '/validators/GPRAValidator.php',
        'Grant' => __DIR__ . '/../..' . '/model/Grant.php',
        'HomeController' => __DIR__ . '/../..' . '/controller/HomeController.php',
        'League\\OAuth2\\Client\\Provider\\Google' => __DIR__ . '/../..' . '/model/mail/get_oauth_token.php',
        'Log' => __DIR__ . '/../..' . '/model/Log.php',
        'LoginController' => __DIR__ . '/../..' . '/controller/LoginController.php',
        'MailService' => __DIR__ . '/../..' . '/model/MailService.php',
        'PHPMailer' => __DIR__ . '/../..' . '/model/mail/class.phpmailer.php',
        'PHPMailerOAuth' => __DIR__ . '/../..' . '/model/mail/class.phpmaileroauth.php',
        'PHPMailerOAuthGoogle' => __DIR__ . '/../..' . '/model/mail/class.phpmaileroauthgoogle.php',
        'POP3' => __DIR__ . '/../..' . '/model/mail/class.pop3.php',
        'Question' => __DIR__ . '/../..' . '/model/Question.php',
        'QuestionOption' => __DIR__ . '/../..' . '/model/QuestionOption.php',
        'ReportController' => __DIR__ . '/../..' . '/controller/ReportController.php',
        'RequireGrant' => __DIR__ . '/../..' . '/middleware/RequireGrant.php',
        'Result' => __DIR__ . '/../..' . '/model/Result.php',
        'SMTP' => __DIR__ . '/../..' . '/model/mail/class.smtp.php',
        'Session' => __DIR__ . '/../..' . '/model/Session.php',
        'User' => __DIR__ . '/../..' . '/model/User.php',
        'ValidationError' => __DIR__ . '/../..' . '/validators/ValidationError.php',
        'Validator' => __DIR__ . '/../..' . '/validators/Validator.php',
        'View' => __DIR__ . '/../..' . '/view/View.php',
        'phpmailerException' => __DIR__ . '/../..' . '/model/mail/class.phpmailer.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitcc6118f8e79a1b1ee9819aea0cba4464::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitcc6118f8e79a1b1ee9819aea0cba4464::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitcc6118f8e79a1b1ee9819aea0cba4464::$classMap;

        }, null, ClassLoader::class);
    }
}