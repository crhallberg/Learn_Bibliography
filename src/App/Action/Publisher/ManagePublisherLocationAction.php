<?php

namespace App\Action\Publisher;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;
use Zend\Db\Adapter\Adapter;
use Zend\Paginator\Paginator;

class ManagePublisherLocationAction
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
       /* if ($request->getMethod() == "POST") {
            $post = $request->getParsedBody();
            if(array_filter($post)) {
                $table = new \App\Db\Table\TranslateLanguage($this->adapter);
                $table->updateRecord(
                    $_POST['id'], $_POST['de_newlang'], $_POST['en_newlang'], $_POST['es_newlang'], $_POST['fr_newlang'],
                    $_POST['it_newlang'], $_POST['nl_newlang']
                );
            
            }
            $table = new \App\Db\Table\TranslateLanguage($this->adapter);
            $paginator = new Paginator(new \Zend\Paginator\Adapter\DbTableGateway($table));
            $paginator->setDefaultItemCountPerPage(7);
            $allItems = $paginator->getTotalItemCount();
            $countPages = $paginator->count();
        
            $p = $request->getAttribute('page', '1');
                 
            if(isset($p)) {
                $paginator->setCurrentPageNumber($p);
            }
            else
            {
                $paginator->setCurrentPageNumber(1);
            }

            $currentPage = $paginator->getCurrentPageNumber();

            if($currentPage == $countPages) {
                $this->next = $currentPage;
                $this->previous = $currentPage - 1;
            }
            else if($currentPage == 1) {
                $this->next = $currentPage + 1;
                $this->previous = 1;
            }
            else
            {
                $this->next = $currentPage + 1;
                $this->previous = $currentPage - 1;
            }
            return new HtmlResponse($this->template->render('app::manage_language', ['rows' => $paginator,'previous' => $this->previous,'next' => $this->next,'request' => $request]));
        } */
        /*$params = $request->getqueryParams();
        var_dump($params);
        $id; */
        if ($request->getqueryParams() !== null) 
        {   
            $queryString = implode('',$request->getqueryParams());
            $params = explode(',',$queryString);            
         //var_dump($params);
        
        if(array_filter($params)) {
            //var_dump($params);
            $table = new \App\Db\Table\PublisherLocation($this->adapter);
            $paginator = $table->findPublisherLocations($params[0]);
        } 
        $paginator->setDefaultItemCountPerPage(7);
        $allItems = $paginator->getTotalItemCount();
        $countPages = $paginator->count();
        
        $p = $request->getAttribute('page', '1');
        //echo 'total items is '.$allItems;
        //echo 'total no of pages is '.$countPages;    
        if(isset($p)) {
            $paginator->setCurrentPageNumber($p);
        }
        else {
            $paginator->setCurrentPageNumber(1);
        }

        $currentPage = $paginator->getCurrentPageNumber();

        if($currentPage == $countPages) {
            $this->next = $currentPage;
            $this->previous = $currentPage - 1;
        }
        else if($currentPage == 1) {
            $this->next = $currentPage + 1;
            $this->previous = 1;
        }
        else
        {
            $this->next = $currentPage + 1;
            $this->previous = $currentPage - 1;
        }    
        }    
        return new HtmlResponse($this->template->render('app::manage_publisherlocation', ['rows' => $paginator,'previous' => $this->previous,'next' => $this->next,'countp' => $countPages, 'request' => $request]));
    }
}
