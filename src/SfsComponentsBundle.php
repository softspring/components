<?php

namespace Softspring\Component\Components;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SfsComponentsBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}