<?php

declare(strict_types=1);

namespace App\Handler;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class CreateHandlerFactory
{
    public function __invoke(ContainerInterface $container) : CreateHandler
    {
        return new CreateHandler($container->get(TemplateRendererInterface::class));
    }
}
