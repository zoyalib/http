<?php

declare(strict_types=1);

namespace Zoya\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use RuntimeException;
use SplQueue;

final class Runner implements RequestHandlerInterface
{
    /** @var \SplQueue<\Psr\Http\Server\MiddlewareInterface> */
    private SplQueue $pipeline;

    /**
     * @param  \Psr\Http\Server\MiddlewareInterface[]  $pipeline
     */
    public function __construct(array $pipeline)
    {
        $this->pipeline = $this->createQueue($pipeline);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if (! $this->pipeline->valid()) {
            throw new RuntimeException(
                'The middleware pipeline did not return a response. The end of the pipeline reached'
            );
        }

        $middleware = $this->pipeline->dequeue();

        return $middleware->process($request, $this);
    }

    /**
     * @param  \Psr\Http\Server\MiddlewareInterface[]  $pipeline
     *
     * @return \SplQueue<\Psr\Http\Server\MiddlewareInterface>
     */
    private function createQueue(array $pipeline): SplQueue
    {
        /** @phpstan-var \SplQueue<\Psr\Http\Server\MiddlewareInterface> $queue */
        $queue = new SplQueue();

        foreach ($pipeline as $middleware) {
            $queue->enqueue($middleware);
        }

        $queue->rewind();

        return $queue;
    }
}
