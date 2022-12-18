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

    /** @var \Zoya\Http\Dispatcher\ArgumentResolverInterface */
    private ArgumentResolverInterface $argumentResolver;

    /**
     * @param  \Zoya\Http\Dispatcher\HandlerFactoryInterface    $handlerFactory
     * @param  \Zoya\Http\Dispatcher\ResponseFactoryInterface   $responseFactory
     * @param  \Zoya\Http\Dispatcher\ArgumentResolverInterface  $argumentResolver
     */
    public function __construct(
        HandlerFactoryInterface $handlerFactory,
        ResponseFactoryInterface $responseFactory,
        ArgumentResolverInterface $argumentResolver
    ) {
        $this->handlerFactory   = $handlerFactory;
        $this->responseFactory  = $responseFactory;
        $this->argumentResolver = $argumentResolver;
    }

    public function dispatch(mixed $handler, ServerRequestInterface $request): ResponseInterface
    {
        $callback = $this->handlerFactory->create($handler);

        return $this->responseFactory->create(
            call_user_func_array($callback, $this->argumentResolver->resolve($callback, $request))
        );
    }
}
