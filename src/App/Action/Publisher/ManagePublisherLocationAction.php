<?php

namespace App\Action\Publisher;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;
use Zend\Db\Adapter\Adapter;
use Zend\Paginator\Paginator;

class ManagePublisherLocationAction
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
    
    protected function getPaginator($query,$post)
    {   
    //echo $post['action']
        //add location based on action query parameter
        if(!empty($post['action'])){
            //add a new publisher
            if($post['action'] == "new"){
                    if ($post['submitt'] == "Save") {
                        $table = new \App\Db\Table\PublisherLocation($this->adapter);
                        $table->addPublisherLocation($query['id'],$post['add_publisherloc']);
                    }                     
            }  
            //delete a location for a publisher */
            if($post['action'] == "delete"){
                    if ($post['submitt'] == "Delete") {
                        if(!is_null($post['id']) && ((count($post['locs'])) >= 0)) {
                           $table = new \App\Db\Table\PublisherLocation($this->adapter);
                           $table->deletePublisherRecord($post['id'],$post['locs']);     
                        }
                    }                    
            } 
            //Cancel
            if ($post['submitt'] == "Cancel") {
                        $table = new \App\Db\Table\PublisherLocation($this->adapter);
                        $paginator = $table->findPublisherLocations($query['id']);      
            } 
        }
        // default: blank/missing search
        $table = new \App\Db\Table\PublisherLocation($this->adapter);
        $paginator = $table->findPublisherLocations($query['id']);        
        return $paginator;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $query = $request->getqueryParams();        
        //fetch publisher id based on location id passed
        //var_dump($query);
        if($query['count']==4) {
            $table = new \App\Db\Table\PublisherLocation($this->adapter);
            $row = $table->findPublisherId($query['id']);
            $query['id'] = $row['publisher_id'];
           // echo '<b>Publisher id: </b>'.$query['id'].'<br/>'; 
        }
        var_dump($_POST);
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

        /*$searchParams = [];
        if (!empty($query['name'])) {
            $searchParams[] = 'name=' . urlencode($query['name']);
        }
        if (!empty($query['location'])) {
            $searchParams[] = 'location=' . urlencode($query['location']);
        } */
        
        return new HtmlResponse(
            $this->template->render(
                'app::publisher::manage_publisherlocation',
                [
                    'rows' => $paginator,
                    'previous' => $previous,
                    'next' => $next,
                    'countp' => $countPages,
                    //'searchParams' => implode('&', $searchParams),
                    'request' => $request,
                    'adapter' => $this->adapter
                ]
            )
        );
    }
}
