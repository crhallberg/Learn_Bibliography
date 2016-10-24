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
		//$displaystr = "Coming Soon";
		$sth = $this->adapter->query("select * from agenttype");
		$rows = $sth->execute();
	//var_dump($this);
        return new HtmlResponse($this->template->render('app::manage_publisher', ['rows' => $rows]));
    }
	 
	 
}
