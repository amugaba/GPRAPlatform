<?php

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Exceptions\MalformedUrlException;
use Pecee\Http\Request;
use Pecee\Http\Url;
use Pecee\SimpleRouter\Route\Route;

class Admin implements IMiddleware
{
    protected $except = ['/login'];
    protected $tokenProvider;

    public function __construct()
    {
    }

    /**
     * Check if the url matches the urls in the except property
     * @param Request $request
     * @return bool
     */
    protected function skip(Request $request): bool
    {
        if ($this->except === null || \count($this->except) === 0) {
            return false;
        }

        $max = \count($this->except) - 1;

        for ($i = $max; $i >= 0; $i--) {
            $url = $this->except[$i];

            $url = rtrim($url, '/');
            if ($url[\strlen($url) - 1] === '*') {
                $url = rtrim($url, '*');
                $skip = $request->getUrl()->contains($url);
            } else {
                $skip = ($url === $request->getUrl()->getOriginalUrl());
            }

            if ($skip === true) {
                return true;
            }
        }

        return false;
    }

    /**
     * Handle request. Check if user is logged in.
     *
     * @param Request $request
     * @throws MalformedUrlException
     */
    public function handle(Request $request): void
    {
        if ($this->skip($request) === false)
        {

            if(\Session::getUser() == null || Session::getUser()->admin != 1) {
                response()->redirect('/login');
            }
        }
    }
}