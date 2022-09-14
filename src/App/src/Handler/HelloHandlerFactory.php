<?php

declare(strict_types=1);

namespace App\Handler;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class HelloHandlerFactory
{
    public function __invoke(ContainerInterface $container) : HelloHandler
    {
        return new HelloHandler($container->get(TemplateRendererInterface::class));
    }
}
