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

class AppleHandler implements RequestHandlerInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $renderer;

    public function __construct(TemplateRendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
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



        return new HtmlResponse($this->renderer->render(
            'app::apple',
            [] // parameters to pass to template
        ));
    }
}
