<?php

namespace App\Action\Language;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;
use Zend\Db\Adapter\Adapter;

class NewLanguageAction
{
    private $router;
    private $template;
    private $adapter;

    public function __construct(Router\RouterInterface $router, Template\TemplateRendererInterface $template = null, Adapter $adapter)
    {
        $this->router   = $router;
        $this->template = $template;
        $this->adapter  = $adapter;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $rows = [];
        if ($request->getMethod() == "POST") {
            $post = $request->getParsedBody();
            if(array_filter($post)) {
                $table = new \App\Db\Table\TranslateLanguage($this->adapter);
                //$rows =
                $table->selectRecords(
                    $_POST['de_newlang'], $_POST['en_newlang'], $_POST['es_newlang'], $_POST['fr_newlang'],
                    $_POST['it_newlang'], $_POST['nl_newlang']
                );
            
            }
        }
        return new HtmlResponse($this->template->render('app::new_language', ['rows' => $rows, 'request' => $request]));
    }
}
