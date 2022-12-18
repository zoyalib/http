<?php

declare(strict_types=1);

namespace Zoya\Http\Dispatcher;

interface RequestBodyDecoderInterface
{
    /**
     * @param  string  $content
     * @param  string  $type
     *
     * @return object
     */
    public function decode(string $content, string $type): object;
}
