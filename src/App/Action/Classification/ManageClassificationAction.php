<?php

namespace App\Action\Classification;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;
use Zend\Db\Adapter\Adapter;

class ManageClassificationAction
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
        $table = new \App\Db\Table\Folder($this->adapter);
        $paginator = $table->findParent();
        
        $paginator->setDefaultItemCountPerPage(7);
        $allItems = $paginator->getTotalItemCount();
        $countPages = $paginator->count();

        $currentPage = isset($query['page']) ? $query['page'] : 1;
        if ($currentPage < 1) {
            $currentPage = 1;
        }
        $paginator->setCurrentPageNumber($currentPage);

        if ($currentPage == $countPages) {
            $next = $currentPage;
            $previous = $currentPage - 1;
        } elseif ($currentPage == 1) {
            $next = $currentPage + 1;
            $previous = 1;
        } else {
            $next = $currentPage + 1;
            $previous = $currentPage - 1;
        }
        
        return new HtmlResponse(
            $this->template->render(
                'app::classification::manage_classification',
                [
                    'rows' => $paginator,
                    'previous' => $previous,
                    'next' => $next,
                    'countp' => $countPages,
                ]
            )
        );
    }
}
