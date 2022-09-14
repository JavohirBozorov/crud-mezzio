<?php

declare(strict_types=1);

namespace App\Handler;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class AppleHandlerFactory
{
    public function __invoke(ContainerInterface $container) : AppleHandler
    {
        return new AppleHandler($container->get(TemplateRendererInterface::class));
    }
}
