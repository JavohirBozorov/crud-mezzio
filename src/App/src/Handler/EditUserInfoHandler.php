<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;

class EditUserInfoHandler implements RequestHandlerInterface
{
    /**
     * @var TemplateRendererInterface
     */
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
        $query = $request->getQueryParams();
        $id = $query["id"];

        if($request->getMethod() == "GET"){
            $getData = $this->db->run("SELECT * FROM users WHERE id = \"$id\" ")->fetchAll(\PDO::FETCH_ASSOC);
            $postData = null;
        }

        if($request->getMethod() == "POST") {

            $dataFromInput = $request->getParsedBody();
            $fileFromInput = $request->getUploadedFiles()['image'];
            $image = $fileFromInput->getClientFileName();
            $name = $dataFromInput['username'];
            $email = $dataFromInput['email'];
            $getData = null;

            $postData = $this->db->run(
                "UPDATE users
                     SET image = \"$image\", username = \"$name\", email = \"$email\" 
                     WHERE id = \"$id\" ")->fetchAll(\PDO::FETCH_ASSOC);
        }
        return new HtmlResponse($this->renderer->render(
            'app::edit-user-info',[
                'getData' => $getData,
                'postData' => $postData ] // parameters to pass to template
        ));
    }
}
