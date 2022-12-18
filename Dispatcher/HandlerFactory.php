<?php

declare(strict_types=1);

namespace Zoya\Http\Dispatcher;

use InvalidArgumentException;
use Psr\Container\ContainerInterface;

class HandlerFactory implements HandlerFactoryInterface
{
    /** @var \Psr\Container\ContainerInterface|null */
    private ?ContainerInterface $container;

    /**
     * @param  \Psr\Container\ContainerInterface|null  $container
     */
    public function __construct(?ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function create(mixed $handler): callable
    {
        if (is_callable($handler)) {
            return $handler;
        }

        if (is_string($handler)) {
            if ($this->container !== null && $this->container->has($handler)) {
                $instance = $this->container->get($handler);

                if (is_callable($instance)) {
                    return $instance;
                }
            }

            if (class_exists($handler)) {
                $instance = new $handler();

                if (is_callable($instance)) {
                    return $instance;
                }
            }
        }

        throw new InvalidArgumentException('Cannot create a callable from a handler');
    }
}
