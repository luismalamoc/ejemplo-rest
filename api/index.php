<?php

// required dependencies
require 'vendor/autoload.php';
require 'RedBean/rb.php';

// exception for the resources
class ResourceNotFoundException extends Exception { }

// database connection data
$db_host = 'localhost';
$db_name = 'demo';
$db_user = 'user';
$db_password = '12345678';

// set up database connection
R::setup("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
R::freeze(true);

// configuration of framework
$app = new \Slim\Slim(array(
    'debug' => true
));

// set default conditions for route parameters
\Slim\Route::setDefaultConditions(array(
	'id' => '[0-9]{1,}',
));

// handle GET requests for /helpers
$app->get('/helpers', function () use ($app) {

	// query database for all helpers
	$helpers = R::find('helpers');
	// send response header for JSON content type
	$app->response()->header('Content-Type', 'application/json');
	// return JSON-encoded response body with query results
	echo json_encode(R::exportAll($helpers));
});

// handle GET requests for /helpers/:id
$app->get('/helpers/:id', function ($id) use ($app) {
	try 
	{
		// query database for single helper
		$helper = R::findOne('helpers', 'id=?', array($id));
		if($helper) 
		{
			// if found, return JSON response
			$app->response()->header('Content-Type', 'application/json');
			echo json_encode(R::exportAll($helper));
		} 
		else 
		{
			// else throw exception
			throw new ResourceNotFoundException();
		}
	} 
	catch (ResourceNotFoundException $e) 
	{
		// return 404 server error
		$app->response()->status(404);
	} 
	catch (Exception $e) 
	{
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

// handle POST requests to /helpers
$app->post('/helpers', function () use ($app) {
	try 
	{
		// get and decode JSON request body
		$request = $app->request();
		$body = $request->getBody();
		$input = json_decode($body);
		// store helper record
		$helper = R::dispense('helpers');
		$helper->name = (string)$input->name;
		$helper->lastname = (string)$input->lastname;
		$helper->email = (string)$input->email;
		$helper->message = (string)$input->message;
		// when
		$now = date('Y-m-d');
		$helper->created_at = $now;
		$helper->updated_at = $now;
		// save
		$id = R::store($helper);
		// return JSON-encoded response body
		$app->response()->header('Content-Type', 'application/json');
		echo json_encode(R::exportAll($helper));
	} 
	catch (Exception $e) 
	{
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

// handle PUT requests to /helpers/:id
$app->put('/helpers/:id', function ($id) use ($app) {    
  	try 
  	{
	    // get and decode JSON request body
	    $request = $app->request();
	    $body = $request->getBody();
	    $input = json_decode($body); 
	    
	    // query database for single helper
	    $helper = R::findOne('helpers', 'id=?', array($id));  
	    
	    // store modified helper	    
	    if($helper) 
	    {      
	      	$helper->name = (string)$input->name;
			$helper->lastname = (string)$input->lastname;
			$helper->email = (string)$input->email;
			$helper->message = (string)$input->message;
			// when
			$now = date('Y-m-d');		
			$helper->updated_at = $now;
			// update
		    R::store($helper);   
		    // return JSON-encoded response body 
		    $app->response()->header('Content-Type', 'application/json');
		    echo json_encode(R::exportAll($helper));
	    } 
	    else 
	    {
	     	throw new ResourceNotFoundException();    
	    }
  	}
  	catch (ResourceNotFoundException $e) 
  	{
    	$app->response()->status(404);
  	}
  	catch (Exception $e) 
  	{
	    $app->response()->status(400);
	    $app->response()->header('X-Status-Reason', $e->getMessage());
  	}
});

// handle DELETE requests to /helpers/:id
$app->delete('/helpers/:id', function ($id) use ($app) {    
  	try 
  	{
	    // query database for helper
	    $request = $app->request();
	    $helper = R::findOne('helpers', 'id=?', array($id));  
	    
	    // delete helper
	    if($helper) 
	    {
		    R::trash($helper);
		    $app->response()->status(204);
	    } 
	    else 
	    {
	    	throw new ResourceNotFoundException();
	    }
  	} 
  	catch (ResourceNotFoundException $e) 
  	{
    	$app->response()->status(404);
  	} 
  	catch (Exception $e) 
  	{
	    $app->response()->status(400);
	    $app->response()->header('X-Status-Reason', $e->getMessage());
  	}
});

// run
$app->run();