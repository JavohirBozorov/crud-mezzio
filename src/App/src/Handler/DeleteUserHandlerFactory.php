<?php

declare(strict_types=1);

namespace App\Handler;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class DeleteUserHandlerFactory
{
    public function __invoke(ContainerInterface $container) : DeleteUserHandler
    {
        return new DeleteUserHandler($container->get(TemplateRendererInterface::class));
    }
}
