<?php

namespace App\Action\Language;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;
use Zend\Db\Adapter\Adapter;
use Zend\Paginator\Paginator;

class DeleteLanguageAction
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
        $rows = [];
        //var_dump($request->getParsedBody());
        if ($request->getMethod() == "POST") {
            $post = $request->getParsedBody();
            if(isset($post['submitt'])) {
                if ($post['submitt'] == "Cancel") {
                    $table = new \App\Db\Table\TranslateLanguage($this->adapter);
                    $paginator = new Paginator(new \Zend\Paginator\Adapter\DbTableGateway($table));
                    $paginator->setDefaultItemCountPerPage(7);
                    $allItems = $paginator->getTotalItemCount();
                    $countPages = $paginator->count();
        
                    $p = $request->getAttribute('page', '1');
                 
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
                    return new HtmlResponse($this->template->render('app::manage_language', ['rows' => $paginator,'previous' => $this->previous,'next' => $this->next,'request' => $request]));
                }
            
        
                if ($post['submitt'] == "Delete") {
                    //echo "Hello World";
                    if(!is_null($post['id'])) {
                        //echo "ok";
                        $table = new \App\Db\Table\TranslateLanguage($this->adapter);
                        $table->deleteRecord($post['id']);
                        $paginator = new Paginator(new \Zend\Paginator\Adapter\DbTableGateway($table));
                        $paginator->setDefaultItemCountPerPage(7);
                        $allItems = $paginator->getTotalItemCount();
                        $countPages = $paginator->count();
        
                        $p = $request->getAttribute('page', '1');
                 
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
                        return new HtmlResponse($this->template->render('app::manage_language', ['rows' => $paginator,
                        'previous' => $this->previous,'next' => $this->next,'request' => $request]));
                    }
                    // echo $_POST['id'];
                }
            }
        }
        return new HtmlResponse($this->template->render('app::delete_language', ['rows' => $rows, 'request' => $request]));
    }
     
     
}
