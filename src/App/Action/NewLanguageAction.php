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
		//$displaystr = "Coming Soon";
		$sth = $this->adapter->query("select * from agenttype");
		$rows = $sth->execute();
	//var_dump($this);
	
	//new
	//$sth = $this->adapter->query("select * from agent");
		//$rows = $sth->execute();
		
       /* $sql =  new Sql($this->adapter);
        $sth = $sql->Select('agent');
		
		$padapter = new DbSelect($sth,$this->adapter);
		$paginator = new Paginator($padapter);
		
		$paginator->setDefaultItemCountPerPage(8);
        $allItems = $paginator->getTotalItemCount();
        $countPages = $paginator->count();

        $p = $request->getAttribute('page', '1');*/
		//$p = $request->getUri()->getQuery();		
		//var_dump($p);
	//new end
	
	//
	//echo $_POST['de_newlang'];
	$sql = new Sql($this->adapter);
	$sth = $sql->insert('translate_language');
	$newData = array(
	//'id'=>1,
	'text_de'=> 'de1',
    'text_en'=> 'en1',
    'text_es'=> 'es1',
	'text_fr'=> 'fr1',
	'text_it'=> 'it1',
	'text_nl'=> 'nl1',
    );
	$sth->values($newData);
	$selectString = $sql->getSqlStringForSqlObject($sth);
	$results = $this->adapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
	//
	
	//
    /*$sql = new Sql($this->dbAdapter);
    $insert = $sql->insert('table');
    $newData = array(
    'col1'=> 'val1',
    'col2'=> 'val2',
    'col3'=> 'val3'
    );
    $insert->values($newData);
    $selectString = $sql->getSqlStringForSqlObject($insert);
    $results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);*/
	//
	
        return new HtmlResponse($this->template->render('app::new_language', ['rows' => $rows]));
    }
	 
	 
}
