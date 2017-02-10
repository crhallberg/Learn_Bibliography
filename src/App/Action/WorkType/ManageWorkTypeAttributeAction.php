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
        //add, remove attributes to work type
        if (!empty($post['action'])) {
			if($post['action'] == "sortable") {
				//echo "action is sortable";
				if ($post['submit_add'] == "Add") {
					if(!empty($post['remove_attr'])) {	
					preg_match_all('/,id_\d+/', $post['remove_attr'], $matches);
					foreach($matches[0] as $id) :
						$attrs_to_remove[] = str_replace(",id_","",$id);
					endforeach;
					echo"remove<br />";echo "<pre>";print_r($attrs_to_remove);echo "</pre>";	
					//remove attributes from a work type
					$table = new \App\Db\Table\WorkType_WorkAttribute($this->adapter);
                    $table->deleteAttributeFromWorkType($post['id'], $attrs_to_remove);                   
					}
					if(!empty($post['sort_order'])) {	
					preg_match_all('/,nid_\d+/', $post['sort_order'], $matches);
					foreach($matches[0] as $id) :
						$attrs_to_add[] = str_replace(",nid_","",$id);
					endforeach;
					echo"add<br />";echo "<pre>";print_r($attrs_to_add);echo "</pre>";
					$table = new \App\Db\Table\WorkType_WorkAttribute($this->adapter);
                    //$table->UpdateWorkTypeAttributeRank($post['type_id'], $wkat_ids, $post['selectchk_added']);
                    $table->addAttributeToWorkType($post['id'], $attrs_to_add);
					}
					//after adding attrs to work type, adjust ranks
					$table->updateWorkTypeAttributeRank_Remove($post['id']);
				}												
			}            
            //Cancel add\edit\delete
            if ($post['action'] == "cancel_attributes") {
                if ($post['submit_cancel'] == "Cancel") {
                    $table = new \App\Db\Table\WorkType($this->adapter);
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
        if (!empty($query['action'])) {
            $action = $query['action'];
        }
        $post = [];
        $post_cancel = false;
        if ($request->getMethod() == "POST") {
            $post = $request->getParsedBody();
            if ($post['action'] == "cancel_attributes") {
                if ($post['submit_cancel'] == "Cancel") {
                    $post_cancel = 'true_cancel';
                }
            }
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

        if ($currentPage == $countPages) {
            $next = $currentPage;
            $previous = $currentPage - 1;
        } elseif ($currentPage == 1) {
            $next = $currentPage + 1;
            $previous = 1;
        } else {
            $next = $currentPage + 1;
            $previous = $currentPage - 1;
        }
        if ($post_cancel == 'true_cancel') {
            return new HtmlResponse($this->template->render(
            'app::worktype::manage_worktype',
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
        }
        if ($action == "sortable") {
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
			//echo "entered last else <br />";
            return new HtmlResponse($this->template->render(
            'app::worktype::manage_worktypeattribute',
            ['request' => $request, 'adapter' => $this->adapter]
            )
            );
        }
    }
}
