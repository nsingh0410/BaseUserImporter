<?php
namespace App\Test\TestCase\Files\imports;

use App\Files\imports\BulkUserCSV;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Files\Csv Test Case
 *
 * @uses \App\Test\TestCase\Files\imports\BulkUserCSVTest
 */
class BulkUserCSVTest extends TestCase
{
    use IntegrationTestTrait;
    protected $sampleFile = __DIR__ . '\..\..\sample\tech_test_sample.csv';

    public function testProcess()
    {
        $csvFile = new BulkUserCSV($this->sampleFile);
        $csvFile->processCSV();
        $this->assertEquals($csvFile->getSuccessfulRowCount(), 1);
        $validRows = $csvFile->getValidRows();
        $firstRecord = $validRows[0];

        $this->assertSame($firstRecord['email'], 'testvalidemail@test.com');
        $this->assertSame($firstRecord['first_name'], 'Fname');
        $this->assertSame($firstRecord['last_name'], 'Lname');
        $this->assertSame($firstRecord['password'], 'passwordvalid');
        $this->assertSame($firstRecord['platforms'], 'ios');
        $this->assertSame($firstRecord['additional_field'], 'addField');
    }
}
