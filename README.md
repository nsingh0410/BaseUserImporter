
## Installation Instructions

1. git clone the repository.
2. Make sure that you have all the requirements to run cakephp.
```
https://book.cakephp.org/3/en/installation.html
```
2. run `composer install`.
3. make sure that you have write access for cake
```
chmod +x bin/cake
```
4. run webserver (you can use cakephps one)
```bash
bin/cake server -p 8765
```

Then visit `http://localhost:8765` to see the bulk user importer page.

## Unit Tests

1. you can run all the unit tests by using the following command in the current directory.
I wrote the following unit tests.

```bash
tests/TestCase/Files/CsvTest.php
tests/TestCase/Files/export/PresentationLayerTest.php
tests/TestCase/Files/imports/BulkUserCSVTest.php
tests/TestCase/Controller/BulkUserImporterControllerTest.php
```

run all tests:
```bash
./vendor/bin/phpunit ./tests/
```

## Codesniffer Standards (uses PSR-2 guidelines)
You can run the following command to see if the code is compliant with PSR-2 standards.
```bash
composer cs-check
```


