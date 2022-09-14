<?php

declare(strict_types=1);

namespace App\Handler;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class EditUserInfoHandlerFactory
{
    public function __invoke(ContainerInterface $container) : EditUserInfoHandler
    {
        return new EditUserInfoHandler($container->get(TemplateRendererInterface::class));
    }
}
