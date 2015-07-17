<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Base Controller
	|--------------------------------------------------------------------------
	|
	| This controller will be used as a base controller of all controllers
	|
	*/

	'base_controller'          => 'Mitul\Controller\AppBaseController',


	/*
	|--------------------------------------------------------------------------
	| Path for classes
	|--------------------------------------------------------------------------
	|
	| All Classes will be created on these relevant path
	|
	*/

	'path_migration'           => base_path('database/migrations/'),

	'path_model'               => base_path('app/Models/'),

	'path_repository'          => base_path('app/Libraries/Repositories/'),

	'path_repository_interface'          => base_path('app/Libraries/Repositories/'),

	'path_controller'          => base_path('app/Http/Controllers/'),

	'path_api_controller'      => base_path('app/Http/Controllers/API/'),

	'path_views'               => base_path('resources/views/'),

	'path_request'             => base_path('app/Http/Requests/'),

	'path_routes'              => base_path('app/Http/routes.php'),

	'path_api_routes'          => base_path('app/Http/api_routes.php'),


	/*
	|--------------------------------------------------------------------------
	| Namespace for classes
	|--------------------------------------------------------------------------
	|
	| All Classes will be created with these namespaces
	|
	*/

	'namespace_model'          => 'App\Models',

	'namespace_repository'     => 'App\Libraries\Repositories',

	'namespace_repository_interface'     => 'App\Libraries\Repositories',

	'namespace_controller'     => 'App\Http\Controllers',

	'namespace_api_controller' => 'App\Http\Controllers\API',

	'namespace_request'        => 'App\Http\Requests',


	/*
	|--------------------------------------------------------------------------
	| Model extend
	|--------------------------------------------------------------------------
	|
	| Model extend Configuration.
	| By default Eloquent model will be used.
	| If you want to extend your own custom model then you can specify "model_extend" => true and "model_extend_namespace" & "model_extend_class".
	|
	| e.g.
	| 'model_extend' => true,
	| 'model_extend_namespace' => 'App\Models\AppBaseModel as AppBaseModel',
	| 'model_extend_class' => 'AppBaseModel',
	|
	*/

	'model_extend_class'   => 'Illuminate\Database\Eloquent\Model',

	/*
	|--------------------------------------------------------------------------
	| API routes prefix
	|--------------------------------------------------------------------------
	|
	| By default "api" will be prefix
	|
	*/

	'api_prefix'               => 'api',

	'api_version'              => 'v1',

	/*
	|--------------------------------------------------------------------------
	| dingo API integration
	|--------------------------------------------------------------------------
	|
	| By default dingo API Integration will not be enabled. Dingo API is in beta.
	|
	*/

	'use_dingo_api'            => false,

	'tab'                      => '    ',
];
