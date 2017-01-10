<?php

namespace App\Action\WorkType;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;
use Zend\Db\Adapter\Adapter;

class ManageWorkTypeAction
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
   
    /*public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
		$rows = [];
       return new HtmlResponse($this->template->render('app::worktype::manage_worktype', ['rows' => $rows]));
    } */

	protected function getPaginator($query)
    {        
        // default: blank/missing search
        $table = new \App\Db\Table\WorkType($this->adapter);
        return new Paginator(new \Zend\Paginator\Adapter\DbTableGateway($table));				
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $query = $request->getqueryParams();
  
		$table = new \App\Db\Table\WorkType($this->adapter);
        //$paginator = new Paginator(new \Zend\Paginator\Adapter\DbTableGateway($table));
		$paginator = $table->findType();
		//var_dump($paginator);
		//$paginator = $this->getPaginator($query);
		//var_dump($paginator);
        $paginator->setDefaultItemCountPerPage(7);
        $allItems = $paginator->getTotalItemCount();
        $countPages = $paginator->count();
		
        //echo "count is $allItems";
        $currentPage = isset($query['page']) ? $query['page'] : 1;
        if ($currentPage < 1) {
            $currentPage = 1;
        }
        $paginator->setCurrentPageNumber($currentPage);

        if($currentPage == $countPages) {
            $next = $currentPage;
            $previous = $currentPage - 1;
        }
        else if($currentPage == 1) {
            $next = $currentPage + 1;
            $previous = 1;
        }
        else
        {
            $next = $currentPage + 1;
            $previous = $currentPage - 1;
        }

        $searchParams = [];
        if (!empty($query['name'])) {
            $searchParams[] = 'name=' . urlencode($query['name']);
        }
        if (!empty($query['location'])) {
            $searchParams[] = 'location=' . urlencode($query['location']);
        }
        if (!empty($query['letter'])) {
            $searchParams[] = 'letter=' . urlencode($query['letter']);
        }
        
        return new HtmlResponse(
            $this->template->render(
                'app::worktype::manage_worktype',
                [
                    'rows' => $paginator,
                    'previous' => $previous,
                    'next' => $next,
                    'countp' => $countPages,
                    'searchParams' => implode('&', $searchParams),                    
                ]
            )
        );
    }
    
}
