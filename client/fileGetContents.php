<?php

// url of API
$url = 'http://localhost/api/helpers';

//default method
$method = 'GET';

$data = null;

$resource_id = '/1';

if($method == 'POST')
{
    // prepare the body data. Example is JSON here
    $data = json_encode(array(
        'name' => 'Bruce',
        'lastname' => 'Wayne',
        'email' => 'brucewayne@mail.com',
        'message' => 'I am from Gotham',
    ));  
}
elseif($method == 'PUT')
{
    $url .= $resource_id;
    // prepare the body data. Example is JSON here
    $data = json_encode(array(
        'name' => 'Bruno',
        'lastname' => 'Diaz',
        'email' => 'brunodiaz@mail.com',
        'message' => 'Yo provengo de Gotica',
    ));  
}
elseif($method == 'DELETE')
{    
    $url .= $resource_id;
}

// set up the request context
$options = ["http" => [
    "method" => $method,
    "header" => ["Content-Type: application/json"],
    "content" => $data
]];
$context = stream_context_create($options);
 
// make the request and show
echo $response = file_get_contents($url, false, $context);

