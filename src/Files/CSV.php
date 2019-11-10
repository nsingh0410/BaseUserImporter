<?php
namespace App\Files;

use App\Files\Exceptions\CSVException;

class CSV
{
    /** @var string */
    protected $file;

    /** @var array */
    protected $header;

    /** @var array data */
    protected $data;

    /**
     * CSV constructor.
     *
     * @param string $file location
     * @param array $data data
     * @param array $header header
     */
    public function __construct($file = null, $data = null, $header = [])
    {
        $this->file = $file;
        $this->data = $data;
        $this->header = $header;
    }

    /**
     * Load data from file to object array
     *
     * @return $this
     * @throws CSVException
     */
    public function load()
    {
        if (!file_exists($this->file)) {
            throw new CSVException(CSVException::ERROR_FILE_NOT_EXISTING . ": " . $this->file);
        }

        $file = fopen($this->file, "r");
        if (!$file) {
            throw new CSVException(CSVException::ERROR_FAILED_TO_OPEN_FILE . ": " . $this->file);
        }

        $data = [];
        try {
            $header = fgetcsv($file);
            $header = $this->convertHeader($header);
            $this->setHeader($header);

            while ($row = fgetcsv($file)) {
                $data[] = array_combine($header, $row);
            }
        } catch (\Exception $exception) {
            throw new CSVException(CSVException::ERROR_FAILED_TO_LOAD_DATA . $exception->getMessage());
        }
        fclose($file);

        $this->data = $data;

        return $this;
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * @param string $file location
     * @return CSV
     */
    public function setFile(string $file): CSV
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data data
     * @return CSV
     */
    public function setData(array $data): CSV
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return array
     */
    public function getHeader(): array
    {
        return $this->header;
    }

    /**
     * @param array $header header
     * @return CSV
     */
    public function setHeader(array $header): CSV
    {
        $this->header = $header;

        return $this;
    }

    /**
     * Returns the headers in new format.
     * @param array $header The CSV header
     * @return array
     */
    public function convertHeader($header = []): array
    {
        $newHeaders = [];
        foreach ($header as $header) {
            $header = strtolower($header);
            $header = str_replace(' ', '_', $header);
            $newHeaders[] = $header;
        }

        return $newHeaders;
    }
}
