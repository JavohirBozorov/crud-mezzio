<?php

declare(strict_types=1);

namespace App\Handler;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class HomePageHandlerFactory
{
    public function __invoke(ContainerInterface $container) : HomePageHandler
    {
        $data = new MyPdo();
        return new HomePageHandler($container->get(TemplateRendererInterface::class), $data);
    }
}
