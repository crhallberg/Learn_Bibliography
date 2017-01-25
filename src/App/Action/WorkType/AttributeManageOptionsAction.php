<?php

namespace App\Action\WorkType;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;
use Zend\Db\Adapter\Adapter;
use Zend\Paginator\Paginator;

class AttributeManageOptionsAction
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
	
	protected function getPaginator($query, $post)
    {   
        // default: blank for listing in manage
		echo "attribute id is " . $query['id'] . "<br />";
        $table = new \App\Db\Table\WorkAttribute_Option($this->adapter);
		$paginator = $table->displayAttributeOptions($query['id']);
		//var_dump($paginator);
		return $paginator;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
		$countPages = 0;
		$query = $request->getqueryParams();
		if(!empty($query['action'])) {
			$action = $query['action'];
		}
        $post = [];
        if ($request->getMethod() == "POST") {
            $post = $request->getParsedBody();  			
		}
        $paginator = $this->getPaginator($query, $post);
		//if($paginator != null) {
		$paginator->setDefaultItemCountPerPage(10);
		$allItems = $paginator->getTotalItemCount();
        $countPages = $paginator->count();
       // echo "no of pages is $countPages <br />";
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
				
        return new HtmlResponse(
            $this->template->render(
                'app::worktype::manage_attribute_options',
                [
                    'rows' => $paginator,
                    'previous' => $previous,
                    'next' => $next,
                    'countp' => $countPages,
					//'itemcount' => $allItems,
					'request' => $request,
					'adapter' => $this->adapter,
                ]
            )
        );
		/*} else {
			return new HtmlResponse(
            $this->template->render(
                'app::worktype::manage_attribute_options',
                [
                    'countp' => $countPages,
					'request' => $request,
					'adapter' => $this->adapter,
                ]
            )
			);
		}*/
    }          
}
