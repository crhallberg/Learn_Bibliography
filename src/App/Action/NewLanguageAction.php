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
<<<<<<< HEAD
    private $template;	
	private $adapter; 
=======
    private $template;
    private $adapter;
>>>>>>> eddfd011cb018a0613293cc222e9819f65bcb7a8

    public function __construct(Router\RouterInterface $router, Template\TemplateRendererInterface $template = null, Adapter $adapter)
    {
        $this->router   = $router;
        $this->template = $template;
        $this->adapter  = $adapter;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
<<<<<<< HEAD
		$rows = [];	
		$de1 = 'de1';
		$en1 = 'en1';
		$es1 = 'es1';
		$fr1 = 'fr1';
		$it1 = 'it1';
		$nl1 = 'nl1';
        if ($request->getMethod() == "POST")
        {
			$post = $request->getParsedBody();
			if(array_filter($post)) {
                $table = new \App\Db\Table\TranslateLanguage($this->adapter);
                $rows = $table->updateRecord($_POST['de_newlang'], $_POST['en_newlang'], $_POST['es_newlang'], $_POST['fr_newlang'], 
                                             $_POST['it_newlang'], $_POST['nl_newlang']);
			
			}
		}
=======
        $rows = [];
        if ($request->getMethod() == 'POST') {
            $post = $request->getParsedBody();
            $table = new \App\Db\Table\TranslateLanguage($this->adapter);
            $rows = $table->updateRecord(
                $post['de'], $post['en'], $post['es'], $post['fr'], $post['it'],
                $post['nl']
            );
        }

>>>>>>> eddfd011cb018a0613293cc222e9819f65bcb7a8
        return new HtmlResponse($this->template->render('app::new_language', ['rows' => $rows]));
    }
}
