<?php

namespace App\Action;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;
use Zend\Expressive\Plates\PlatesRenderer;
use Zend\Expressive\Twig\TwigRenderer;
use Zend\Expressive\ZendView\ZendViewRenderer;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\Driver\ConnectionInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;
use Zend\Db\ResultSet\ResultSet;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

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
        if ($request->getMethod() == 'POST') {
            $post = $request->getParsedBody();
            $table = new \App\Db\Table\TranslateLanguage($this->adapter);
            $rows = $table->updateRecord(
                $post['de'], $post['en'], $post['es'], $post['fr'], $post['it'],
                $post['nl']
            );
        }

        return new HtmlResponse($this->template->render('app::new_language', ['rows' => $rows]));
    }
}
