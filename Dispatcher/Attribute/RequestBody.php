<?php

declare(strict_types=1);

namespace Zoya\Http\Dispatcher\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_PARAMETER)]
final class RequestBody
{
}
