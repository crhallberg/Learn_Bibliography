<?php

namespace App\Action\Publisher;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;
use Zend\Db\Adapter\Adapter;
use Zend\Paginator\Paginator;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;

class ManagePublisherAction
{
    private $router;

    private $template;
    
    private $adapter;
    
    
    //private $dbh;
    //private $qstmt;

    public function __construct(Router\RouterInterface $router, Template\TemplateRendererInterface $template = null, Adapter $adapter)
    {
        $this->router   = $router;
        $this->template = $template;
        $this->adapter  = $adapter;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $table = new \App\Db\Table\Publisher($this->adapter);
        $table->findRecord();
        
        if($request->getqueryParams() != null) {
            $params = $request->getqueryParams();
        //} 
        if ($params['search'] == "true") {
            $post = $request->getParsedBody();
            if(array_filter($post)) {
                if(!empty($post['name_publisher'])) {
                    $table = new \App\Db\Table\Publisher($this->adapter);
                    $paginator = $table->findRecords($post['name_publisher']);
                }
                if(!empty($post['location_publisher'])) {
                    $table = new \App\Db\Table\PublisherLocation($this->adapter);
                    $paginator = $table->findRecords($post['location_publisher']);
                }  
            }    
        } 
        }
        else {
        $table = new \App\Db\Table\Publisher($this->adapter);
        $paginator = new Paginator(new \Zend\Paginator\Adapter\DbTableGateway($table));
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

        return new HtmlResponse($this->template->render('app::manage_publisher', ['rows' => $paginator,'previous' => $this->previous,'next' => $this->next,'countp' => $countPages, 'request' => $request]));   
    }
     
     
}
