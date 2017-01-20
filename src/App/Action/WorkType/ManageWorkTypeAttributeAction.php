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
			//decrease the rank
			if($query['action'] == "darrow") {
				echo "it is darrow<br />";
				$table = new \App\Db\Table\WorkType_WorkAttribute($this->adapter);
				$table->darrowUpdate($query['id'], $query['workattribute_id'], $query['rank'], $query['field']);
			}
			//increase the rank
			if($query['action'] == "uarrow") {
				echo "it is uarrow<br />";
				$table = new \App\Db\Table\WorkType_WorkAttribute($this->adapter);
				$table->uarrowUpdate($query['id'], $query['workattribute_id'], $query['rank'], $query['field']);
			}
		}
		//add, remove attributes to worktype
        if(!empty($post['action'])){
            //add attribute(s) new work type
            if($post['action'] == "add_attribute"){
                    if ($post['submitt_add'] == "Add") {
                        $table = new \App\Db\Table\WorkType_WorkAttribute($this->adapter);
                        $paginator = $table->displayRanks($post['type_id']);
						$array = iterator_to_array($paginator);
						$ranks = [];
						foreach($paginator as $row) :
						$ranks[] = $row['rank'];
						endforeach;
						$wkat_ids = [];
						if($post['selectchk_notadded'] != null)
						{
							$wkat_ids = $post['selectchk_notadded'];
						}
						if($post['selectchk_noneadded'] != null)
						{
							$wkat_ids = $post['selectchk_noneadded'];
						}
						$table = new \App\Db\Table\WorkType_WorkAttribute($this->adapter);
						$table->UpdateWorkTypeAttributeRank($post['type_id'],$wkat_ids,$ranks,$post['selectchk_added']);
						$table->addAttributeToWorkType($post['type_id'],$wkat_ids);
                    } 
            }
			//remove attribute(s) from worktype
            if($post['action'] == "remove_attribute"){
                    /*if ($post['submitt'] == "Save") {
                        if(!is_null($post['id'])) {                            
                            $table = new \App\Db\Table\WorkType($this->adapter);
                            $table->updateRecord($post['id'], $post['edit_worktype']);                            
                        }
                    }   */
						echo "entered remove attribute";
            }  
			
            //Cancel add\edit\delete
            if ($post['cancel'] == "Cancel") {
                        $table = new \App\Db\Table\WorkType_WorkAttribute($this->adapter);
                        return new Paginator(new \Zend\Paginator\Adapter\DbTableGateway($table));        
            } 
        }
        // default: blank for listing in manage
        $table = new \App\Db\Table\WorkType_WorkAttribute($this->adapter);
        return new Paginator(new \Zend\Paginator\Adapter\DbTableGateway($table)); 
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
		//echo "entered managa attributes action <br />";
		$query = $request->getqueryParams();
		//if(!empty($query['action'])) {
			//echo "entered query if <br />";
			//echo $query['action'];
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
		/*} else {
			//echo "entered else";
			return new HtmlResponse($this->template->render(
			'app::worktype::manage_worktypeattribute', 
			['request' => $request, 'adapter' => $this->adapter]
			)
			);
		}*/
    }          
}
