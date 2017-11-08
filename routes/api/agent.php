<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
 */
$api = app('Dingo\Api\Routing\Router');

// v2 version API
// add in header    Accept:application/vnd.lumen.v1+json
$api->version('agent', [
    'namespace' => 'App\Http\Controllers\Api\Agent',
    'middleware' => [
        'cors',
        //'api.throttle'
    ],
    // each route have a limit of 100 of 1 minutes
    //'limit' => 100, 'expires' => 1
], function ($api) {

    // Auth
    // login
    $api->post('authorizations', [
        'as' => 'authorizations.store',
        'uses' => 'AuthController@store',
    ]);

    // User
    $api->post('agent', [
        'as' => 'agent.store',
        'uses' => 'AgentController@store',
    ]);

    // user list
    $api->get('users', [
        'as' => 'users.index',
        'uses' => 'UserController@index',
    ]);
    // user detail
    $api->get('users/{id}', [
        'as' => 'users.show',
        'uses' => 'UserController@show',
    ]);

    $api->get('agents', [
        'as' => 'agents.get',
        'uses' => 'AgentController@index'
    ]);

    // need authentication
    $api->group(['middleware' => 'api.auth'], function ($api) {
        // USER
        // my detail
        $api->get('user', [
            'as' => 'user.show',
            'uses' => 'UserController@userShow',
        ]);

    });


});
