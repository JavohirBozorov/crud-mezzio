<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;

class DeleteUserHandler implements RequestHandlerInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $renderer;

    /* @var MyPDO */
    protected $db;

    public function __construct(TemplateRendererInterface $renderer)
    {
        $this->renderer = $renderer;
        $this->db = MyPDO::instance();
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $query = $request->getQueryParams();

        $id = $query["userId"];

        $this->db->run("DELETE FROM users WHERE id = \"$id\"")->fetchAll(\PDO::FETCH_ASSOC);

//        echo '<pre>';
//        var_dump($query["userIdNumber"]);
//        echo '</pre>';
//        exit();

        return new HtmlResponse($this->renderer->render(    
            'app::delete-user',
            [] // parameters to pass to template
        ));
    }
}
