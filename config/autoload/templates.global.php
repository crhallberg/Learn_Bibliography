<?php

return [
    'dependencies' => [
        'factories' => [
            'Zend\Expressive\FinalHandler' =>
                Zend\Expressive\Container\TemplatedErrorHandlerFactory::class,

            Zend\Expressive\Template\TemplateRendererInterface::class =>
                Zend\Expressive\ZendView\ZendViewRendererFactory::class,

            Zend\View\HelperPluginManager::class =>
                Zend\Expressive\ZendView\HelperPluginManagerFactory::class,
        ],
    ],

    'templates' => [
        'layout' => 'layout/default',
        'map' => [
            'layout/default' => 'templates/layout/default.phtml',
            'error/error'    => 'templates/error/error.phtml',
            'error/404'      => 'templates/error/404.phtml',
            //html templates
            //for login
            'app::default' => 'templates/app/default_latest.phtml',
            //'app::login' => 'templates/app/login-page.phtml',
            //work
            'app::work::new_work' => 'templates/app/work/new.phtml',
            'app::work::manage_work' => 'templates/app/work/manage.phtml',
            'app::work::search_work' => 'templates/app/work/search.phtml',
            'app::work::review_work' => 'templates/app/work/review.phtml',
            'app::work::classify_work' => 'templates/app/work/classify.phtml',
            //work type
            'app::worktype::new_worktype' => 'templates/app/worktype/new.phtml',
            'app::worktype::manage_worktype' => 'templates/app/worktype/manage.phtml',
            'app::worktype::attributes_worktype' => 'templates/app/worktype/attributes.phtml',
            //classification
            'app::classification::new_classification' => 'templates/app/classification/new.phtml',
            'app::classification::manage_classification' => 'templates/app/classification/manage.phtml',
            'app::classification::merge_classification' => 'templates/app/classification/merge.phtml',
            'app::classification::exportlist_classification' => 'templates/app/classification/exportlist.phtml',
            //agent
            'app::agent::new_agent' => 'templates/app/agent/new.phtml',
            'app::agent::find_agent' => 'templates/app/agent/find.phtml',
            'app::agent::manage_agent' => 'templates/app/agent/manage.phtml',
            'app::agent::edit_agent' => 'templates/app/agent/edit.phtml',
            'app::agent::delete_agent' => 'templates/app/agent/delete.phtml',
            'app::agent::merge_agent' => 'templates/app/agent/merge.phtml',
            //agent type
            'app::agenttype::new_agenttype' => 'templates/app/agenttype/new.phtml',
            'app::agenttype::manage_agenttype' => 'templates/app/agenttype/manage.phtml',
            'app::agenttype::edit_agenttype' => 'templates/app/agenttype/edit.phtml',
            'app::agenttype::delete_agenttype' => 'templates/app/agenttype/delete.phtml',     
             //publisher
            'app::publisher::new_publisher' => 'templates/app/publisher/new.phtml',
            'app::publisher::manage_publisher' => 'templates/app/publisher/manage.phtml',
            'app::publisher::edit_publisher' => 'templates/app/publisher/edit.phtml',
            'app::publisher::delete_publisher' => 'templates/app/publisher/delete.phtml',
            'app::publisher::find_publisher' => 'templates/app/publisher/find.phtml',
            'app::publisher::add_publisher_location' => 'templates/app/publisher/new_location.phtml',
            'app::publisher::delete_publisher_location' => 'templates/app/publisher/delete_location.phtml',
            'app::publisher::manage_publisherlocation' => 'templates/app/publisher/manage_location.phtml',
            'app::publisher::merge_publisher' => 'templates/app/publisher/merge.phtml',
            //language
            'app::language::new_language' => 'templates/app/language/new.phtml',
            'app::language::manage_language' => 'templates/app/language/manage.phtml',
            'app::language::edit_language' => 'templates/app/language/edit.phtml',
            'app::language::delete_language' => 'templates/app/language/delete.phtml',           
            //users
            'app::users::new_users' => 'templates/app/users/new.phtml',
            'app::users::manage_users' => 'templates/app/users/manage.phtml',
            'app::users::access_users' => 'templates/app/users/access.phtml',
            //preferences
            'app::preferences::changepassword_preferences' => 'templates/app/preferences/changepassword.phtml',
        ],
        'paths' => [
            'app'    => ['templates/app'],
            'layout' => ['templates/layout'],
            'error'  => ['templates/error'],
        ],
    ],

    'view_helpers' => [
        //new
        'invokables' => [
            Zend\View\Helper\BasePath::class => Blast\BaseUrl\BasePathViewHelperFactory::class,
        ],
        'factories' => [
            Zend\View\Helper\ViewModel::class => App\View\Helper\ViewModelFactory::class,
        ],
        // zend-servicemanager-style configuration for adding view helpers:
        // - 'aliases'
        // - 'invokables'
        // - 'factories'
        // - 'abstract_factories'
        // - etc.
    ],
];
