<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use App\Handler\UploadForm;

class CreateHandler implements RequestHandlerInterface
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

        $form = new UploadForm('upload-form');

        if ($request->getMethod() == "POST") {

            $values = $request->getParsedBody();
            $username = $values['username'];
            $email = $values['email'];

            $file = $request->getUploadedFiles()['image'];
            $image = $file->getClientFileName();
            $file->moveTo('/var/www/html/public/images/' . $file->getClientFileName());

            $this->db->run("INSERT INTO users (image, username, email) VALUES (\"$image\", \"$username\", \"$email\")")->fetchAll(\PDO::FETCH_ASSOC);

//            Make certain to merge the $_FILES info!
//            $post = array_merge_recursive(
//                $request->getParsedBody(),
//                $request->getUploadedFiles(),
//            );

//            $form->setData($post);
//            if ($form->isValid()) {
//                $data = $form->getData();
//;
//                return new RedirectResponse('apple');
//            }
        }


        return new HtmlResponse($this->renderer->render(
            'app::create', [
            "values" => $values,
            'form' => $form,] // parameters to pass to template
        ));
    }
}
