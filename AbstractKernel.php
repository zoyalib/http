<?php

declare(strict_types=1);

namespace Zoya\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractKernel implements KernelInterface
{
    /**
     * @return \Psr\Http\Server\MiddlewareInterface[]
     */
    abstract protected function getPipeline(): array;

    public function process(ServerRequestInterface $request): ResponseInterface
    {
        $runner = new Runner($this->getPipeline());

        return $runner->handle($request);
    }

    public function terminate(ServerRequestInterface $request, ResponseInterface $response): void
    {
        foreach ($this->getPipeline() as $middleware) {
            if ($middleware instanceof TerminableInterface) {
                $middleware->terminate($request, $response);
            }
        }
    }
}
