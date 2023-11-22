<?php

namespace App\Controller\Client;

use App\Model\Table\IncomingDocumentsTable;
use App\Controller\AppController;

use Cake\Http\Exception\MethodNotAllowedException;


class ParserPostRequestController extends AppController
{
    public function index()
    {
        if ($this->request->is('post')) {

            // Process the data from the POST request

            $data = $this->request->getData();

            // $ftp_server = $data["host"];
            // $ftp_username = $data["username"];
            // $ftp_password = $data["password"];
            // $download_dir = "/htdocs/";
            // $file_names = ["sample.txt","EDI835combined.pdf", "Sam_Smith.pdf", "Sandy_Doe.pdf"]; // Add more file names as needed
            $docName = $data['docName'];
            $fileName = $data['fileName'];
            $originalNameBase = $data['originalNameBase'];
            $originalNameExtension = $data['originalNameExtension'];
            
            
            return $this->response->withStatus(201)->withType('application/json');
        } else {
           echo("Some Problem Occured.");
        }
    }
}