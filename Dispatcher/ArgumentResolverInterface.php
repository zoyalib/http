<?php

declare(strict_types=1);

namespace Zoya\Http\Dispatcher;

use Psr\Http\Message\ServerRequestInterface;

interface ArgumentResolverInterface
{
    /**
     * @param  callable                                  $callable
     * @param  \Psr\Http\Message\ServerRequestInterface  $request
     *
     * @return array
     */
    public function resolve(callable $callable, ServerRequestInterface $request): array;
}
