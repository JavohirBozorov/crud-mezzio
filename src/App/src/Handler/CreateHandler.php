<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Flash\FlashMessageMiddleware;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

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
        $values = $request->getParsedBody();
        $username = $values['username'];
        $email = $values['email'];

        if($request->getUploadedFiles()['image']->getClientFileName() !== ''){
            $file = $request->getUploadedFiles()['image'];

            $image = $file->getClientFileName();

            $ext = pathinfo($image, PATHINFO_EXTENSION);
        } else {
            return new RedirectResponse('apple');
            exit();
        }

        if (!empty(trim($email)) && !empty(trim($username)) && ($ext === 'jpg' || 'jpeg' || 'png' || 'svg')) {

            $file->moveTo('/var/www/html/public/images/' . $file->getClientFileName());

            $this->db->run("INSERT INTO users (image, username, email) VALUES (\"$image\", \"$username\", \"$email\")")->fetchAll(\PDO::FETCH_ASSOC);

            $flashMessages = $request->getAttribute(FlashMessageMiddleware::FLASH_ATTRIBUTE);
            $messageName = 'form-successfully';
            $messageValue = 'Thank you! New user has added.';
            $flashMessages->flash($messageName, $messageValue);
            $message = $flashMessages->getFlash($messageName);
        } else {
//            $flashMessages = $request->getAttribute(FlashMessageMiddleware::FLASH_ATTRIBUTE);
//            $messageName = 'form-unsuccessfully';
//            $messageValue = 'Ops; Some content was empty or your image is not invalid.';
//            $flashMessages->flash($messageName, $messageValue);
//            $message = $flashMessages->getFlash($messageName);
            return new RedirectResponse('apple');
            exit();
        }

        return new HtmlResponse($this->renderer->render(
            'app::create', [
            'message' => $message
            ] // parameters to pass to template
        ));
    }
}
