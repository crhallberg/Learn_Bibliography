<?php

namespace App\Action\WorkType;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;
use Zend\Db\Adapter\Adapter;
use Zend\Paginator\Paginator;

class ManageWorkTypeAttributeAction
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
    
    /*public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        return new HtmlResponse($this->template->render(
		'app::worktype::manage_worktypeattribute', 
		['request' => $request, 'adapter' => $this->adapter]
		)
		);
    }*/
	
	protected function getPaginator($query, $post)
    {       
        if(!empty($query['action'])) {
			if($query['action'] == "darrow") {
				echo "it is darrow";
				$table = new \App\Db\Table\WorkType_WorkAttribute($this->adapter);
				$table->darrowUpdate($query['id'], $query['workattribute_id'], $query['rank'], $query['field']);
			}
		}
		//add, edit, delete actions on worktype
        if(!empty($post['action'])){
            //add a new work type
            if($post['action'] == "new"){
                    if ($post['submitt'] == "Save") {
                        $table = new \App\Db\Table\WorkType($this->adapter);
                        $table->insertRecords($post['new_worktype']);
                    }                     
            }
			//edit a work type
            if($post['action'] == "edit"){
                    if ($post['submitt'] == "Save") {
                        if(!is_null($post['id'])) {
                            
                            $table = new \App\Db\Table\WorkType($this->adapter);
                            $table->updateRecord($post['id'], $post['edit_worktype']);                            
                        }
                    }                     
            }  
			//delete a work type
            if($post['action'] == "delete"){
                    if ($post['submitt'] == "Delete") {
                        if(!is_null($post['id'])) {
                            $table = new \App\Db\Table\Work($this->adapter);
                            $table->updateWorkTypeId($post['id']);
                            $table = new \App\Db\Table\WorkType($this->adapter);
                            $table->deleteRecord($post['id']); 
                        }
                    }                    
            }
            //Cancel add\edit\delete
            if ($post['submitt'] == "Cancel") {
                        $table = new \App\Db\Table\WorkType($this->adapter);
                        return new Paginator(new \Zend\Paginator\Adapter\DbTableGateway($table));        
            } 
        }
        // default: blank for listing in manage
        $table = new \App\Db\Table\WorkType($this->adapter);
        return new Paginator(new \Zend\Paginator\Adapter\DbTableGateway($table));
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
		$query = $request->getqueryParams();
		if(!empty($query['action'])) {
			echo $query['action'];
        $post = [];
        if ($request->getMethod() == "POST") {
            $post = $request->getParsedBody();
        }
        $paginator = $this->getPaginator($query, $post);
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
        return new HtmlResponse(
            $this->template->render(
                'app::worktype::manage_worktypeattribute',
                [
                    'rows' => $paginator,
                    'previous' => $previous,
                    'next' => $next,
                    'countp' => $countPages,
					'request' => $request,
					'adapter' => $this->adapter,
                ]
            )
        );
		} else {
			return new HtmlResponse($this->template->render(
			'app::worktype::manage_worktypeattribute', 
			['request' => $request, 'adapter' => $this->adapter]
			)
			);
		}
    }          
}
