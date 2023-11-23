<?php
 
namespace App\Controller\Client;
 
use App\Model\Table\IncomingDocumentsTable;
use App\Controller\AppController;
use TCPDF;
class ParserPostRequestController extends AppController
{
    public function index()
    {
        $this->autoRender = false;
        if ($this->request->is('post')) {
 
            $data = $this->request->getData();
            $docName = $data['docName'];
            $fileName = $data['fileName'];
            $originalNameBase = $data['originalNameBase'];
            $originalNameExtension = $data['originalNameExtension'];
       
        $file_path = "../storage/incoming-documents/$fileName";
 
       
        $url = 'https://api.edination.com/v2/x12/read';
 
       
        $api_key = '3ecf6b1c5cf34bd797a5f4c57951a1cf';
        $headers = [
            'http' => [
                'header' => "Ocp-Apim-Subscription-Key: $api_key",
                'method' => 'POST',
                'content' => file_get_contents($file_path),
            ],
        ];
        $context = stream_context_create($headers);
        $response = file_get_contents($url, false, $context);
 
        if ($response === FALSE) {
            echo 'Error reading the file or making the request';
        } else {
            $json_data = json_decode($response, true);
           
            $output_file_path = "../storage/$originalNameBase.json";
 
            file_put_contents($output_file_path, json_encode($json_data, JSON_PRETTY_PRINT));
 
            echo json_encode($json_data, JSON_PRETTY_PRINT);
            $iteration = 1; // Initialize iteration counter
              // echo json_encode($json_data, JSON_PRETTY_PRINT);
                 foreach ($json_data[0]['Groups'][0]['Transactions'][0]['Loop2000'][0]['Loop2100'] as $item) {
                    // $pdf = new TCPDF(); // Create a new TCPDF instance for each iteration
                    // $pdf->AddPage(); // Add a new page for each iteration
                    // $pdf->SetFont('Arial', 'B', 12);
                    // // Customize how you want to format the data into the PDF
                    // $pdf->Cell(0, 10, 'Hello World');
                    // $pdf->writeHTML('<h1>' . print_r($item['AllNM1'], true) . '</h1>');
   
                    // Output PDF to a file
                    //$pdf_file_name = "$iteration.pdf";
                    //$pdf_file_path = "../storage/"; // Define PDF file path
                    // $pdf->Output('test.pdf', 'F'); // Save PDF to the specified file path
                    $fileName=$item['AllN1'].$iteration;
                    $output_file_path = "../storage/$fileName.json";
 
                    file_put_contents($output_file_path, json_encode($item, JSON_PRETTY_PRINT));
                    // Echo or return information about the generated PDF
                   
                   $iteration++; // Increment iteration counter
               }
        }
    }
    else{
        echo("Some Problem Occured.");
        }
    }
}
 