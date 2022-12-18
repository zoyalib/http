<?php

declare(strict_types=1);

namespace Zoya\Http\Dispatcher;

use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;
use ReflectionFunction;
use ReflectionNamedType;
use Zoya\Http\Dispatcher\Attribute\RequestBody;

class ArgumentResolver implements ArgumentResolverInterface
{
    /** @var \Zoya\Http\Dispatcher\RequestBodyDecoderInterface */
    private RequestBodyDecoderInterface $requestBodyDecoder;

    /**
     * @param  \Zoya\Http\Dispatcher\RequestBodyDecoderInterface  $requestBodyDecoder
     */
    public function __construct(RequestBodyDecoderInterface $requestBodyDecoder)
    {
        $this->requestBodyDecoder = $requestBodyDecoder;
    }

    /**
     * @throws \ReflectionException
     */
    public function resolve(callable $callable, ServerRequestInterface $request): array
    {
        $reflection = new ReflectionFunction($callable(...));
        $arguments  = [];

        foreach ($reflection->getParameters() as $parameter) {
            $attrs    = $parameter->getAttributes();
            $type     = $parameter->getType();
            $typeName = null;

            if ($type instanceof ReflectionNamedType) {
                $typeName = $type->getName();
            }

            if ($typeName === ServerRequestInterface::class) {
                $arguments[] = $request;

                continue;
            }

            foreach ($attrs as $attr) {
                $instance = $attr->newInstance();

                if ($instance instanceof RequestBody) {
                    if ($typeName === null) {
                        throw new InvalidArgumentException(
                            sprintf(
                                'Parameter "%s" under RequestBody attribute should be named type',
                                $parameter->getName()
                            )
                        );
                    }

                    $arguments[] =
                        $this->requestBodyDecoder->decode($request->getBody()->getContents(), $type->getName());
                }
            }
        }

        return $arguments;
    }
}
