
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

## Usage

1. Click the "choose file" button and select a CSV (I haven't made the behaviour force the user to only select CSV files).
You can use the sample file that I use to test located
```bash
tests/TestCase/sample/tech-test-sample.php
```
You will also notice that I have create 2 json files to store Invalid and Valid Rows.



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

## Design Patterns and Principles
I Primary like to think of my controller as the driver.
It uses the logic that is abstracted in other classes to perform operations.
It makes the code much cleaner and easier to test
```bash
/Users/nikhilsingh/Documents/BaseUserImporter/src/Controller/BulkUserImporterController.php
```

Following the single resonsibility principle (One class, One Responsibility),
I wanted to create a CSV class that sole operation was to retrieve and set the CSV object.
(you also will notice lots of getters and setters enabling us to dependancy inject values in the object, easier to write tests).
```bash
/Users/nikhilsingh/Documents/BaseUserImporter/src/Files/CSV.php
```

Business Logic Layer:
I wanted to create a specific class to deal with the buisness layer logic.
This handles all the validation.
```bash
/Users/nikhilsingh/Documents/BaseUserImporter/src/Files/imports/BulkUserCSV.php
```

Presentation Layer:
Created a presentation layer which allows you to split the business logic with the outputted result.
This makes it convenient in the future to output the results in another format.
```bash
/Users/nikhilsingh/Documents/BaseUserImporter/src/Files/imports/BulkUserCSV.php
```


