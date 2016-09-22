<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::group(['middleware' => ['web']], function () {
    
    Route::auth();
    
    // Route the retorna a raiz (Home Page)
    
    Route::get('/', function () {
        return view('home');
    });
    
    /**********************************************
    Route especifico para lista de utilizadores
    **********************************************/
    Route::get('{id_user}/administration/', ['uses' =>'UsersController@index']);
    
    /******************************************************************************* 
    Routes especificos para  metodos "storeline" do controlador "LineController"
    ********************************************************************************/
    Route::post('storeline', ['uses' =>'LineController@storeline']);
    
    /******************************************************************************* 
    Routes especificos para maioria de metodos do controlador "ProjectController"
    ********************************************************************************/
    Route::get('/about/', ['uses' =>'ProjectController@aboutPage']);
    Route::get('{id_user}/project/', ['middleware' => 'auth','uses' =>'ProjectController@index']);
    Route::get('{id_user}/project/create', ['uses' =>'ProjectController@create']);
    Route::get('{id_user}/project/{id}/show', ['uses' =>'ProjectController@show']);
    Route::get('{id_user}/project/{id}/edit', ['uses' =>'ProjectController@edit']);
    
    /******************************************************************************* 
    Routes especificos para maioria de metodos do controlador "MaterialController"
    ********************************************************************************/
    Route::get('{id_user}/project/{id_project}/experience/{id_experience}/material', ['uses' =>'MaterialController@index']);
    Route::get('{id_user}/project/{id_project}/experience/{id_experience}/material/create', ['uses' =>'MaterialController@create']);
    Route::get('{id_user}/project/{id_project}/experience/{id_experience}/material/{id_material}/show', ['uses' =>'MaterialController@show']);
    Route::get('{id_user}/project/{id_project}/experience/{id_experience}/material/{id_material}/edit', ['uses' =>'MaterialController@edit']);
    
    /******************************************************************************* 
    Routes especificos para maioria de metodos do controlador "MaterialController"
    ********************************************************************************/
    Route::get('{id_user}/project/{id_project}/experience', ['middleware' => 'auth', 'uses' =>'ExperienceController@index']);
    Route::get('{id_user}/project/{id_project}/experience/create', ['uses' =>'ExperienceController@create']);
    Route::get('{id_user}/project/{id_project}/experience/{id_experience}/show', ['uses' =>'ExperienceController@show']);
    Route::get('{id_user}/project/{id_project}/experience/{id_experience}/edit', ['uses' =>'ExperienceController@edit']);
    Route::get('{id_user}/project/{id_project}/experience/{id_experience}/upload', ['uses' =>'ExperienceController@submitImage']);
    Route::post('apply/upload', ['uses' =>'ExperienceController@upload']);
    Route::get('{id_user}/project/{id_project}/experience/{id_experience}/getscale', ['uses' =>'ExperienceController@getscale']);
    Route::get('{id_user}/project/{id_project}/experience/{id_experience}/getworkspace', ['uses' =>'ExperienceController@getworkspace']);
    Route::get('{id_user}/project/{id_project}/experience/{id_experience}/workspace', ['uses' =>'ExperienceController@workspace']);
    Route::get('{id_user}/project/{id_project}/experience/{id_experience}/experience_information', ['uses' =>'ExperienceController@experience_information']);
    Route::get('{id_user}/project/{id_project}/experience/{id_experience}/getExcel', ['uses' =>'ExperienceController@getExcel']);
    
    /*************************************************************************************************** 
    Routes Genericos para alguns metodos de todos os controladores tal como "Store","Update" e "Destroy"
    ****************************************************************************************************/
    Route::resource('project', 'ProjectController');
    Route::resource('experience', 'ExperienceController');
    Route::resource('material', 'MaterialController');
    Route::resource('line', 'LineController');
    Route::resource('point', 'PointController');
    Route::resource('segment', 'SegmentController');
    Route::resource('users', 'UsersController');
    
});
