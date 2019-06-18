<?php
use Pecee\SimpleRouter\SimpleRouter as Router;


Router::csrfVerifier(new CsrfVerifier());

Router::controller('/login', LoginController::class);

Router::group(['middleware' => [Auth::class, RequireGrant::class]], function () {
    Router::get('/', 'HomeController@getIndex');
    Router::controller('/home', HomeController::class);
    Router::controller('/gpra', GPRAController::class);
    Router::controller('/error', ErrorController::class);
    Router::controller('/report', ReportController::class);
});