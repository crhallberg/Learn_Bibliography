<?php
use Zend\Expressive\Helper\BodyParams\BodyParamsMiddleware;

return [
    'dependencies' => [
        'invokables' => [
            Zend\Expressive\Router\RouterInterface::class => Zend\Expressive\Router\FastRouteRouter::class,
            App\Action\PingAction::class => App\Action\PingAction::class,
        ],
        'factories' => [	
            App\Action\HomePageAction::class => App\Action\HomePageFactory::class,
			App\Action\Work\NewWorkAction::class => App\Action\Work\NewWorkFactory::class,
			App\Action\Work\SearchWorkAction::class => App\Action\Work\SearchWorkFactory::class,
			App\Action\Work\ManageWorkAction::class => App\Action\Work\ManageWorkFactory::class,
			App\Action\Work\ReviewWorkAction::class => App\Action\Work\ReviewWorkFactory::class,
			App\Action\Work\ClassifyWorkAction::class => App\Action\Work\ClassifyWorkFactory::class,
			App\Action\WorkType\NewWorkTypeAction::class => App\Action\WorkType\NewWorkTypeFactory::class,
			App\Action\WorkType\ManageWorkTypeAction::class => App\Action\WorkType\ManageWorkTypeFactory::class,
			App\Action\WorkType\AttributesWorkTypeAction::class => App\Action\WorkType\AttributesWorkTypeFactory::class,
			App\Action\Classification\NewClassificationAction::class => App\Action\Classification\NewClassificationFactory::class,
			App\Action\Classification\ManageClassificationAction::class => App\Action\Classification\ManageClassificationFactory::class,
			App\Action\Classification\MergeClassificationAction::class => App\Action\Classification\MergeClassificationFactory::class,
			App\Action\Classification\ExportListClassificationAction::class => App\Action\Classification\ExportListClassificationFactory::class,
			App\Action\Agent\NewAgentAction::class => App\Action\Agent\NewAgentFactory::class,
			App\Action\Agent\FindAgentAction::class => App\Action\Agent\FindAgentFactory::class,
			App\Action\Agent\ManageAgentAction::class => App\Action\Agent\ManageAgentFactory::class,
			App\Action\Agent\MergeAgentAction::class => App\Action\Agent\MergeAgentFactory::class,
			App\Action\AgentType\NewAgentTypeAction::class => App\Action\AgentType\NewAgentTypeFactory::class,
			App\Action\AgentType\ManageAgentTypeAction::class => App\Action\AgentType\ManageAgentTypeFactory::class,
			App\Action\Publisher\NewPublisherAction::class => App\Action\Publisher\NewPublisherFactory::class,
			App\Action\Publisher\FindPublisherAction::class => App\Action\Publisher\FindPublisherFactory::class,
			App\Action\Publisher\ManagePublisherAction::class => App\Action\Publisher\ManagePublisherFactory::class,
            App\Action\Publisher\ManagePublisherLocationAction::class => App\Action\Publisher\ManagePublisherLocationFactory::class,
			App\Action\Publisher\MergePublisherAction::class => App\Action\Publisher\MergePublisherFactory::class,
			App\Action\Language\NewLanguageAction::class => App\Action\Language\NewLanguageFactory::class,
			App\Action\Language\ManageLanguageAction::class => App\Action\Language\ManageLanguageFactory::class,
            App\Action\Language\EditLanguageAction::class => App\Action\Language\EditLanguageFactory::class,
            App\Action\Language\DeleteLanguageAction::class => App\Action\Language\DeleteLanguageFactory::class,
			App\Action\Users\NewUsersAction::class => App\Action\Users\NewUsersFactory::class,
			App\Action\Users\ManageUsersAction::class => App\Action\Users\ManageUsersFactory::class,
			App\Action\Users\AccessUsersAction::class => App\Action\Users\AccessUsersFactory::class,
			App\Action\Preferences\ChangePasswordPreferencesAction::class => App\Action\Preferences\ChangePasswordPreferencesFactory::class,
        ],
    ],

    'routes' => [
        [
            'name' => 'home',
            'path' => '/',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\HomePageAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
        [
           'name' => 'new_work',
		    'path' => '/newwork',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\Work\NewWorkAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],

        [
            'name' => 'search_work',
		    'path' => '/searchwork',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\Work\SearchWorkAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'manage_work',
		    'path' => '/managework',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\Work\ManageWorkAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'review_work',
		    'path' => '/reviewwork',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\Work\ReviewWorkAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'classify_work',
		    'path' => '/classifywork',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\Work\ClassifyWorkAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'new_worktype',
		    'path' => '/newworktype',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\WorkType\NewWorkTypeAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'manage_worktype',
		    'path' => '/manageworktype',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\WorkType\ManageWorkTypeAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'attributes_worktype',
		    'path' => '/attributesworktype',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\WorkType\AttributesWorkTypeAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'new_classification',
		    'path' => '/newclassification',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\Classification\NewClassificationAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'manage_classification',
		    'path' => '/manageclassification',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\Classification\ManageClassificationAction::class,
            ],
            'allowed_methods' => ['GET', 'POST'],
        ],
		
		[
            'name' => 'merge_classification',
		    'path' => '/mergeclassification',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\Classification\MergeClassificationAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'exportlist_classification',
		    'path' => '/exportlistclassification',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\Classification\ExportListClassificationAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'new_agent',
		    'path' => '/newagent',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\Agent\NewAgentAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'find_agent',
		    'path' => '/findagent',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\Agent\FindAgentAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'manage_agent',
		    'path' => '/manageagent',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\Agent\ManageAgentAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'merge_agent',
		    'path' => '/mergeagent',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\Agent\MergeAgentAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'new_agenttype',
		    'path' => '/newagenttype',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\AgentType\NewAgentTypeAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'manage_agenttype',
		    'path' => '/manageagenttype',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\AgentType\ManageAgentTypeAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'new_publisher',
		    'path' => '/newpublisher',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\Publisher\NewPublisherAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'find_publisher',
		    'path' => '/findpublisher',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\Publisher\FindPublisherAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'manage_publisher',
		    'path' => '/managepublisher[/page/{page}]',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\Publisher\ManagePublisherAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
        
		[
            'name' => 'manage_PublisherLocation',
		    'path' => '/manage_publisherlocation',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\Publisher\ManagePublisherLocationAction::class,
            ],                
            'allowed_methods' => ['GET','POST'],
        ],
        
		[
            'name' => 'merge_publisher',
		    'path' => '/mergepublisher',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\Publisher\MergePublisherAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'new_language',
		    'path' => '/new_language',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\Language\NewLanguageAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'manage_language',
		    'path' => '/manage_language[/page/{page}]',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\Language\ManageLanguageAction::class,
            ],                
            'allowed_methods' => ['GET','POST'],
        ],
        
        [
            'name' => 'edit_language',
		    'path' => '/edit_language',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\Language\EditLanguageAction::class,
            ],                
            'allowed_methods' => ['GET','POST'],
        ],
        
		[
            'name' => 'delete_language',
		    'path' => '/delete_language',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\Language\DeleteLanguageAction::class,
            ],                
            'allowed_methods' => ['GET','POST'],
        ],
        
		[
            'name' => 'new_users',
		    'path' => '/newusers',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\Users\NewUsersAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'manage_users',
		    'path' => '/manageusers',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\Users\ManageUsersAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'access_users',
		    'path' => '/accessusers',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\Users\AccessUsersAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'changepassword_preferences',
		    'path' => '/changepasswordpreferences',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\Preferences\ChangePasswordPreferencesAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
    ],
];
