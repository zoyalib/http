<?php

declare(strict_types=1);

namespace Zoya\Http\Dispatcher;

interface HandlerFactoryInterface
{
    /**
     * @param  mixed  $handler
     *
     * @return callable
     */
    public function create(mixed $handler): callable;
}
