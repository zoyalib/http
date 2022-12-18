<?php

declare(strict_types=1);

namespace Zoya\Http\Dispatcher;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DispatcherImpl implements Dispatcher
{
    /** @var \Zoya\Http\Dispatcher\HandlerFactoryInterface */
    private HandlerFactoryInterface $handlerFactory;

    /** @var \Zoya\Http\Dispatcher\ResponseFactoryInterface */
    private ResponseFactoryInterface $responseFactory;

    /**
     * @param  \Zoya\Http\Dispatcher\HandlerFactoryInterface   $handlerFactory
     * @param  \Zoya\Http\Dispatcher\ResponseFactoryInterface  $responseFactory
     */
    public function __construct(HandlerFactoryInterface $handlerFactory, ResponseFactoryInterface $responseFactory)
    {
        $this->handlerFactory  = $handlerFactory;
        $this->responseFactory = $responseFactory;
    }

    public function dispatch(mixed $handler, ServerRequestInterface $request): ResponseInterface
    {
        return $this->responseFactory->create($this->handlerFactory->create($handler)($request));
    }
}
