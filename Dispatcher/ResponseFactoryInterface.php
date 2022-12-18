<?php

declare(strict_types=1);

namespace Zoya\Http\Dispatcher;

use Psr\Http\Message\ResponseInterface;

interface ResponseFactoryInterface
{
    /**
     * @param  mixed  $data
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function create(mixed $data): ResponseInterface;
}
