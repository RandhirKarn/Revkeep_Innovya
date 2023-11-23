<?php

namespace App\Controller\Client;

use App\Model\Table\IncomingDocumentsTable;
use App\Controller\AppController;
use TCPDF; // Import the TCPDF library 

class PatientParsedInfoController extends AppController
{
    public function index()
    {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $docName = $data['data'];

             // Read data from a JSON file
             $jsonFile = '../storage/'.$docName.'.json'; // Replace with your file path
             $jsonData = file_get_contents($jsonFile);
             
             // Check if JSON data was successfully retrieved
             if ($jsonData !== false) {
                 // Set the response type as JSON
                 $this->response = $this->response->withType('application/json');
                 
                 // Set the JSON data as the response body
                 $this->response = $this->response->withStringBody($jsonData);
             } else {
                 // Handle error if JSON data couldn't be retrieved
                 $this->response = $this->response->withStatus(500); // Internal Server Error
                 $this->response = $this->response->withStringBody('Error reading JSON file');
             }
             
             return $this->response;

        }
    }
}