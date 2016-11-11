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

class EditLanguageAction
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
        if ($request->getMethod() == "POST")
        {
			$post = $request->getParsedBody();
			if(array_filter($post)) {
                $table = new \App\Db\Table\TranslateLanguage($this->adapter);
                $table->updateRecord($_POST['id'], $_POST['de_newlang'], $_POST['en_newlang'], $_POST['es_newlang'], $_POST['fr_newlang'], 
                                             $_POST['it_newlang'], $_POST['nl_newlang']);
			
			}
            $table = new \App\Db\Table\TranslateLanguage($this->adapter);
            $paginator = new Paginator(new \Zend\Paginator\Adapter\DbTableGateway($table));
            $paginator->setDefaultItemCountPerPage(7);
            $allItems = $paginator->getTotalItemCount();
            $countPages = $paginator->count();
        
            $p = $request->getAttribute('page', '1');
         		
            if(isset($p))
            {
                $paginator->setCurrentPageNumber($p); 
            } 
            else 
            {
                $paginator->setCurrentPageNumber(1);
            }

            $currentPage = $paginator->getCurrentPageNumber();

            if($currentPage == $countPages)
            {
                $this->next = $currentPage;
                $this->previous = $currentPage-1;
            }
            else if($currentPage == 1)
            {
                $this->next = $currentPage+1;
                $this->previous = 1;           
            }
            else 
            {
                $this->next = $currentPage+1;
                $this->previous = $currentPage-1;
            } 
        return new HtmlResponse($this->template->render('app::manage_language', ['rows' => $paginator,'previous' => $this->previous,'next' => $this->next,'request' => $request])); 
		} 
        return new HtmlResponse($this->template->render('app::edit_language', ['rows' => $rows, 'request' => $request]));
    }
}
