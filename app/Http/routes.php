<?php



/*

|--------------------------------------------------------------------------

| Routes File

|--------------------------------------------------------------------------

|

| Here is where you will register all of the routes in an application.

| It's a breeze. Simply tell Laravel the URIs it should respond to

| and give it the controller to call when that URI is requested.

|

*/



Route::get('/', function () {                

    return view('welcome');

});



Route::get('registro', function () {                

    return view('form');

});



Route::get('descarga', function () {                

    return view('descarga');

});



Route::get('carnet_prueba', function () {                

    return view('carnet');

});



Route::get('login', function () {                

    return view('login');

});



Route::get('cerrar', function () {      

	session_start();

	session_destroy();

    return redirect('/');

});





Route::any('logear','FormController@logear');



Route::any('ultimo_codigo','FormController@last_codigo');



Route::any('carnet','PdfController@carnet');



Route::post('insertar', 'FormController@insertar');



Route::any('listar_pais', 'FormController@listar_pais');



Route::any('listar_ciudad', 'FormController@listar_ciudad');



Route::any('listar_localidad', 'FormController@listar_localidad');



Route::any('listar_departamento', 'FormController@listar_departamento');



Route::any('listar_datos', 'FormController@listar_datos');



Route::get('/personas/service/ciudad/{id_pais}', '\Idrd\Usuarios\Controllers\LocalizacionController@buscarCiudades');



Route::post('/personas/service/procesar/', '\Idrd\Usuarios\Controllers\PersonaController@procesar');



/*

|--------------------------------------------------------------------------

| Application Routes

|--------------------------------------------------------------------------

|

| This route group applies the "web" middleware group to every route

| it contains. The "web" middleware group is defined in your HTTP

| kernel and includes session state, CSRF protection, and more.

|

*/



Route::group(['middleware' => ['web']], function () {

    //

});

