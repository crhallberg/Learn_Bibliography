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

class NewLanguageAction
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
		
/*	$sth = $sql->insert('translate_language');
	$newData = array(
	'id'=>1,
	'text_de'=> 'de1',
    'text_en'=> 'en1',
    'text_es'=> 'es1',
	'text_fr'=> 'fr1',
	'text_it'=> 'it1',
	'text_nl'=> 'nl1',
    );
	$sth->values($newData);
	$selectString = $sql->getSqlStringForSqlObject($sth);
	$results = $this->adapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);*/
	//
	
	$table = new \App\Db\Table\TranslateLanguage($this->adapter);
	$table->insert([
		'text_de'=> 'de1',
		'text_en'=> 'en1',
		'text_es'=> 'es1',
		'text_fr'=> 'fr1',
		'text_it'=> 'it1',
		'text_nl'=> 'nl1',
	]);
	
	var_dump($table);
	
        return new HtmlResponse($this->template->render('app::new_language', ['rows' => $rows]));
    }
	 
	 
}
