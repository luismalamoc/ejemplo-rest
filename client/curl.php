<?php

    // url of API
    $url = 'http://localhost/api/helpers';

    //default method
    $method = 'GET';
         
    // headers and data (this is API dependent, some uses XML)
    $headers = array(
        'Accept: application/json',
        'Content-Type: application/json',
    );

    $resource_id = '/1';
     
    $handle = curl_init();    
     
    switch($method) 
    {
        case 'GET':
        break;

        case 'POST':
            // prepare the body data. Example is JSON here
            $data = json_encode(array(
                'name' => 'Bruce',
                'lastname' => 'Wayne',
                'email' => 'brucewayne@mail.com',
                'message' => 'I am from Gotham',
            ));
            curl_setopt($handle, CURLOPT_POST, true);
            curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
        break;

        case 'PUT':
            $url .= $resource_id;
            // prepare the body data. Example is JSON here
            $data = json_encode(array(
                'name' => 'Bruno',
                'lastname' => 'Diaz',
                'email' => 'brunodiaz@mail.com',
                'message' => 'Yo provengo de Gotica',
            ));  
            curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
        break;

        case 'DELETE':
            $url .= $resource_id;
            curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'DELETE');
        break;
    }

    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
     
    $response = curl_exec($handle);
    echo $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);