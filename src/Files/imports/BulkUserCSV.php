<?php

namespace App\Files\imports;

use App\Files\CSV;

class BulkUserCSV extends CSV
{
    protected $file;
    protected $rows;
    protected $requiredPlatforms = ['ios', 'windows', 'web', 'android'];
    protected $validRows = [];
    protected $invalidRows = [];
    protected $count = 0;

    /**
     * BulkUserCsv constructor.
     *
     * @param string $file file location
     * @param array|null $data data
     * @param array $header headers
     */
    public function __construct($file, array $data = null, $header = [])
    {
        parent::__construct($file, $data, $header);
        $this->file = $file;
    }

    /**
     *  Read csv and validates csv data
     *
     * @return bool
     * @throws \App\Files\Exceptions\CSVException
     */
    public function processCSV()
    {
        // loads all the data into the CSV object
        $this->load();

        // Validates the inputs and builds a collection of the correct/incorrect records.
        return $this->validateData();
    }

    /**
     * Validates the csv data.
     * @return bool
     */
    public function validateData()
    {
        try {
            $this->rows = $this->getData();
            $rows = $this->rows;
            $this->getHeader();

            foreach ($rows as $rowData) {
                $fieldErrors = [];

                if (empty($rowData['first_name']) === true || ctype_alpha($rowData['first_name']) === false) {
                    $fieldErrors[] = $rowData['first_name'];
                }

                if (empty($rowData['last_name']) === true || ctype_alpha($rowData['last_name']) === false) {
                    $fieldErrors[] = $rowData['last_name'];
                }
                if (empty($rowData['email']) === true || !filter_var($rowData['email'], FILTER_VALIDATE_EMAIL)) {
                    $fieldErrors[] = $rowData['email'];
                }

                if (empty($rowData['password']) === true || strlen($rowData['password']) < 8) {
                    $fieldErrors[] = $rowData['password'];
                }

                if (empty($rowData['platforms']) === true) {
                    $fieldErrors[] = $rowData['platforms'];
                } else {
                    // divide the platforms in the csv by the (,) Delimiter and check if there are any
                    // errors in the platform.
                    $platformsArray = explode(',', $rowData['platforms']);
                    foreach ($platformsArray as $platform) {
                        if (!in_array(trim($platform), $this->requiredPlatforms)) {
                            $fieldErrors[] = $rowData['platforms'];
                        }
                    }
                }

                // if there are no field errors, we regard as valid otherwise invalid.
                if (empty($fieldErrors) === true) {
                    $this->validRows[] = $rowData;
                } else {
                    $this->invalidRows[] = $rowData;
                }
            }// end rows
        } catch (\Exception $exception) {
            return false;
        }

        return true;
    }

    /**
     * All Invalid rows.
     * @return array
     */
    public function getInvalidRows(): array
    {
        return $this->invalidRows;
    }

    /**
     * All valid rows.
     * @return array
     */
    public function getValidRows(): array
    {
        return $this->validRows;
    }

    /**
     * Get successful record count.
     * @return array
     */
    public function getSuccessfulRowCount(): int
    {
        $validRows = $this->getValidRows();
        if (empty($validRows) === false) {
            $this->count = count($validRows);
        }

        return $this->count;
    }
}
