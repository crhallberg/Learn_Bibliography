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
                    if ($post['submit_add'] == "Add") {
                        $table = new \App\Db\Table\WorkType_WorkAttribute($this->adapter);
                        $paginator = $table->displayRanks($post['type_id']);
						$cnt = $paginator->getTotalItemCount();
						//echo "fetched no of ranks to be sent to update method $cnt <br />";
						//$array = iterator_to_array($paginator);
						$ranks = [];
						foreach($paginator as $row) :
						$ranks[] = $row['rank'];
						endforeach;
						//echo"post is";
						//echo '<pre>';print_r($post['selectchk_added']);echo '</pre>';
						//print_r($ranks);
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
						$table->UpdateWorkTypeAttributeRank($post['type_id'],$wkat_ids,$post['selectchk_added']);
						$table->addAttributeToWorkType($post['type_id'],$wkat_ids);
                    } 
            }
			//remove attribute(s) from worktype
            if($post['action'] == "remove_attribute"){
                    if ($post['submit_remove'] == "Remove")
					{
						/*if($post['allAttributes'] != null) {
							if($post['selectchk_added'] != null)
							{
								for($i=0;$i<count($post['allAttributes']);$i++){
									
								}
								$wkat_ids = $post['selectchk_added'];
							}
						}*/
						$result = array_diff($post['allAttributes'], $post['selectchk_added']);
						echo '<pre>';print_r($result);echo '</pre>';
						/*$table = new \App\Db\Table\WorkType_WorkAttribute($this->adapter);
						$table->deleteAttributeFromWorkType($post['type_id'],);
                        $table->updateWorkTypeAttributeRank_Remove($post['id'], $post['edit_worktype']);  */
						echo '<pre>';print_r($post);echo '</pre>';	
                        
                    }
					echo "entered remove attribute";
			}								
            //Cancel add\edit\delete
			if($post['action'] == "cancel_attributes"){
				if ($post['submit_cancel'] == "Cancel") {
					echo "entered cancel";
                    $table = new \App\Db\Table\WorkType_WorkAttribute($this->adapter);
                    return new Paginator(new \Zend\Paginator\Adapter\DbTableGateway($table));      
				}
			}			
        }
        // default: blank for listing in manage
        $table = new \App\Db\Table\WorkType_WorkAttribute($this->adapter);
        return new Paginator(new \Zend\Paginator\Adapter\DbTableGateway($table)); 
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
		$query = $request->getqueryParams();
		if(!empty($query['action'])) {
			$action = $query['action'];
		}
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
		if($action == "add_remove"){	
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
