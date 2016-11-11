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
			App\Action\MyPageAction::class => App\Action\MyPageFactory::class,
			App\Action\NewWorkAction::class => App\Action\NewWorkFactory::class,
			App\Action\SearchWorkAction::class => App\Action\SearchWorkFactory::class,
			App\Action\ManageWorkAction::class => App\Action\ManageWorkFactory::class,
			App\Action\ReviewWorkAction::class => App\Action\ReviewWorkFactory::class,
			App\Action\ClassifyWorkAction::class => App\Action\ClassifyWorkFactory::class,
			App\Action\NewWorkTypeAction::class => App\Action\NewWorkTypeFactory::class,
			App\Action\ManageWorkTypeAction::class => App\Action\ManageWorkTypeFactory::class,
			App\Action\AttributesWorkTypeAction::class => App\Action\AttributesWorkTypeFactory::class,
			App\Action\NewClassificationAction::class => App\Action\NewClassificationFactory::class,
			App\Action\ManageClassificationAction::class => App\Action\ManageClassificationFactory::class,
			App\Action\MergeClassificationAction::class => App\Action\MergeClassificationFactory::class,
			App\Action\ExportListClassificationAction::class => App\Action\ExportListClassificationFactory::class,
			App\Action\NewAgentAction::class => App\Action\NewAgentFactory::class,
			App\Action\FindAgentAction::class => App\Action\FindAgentFactory::class,
			App\Action\ManageAgentAction::class => App\Action\ManageAgentFactory::class,
			App\Action\MergeAgentAction::class => App\Action\MergeAgentFactory::class,
			App\Action\NewAgentTypeAction::class => App\Action\NewAgentTypeFactory::class,
			App\Action\ManageAgentTypeAction::class => App\Action\ManageAgentTypeFactory::class,
			App\Action\NewPublisherAction::class => App\Action\NewPublisherFactory::class,
			App\Action\FindPublisherAction::class => App\Action\FindPublisherFactory::class,
			App\Action\ManagePublisherAction::class => App\Action\ManagePublisherFactory::class,
			App\Action\MergePublisherAction::class => App\Action\MergePublisherFactory::class,
			App\Action\NewLanguageAction::class => App\Action\NewLanguageFactory::class,
			App\Action\ManageLanguageAction::class => App\Action\ManageLanguageFactory::class,
            App\Action\EditLanguageAction::class => App\Action\EditLanguageFactory::class,
            App\Action\DeleteLanguageAction::class => App\Action\DeleteLanguageFactory::class,
			App\Action\NewUsersAction::class => App\Action\NewUsersFactory::class,
			App\Action\ManageUsersAction::class => App\Action\ManageUsersFactory::class,
			App\Action\AccessUsersAction::class => App\Action\AccessUsersFactory::class,
			App\Action\ChangePasswordPreferencesAction::class => App\Action\ChangePasswordPreferencesFactory::class,
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
            'name' => 'my-page',
            'path' => '/mypage',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\MyPageAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
        [
           'name' => 'new_work',
		  // 'name' => 'my-page',
		    'path' => '/newwork',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\NewWorkAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],

        [
            'name' => 'search_work',
		    'path' => '/searchwork',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\SearchWorkAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'manage_work',
		    'path' => '/managework',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\ManageWorkAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'review_work',
		    'path' => '/reviewwork',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\ReviewWorkAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'classify_work',
		    'path' => '/classifywork',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\ClassifyWorkAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'new_worktype',
		    'path' => '/newworktype',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\NewWorkTypeAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'manage_worktype',
		    'path' => '/manageworktype',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\ManageWorkTypeAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'attributes_worktype',
		    'path' => '/attributesworktype',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\AttributesWorkTypeAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'new_classification',
		    'path' => '/newclassification',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\NewClassificationAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'manage_classification',
		    'path' => '/manageclassification',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\ManageClassificationAction::class,
            ],
            'allowed_methods' => ['GET', 'POST'],
        ],
		
		[
            'name' => 'merge_classification',
		    'path' => '/mergeclassification',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\MergeClassificationAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'exportlist_classification',
		    'path' => '/exportlistclassification',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\ExportListClassificationAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'new_agent',
		    'path' => '/newagent',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\NewAgentAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'find_agent',
		    'path' => '/findagent',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\FindAgentAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'manage_agent',
		    'path' => '/manageagent',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\ManageAgentAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'merge_agent',
		    'path' => '/mergeagent',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\MergeAgentAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'new_agenttype',
		    'path' => '/newagenttype',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\NewAgentTypeAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'manage_agenttype',
		    'path' => '/manageagenttype',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\ManageAgentTypeAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'new_publisher',
		    'path' => '/newpublisher',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\NewPublisherAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'find_publisher',
		    'path' => '/findpublisher',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\FindPublisherAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'manage_publisher',
		    'path' => '/managepublisher',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\ManagePublisherAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'merge_publisher',
		    'path' => '/mergepublisher',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\MergePublisherAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'new_language',
		    'path' => '/new_language',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\NewLanguageAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'manage_language',
		    'path' => '/manage_language[/page/{page}]',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\ManageLanguageAction::class,
            ],                
            'allowed_methods' => ['GET','POST'],
        ],
        
        [
            'name' => 'edit_language',
		    'path' => '/edit_language',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\EditLanguageAction::class,
            ],                
            'allowed_methods' => ['GET','POST'],
        ],
        
		[
            'name' => 'delete_language',
		    'path' => '/delete_language',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\DeleteLanguageAction::class,
            ],                
            'allowed_methods' => ['GET','POST'],
        ],
        
		[
            'name' => 'new_users',
		    'path' => '/newusers',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\NewUsersAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'manage_users',
		    'path' => '/manageusers',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\ManageUsersAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'access_users',
		    'path' => '/accessusers',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\AccessUsersAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
		
		[
            'name' => 'changepassword_preferences',
		    'path' => '/changepasswordpreferences',
            'middleware' => [
                BodyParamsMiddleware::class,
                App\Action\ChangePasswordPreferencesAction::class,
            ],
            'allowed_methods' => ['GET','POST'],
        ],
    ],
];
