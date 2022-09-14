<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;

class HomePageHandler implements RequestHandlerInterface
{
    /* @var TemplateRendererInterface */
    private $renderer;

    /* @var MyPDO */
    protected $db;

    protected $data;

    public function __construct(TemplateRendererInterface $renderer, MyPDO $data)
    {
        $this->renderer = $renderer;
        $this->db = MyPDO::instance();
        $this->data = $data;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $data = $this->db->run("SELECT * FROM users")->fetchAll(\PDO::FETCH_ASSOC);

        return new HtmlResponse($this->renderer->render(
            'app::home-page',
            ['data' => $data],
        ));
    }
}
