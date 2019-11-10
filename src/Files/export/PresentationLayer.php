<?php
namespace App\Files\export;

use App\Files\Exceptions\FileException;

class PresentationLayer
{
    /**
     * @var string $outputFileDir the output file directory.
     */
    private $outputFileDir;
    const INVALID_ROWS_JSON_FILE = '/invalidRows.json';
    /**
     * @var false|string
     */
    private $jsonResult;
    /**
     * @var string
     */
    private $outputFileName;
    /**
     * @var string
     */
    private $fullPath;

    /**
     * PresentationLayer constructor
     * @param array $options A collection of options we can use to override the file path/dir.
     */
    public function __construct(Array $options = [])
    {
        $this->outputFileDir = $options['outputFileDir'] ?? __DIR__ . '/Files';
        $this->outputFileName = $options['outputfileName'] ?? self::INVALID_ROWS_JSON_FILE;
        $this->fullPath = $this->outputFileDir . $this->outputFileName;
    }

    /**
     * Gets and array and exports the results to json file.
     * @param array $data An array of data we want to export.
     * @throws FileException
     * @return string
     */
    public function exportToJsonFile(Array $data)
    {
        $this->jsonResult = '{}';

        // if the file doesn't exist, throw an error.
        if (!file_exists($this->fullPath)) {
            throw new FileException(FileException::ERROR_FILE_NOT_EXISTING . ": " . $this->fullPath);
        }

        // Json encode the data.
        $this->jsonResult = json_encode($data);

        // write to the file.
        if ($this->jsonResult !== false) {
            file_put_contents($this->fullPath, $this->jsonResult);
        }

        return $this->jsonResult;
    }

    /**
     * @return false|string
     */
    public function getJsonResult()
    {
        return $this->jsonResult;
    }
}
