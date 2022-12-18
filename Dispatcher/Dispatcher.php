<?php

declare(strict_types=1);

namespace Zoya\Http\Dispatcher;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface Dispatcher
{
    /**
     * @param  mixed                                     $handler
     * @param  \Psr\Http\Message\ServerRequestInterface  $request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function dispatch(mixed $handler, ServerRequestInterface $request): ResponseInterface;
}
