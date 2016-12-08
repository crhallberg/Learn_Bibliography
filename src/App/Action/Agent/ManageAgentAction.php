<?php

namespace App\Action\Agent;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;
use Zend\Db\Adapter\Adapter;
use Zend\Paginator\Paginator;

class ManageAgentAction
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

    protected function getPaginator($params,$post)
    {        
        // search by letter
        if (!empty($params['letter'])) {
            $table = new \App\Db\Table\Agent($this->adapter);
            return $table->displayRecordsByName($params['letter']);
        }
        //edit, delete actions on agent
        if(!empty($post['action'])){
            //add a new agent
            if($post['action'] == "new"){
                    if ($post['submitt'] == "Save") {
                        $table = new \App\Db\Table\Agent($this->adapter);
                        $table->insertRecords($post['new_agentfirstname'],$post['new_agentlastname'],
                                              $post['new_agentaltname'],$post['new_agentorgname']);
                    }                     
            }  
            //edit an agent
            if($post['action'] == "edit"){
                    if ($post['submitt'] == "Save") {
                        if(!is_null($post['id'])) {
                            
                            $table = new \App\Db\Table\Agent($this->adapter);
                            $table->updateRecord($post['id'], $post['edit_agentfirstname'], $post['edit_agentlastname'], 
                                                 $post['edit_agentaltname'], $post['edit_agentorgname']);                            
                        }
                    }                     
            }               
            //delete an agent
            if($post['action'] == "delete"){
                    if ($post['submitt'] == "Delete") {
                        if(!is_null($post['id'])) {
                            $table = new \App\Db\Table\WorkAgent($this->adapter);
                            $table->deleteRecordByAgentId($post['id']);
                            $table = new \App\Db\Table\Agent($this->adapter);
                            $table->deleteRecord($post['id']); 
                        }
                    }                    
            }
            //Cancel edit\delete
            if ($post['submitt'] == "Cancel") {
                        $table = new \App\Db\Table\Agent($this->adapter);
                        return new Paginator(new \Zend\Paginator\Adapter\DbTableGateway($table));        
            } 
        }
        // default: blank for listing in manage
        $table = new \App\Db\Table\Agent($this->adapter);
        return new Paginator(new \Zend\Paginator\Adapter\DbTableGateway($table));
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $table = new \App\Db\Table\Publisher($this->adapter);
        $characs = $table->findInitialLetter();
        
        $query = $request->getqueryParams();
        $post = [];
        if ($request->getMethod() == "POST") {
            $post = $request->getParsedBody();
        }
        $paginator = $this->getPaginator($query,$post);
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
        
        $searchParams = [];
        if (!empty($query['letter'])) {
            $searchParams[] = 'letter=' . urlencode($query['letter']);
        }
        
        return new HtmlResponse(
            $this->template->render(
                'app::agent::manage_agent',
                [
                    'rows' => $paginator,
                    'previous' => $previous,
                    'next' => $next,
                    'countp' => $countPages,
                    'searchParams' => implode('&', $searchParams),
                    'carat' => $characs,
                ]
            )
        );
    }          
          
}
