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
use Zend\Expressive\Helper;
use Zend\Expressive\Helper\ServerUrlHelper;
use Zend\Expressive\Helper\ServerUrlMiddleware;
use Zend\Expressive\Helper\ServerUrlMiddlewareFactory;

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
