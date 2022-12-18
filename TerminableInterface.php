<?php

declare(strict_types=1);

namespace Zoya\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface TerminableInterface
{
    /**
     * @param  \Psr\Http\Message\ServerRequestInterface  $request
     * @param  \Psr\Http\Message\ResponseInterface       $response
     */
    public function terminate(ServerRequestInterface $request, ResponseInterface $response): void;
}
