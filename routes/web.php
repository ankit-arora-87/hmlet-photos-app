<?php
use Illuminate\Support\Str;

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/key', function() {
    return Str::random(64);
});

// API route group - Guest
$router->group(['prefix' => 'api'], function () use ($router) {
    // Matches "/api/register
    $router->post('register', 'AuthController@register');
    // Matches "/api/login
    $router->post('login', 'AuthController@login');
    // Matches "/api/photos
    $router->get('photos', 'PhotoController@getAllPhotos');
    // Matches "/api/photos/1
    $router->get('photos/detail/{id}', 'PhotoController@photoDetail');
    // Matches "/api/users/1 - get one user by id
    $router->get('users/profile/{id}', 'UserController@singleUser');
    // Matches "/api/users
    $router->get('users', 'UserController@allUsers');
});

// API route group - Authenticated
$router->group(['prefix' => 'api', 'middleware' => 'auth'], function () use ($router) {
    // Matches "/api/profile
    $router->get('profile', 'UserController@profile');
    // Matches "/api/photos
    $router->post('photos', 'PhotoController@savePhoto');    
    // Matches "/api/photos/self 
    $router->get('photos/self', 'PhotoController@getMyPhotos');
    // Matches "/api/photos/self 
    $router->get('photos/self/drafts', 'PhotoController@getMyDrafts');
    // Matches "/api/photos/upload
    $router->post('photos/upload', 'PhotoController@uploadPhoto');
    // Matches "/api/photos/update-caption
    $router->post('photos/update-caption', 'PhotoController@updatePhotoCaption');
    // Matches "/api/photos/1
    $router->patch('photos/publish', 'PhotoController@publishPhoto');
    // Matches "/api/photos/1
    $router->delete('photos', 'PhotoController@deletePhoto');
});
