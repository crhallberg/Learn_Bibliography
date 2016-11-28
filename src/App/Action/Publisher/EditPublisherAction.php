<?php

namespace App\Action\Publisher;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;
use Zend\Db\Adapter\Adapter;
use Zend\Paginator\Paginator;

class EditPublisherAction
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
                $table = new \App\Db\Table\Publisher($this->adapter);
                $table->updateRecord($_POST['id'], $_POST['publisher_newname']);
            
            }
            
            $table = new \App\Db\Table\Publisher($this->adapter);
            $paginator = new Paginator(new \Zend\Paginator\Adapter\DbTableGateway($table));
            $paginator->setDefaultItemCountPerPage(7);
            $allItems = $paginator->getTotalItemCount();
            $countPages = $paginator->count();
        
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
            
            return new HtmlResponse(
            $this->template->render(
                'app::manage_publisher',
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
        return new HtmlResponse($this->template->render('app::edit_publisher', ['rows' => $rows, 'request' => $request]));
    }
}
