<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Files\export\PresentationLayer;
use App\Files\imports\BulkUserCSV;

/**
 * Class BulkUserImporterController
 * @package App\Controller
 */
class BulkUserImporterController extends AppController
{
    /**
     * Index method
     *
     * @return void
     * @throws \App\Files\Exceptions\CSVException
     * @throws \App\Files\Exceptions\FileException
     */
    public function index()
    {
        $uploadData = '';

        // Perform the following after the file has been uploaded (post)
        if ($this->request->is('post')) {
            // get the file from the request data.
            $file = $this->request->getData(['file']);

            // Make sure that we have a file
            if (empty($file['name']) === false) {
                try {
                    // Gets the file from the request input and creates CSV object.
                    $bulkUserCsv = new BulkUserCSV($file['tmp_name']);

                    // Loads the CSV with data.
                    $bulkUserCsv->load();

                    // Processes the business logic validation.
                    if ($bulkUserCsv->processCSV() === false) {
                        $this->Flash->error('Failed to process CSV');

                        return;
                    }

                    // A collection of invalid rows.
                    $invalidRows = $bulkUserCsv->getInvalidRows();

                    // A collection of valid rows.
                    $validRows = $bulkUserCsv->getValidRows();

                    // Successful record count.
                    $successfulRecordCount = $bulkUserCsv->getSuccessfulRowCount();

                    // Exports the invalid results to json file (src/Files/export/Files/invalidRows.json)
                    $outputResults = new PresentationLayer();
                    $outputResults->exportToJsonFile($invalidRows);
                    $invalidRows = $outputResults->getJsonResult();

                    // Exports the successful results to json file (src/Files/export/Files/validRows.json)
                    $options['outputfileName'] = '\validRows.json';
                    $outputResults = new PresentationLayer($options);
                    $outputResults->exportToJsonFile($validRows);
                    $validRows = $outputResults->getJsonResult();
                } catch (\Exception $exception) {
                    $this->Flash->error('There was an error uploading the file');
                }

                $this->set('successfulRecordCount', $successfulRecordCount);
                $this->set('invalidRows', $invalidRows);
                $this->set('validRows', $validRows);

                $this->Flash->success('The upload was successful');
            }
        }
        $this->set('uploadData', $uploadData);
    }
}
