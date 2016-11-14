<?php

namespace App\Action\Work;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;
use Zend\Db\Adapter\Adapter;
use Zend\Expressive\Helper;
use Zend\Expressive\Helper\ServerUrlHelper;

class ClassifyWorkAction
{
    private $router;

    private $template;
    
    private $adapter;
    
    private $helper;
    //private $dbh;
    //private $qstmt;

    public function __construct(Router\RouterInterface $router, Template\TemplateRendererInterface $template = null, Adapter $adapter, ServerUrlHelper $helper)
    {
        $this->router   = $router;
        $this->template = $template;
        $this->adapter  = $adapter;
        $this->helper = $helper;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        //$displaystr = "Coming Soon";
        $sth = $this->adapter->query("select * from agenttype");
        $rows = $sth->execute();
        
        // Using the generate() method:
         // $url = $this->helper->generate('/foo');
        //$uri = $request->getUri();
        // $path = $uri->getPath();

        // var_dump($uri);
        // var_dump($path);
        return new HtmlResponse($this->template->render('app::classify_work', ['rows' => $rows]));
    }
     
     
}
