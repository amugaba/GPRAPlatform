<?php

use Pecee\Http\Middleware\BaseCsrfVerifier;
use Pecee\Http\Request;
use Pecee\Http\Middleware\Exceptions\TokenMismatchException;

class CsrfVerifier extends BaseCsrfVerifier
{
    /**
     * CSRF validation will be ignored on the following urls.
     */
    protected $except = [];

    /**
     * Handle request
     *
     * @param Request $request
     * @throws TokenMismatchException
     */
    public function handle(Request $request): void
    {

        if ($this->skip($request) === false && \in_array($request->getMethod(), ['post', 'put', 'delete'], true) === true) {

            $token = $request->getInputHandler()->value(
                static::POST_KEY,
                $request->getHeader('http-'.static::HEADER_KEY), //jquery ajax adds "http-" prefix
                'post'
            );
            /*echo '<pre>';
            var_dump('http-'.static::HEADER_KEY);
            var_dump($request->getHeader('http-'.static::HEADER_KEY));
            var_dump($request->getHeaders());
            echo '</pre>';*/

            if ($this->tokenProvider->validate((string)$token) === false) {
                throw new TokenMismatchException('Invalid CSRF-token.');
            }

        }

        // Refresh existing token
        $this->tokenProvider->refresh();

    }
}