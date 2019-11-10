<?php
namespace App\Files\Exceptions;

class FileException extends \Exception
{
    const ERROR_FILE_NOT_EXISTING = 'File not existing. Please check file location';
    const ERROR_FAILED_TO_OPEN_FILE = 'Failed to open file. Please check file location or permission';
}
