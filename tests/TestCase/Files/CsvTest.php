<?php
namespace App\Test\TestCase\Files;

use App\Files\CSV;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Files\Csv Test Case
 *
 * @uses \App\Files\CSV
 */
class CsvTest extends TestCase
{
    use IntegrationTestTrait;
    protected $sampleFile = __DIR__ . '\..\sample\tech_test_sample.csv';

    public function testLoad()
    {
        $csvFile = new CSV($this->sampleFile);
        $csvFile->load();
        $data = $csvFile->getData();

        $firstRecord = $data[0];
        $this->assertSame($firstRecord['email'], 'testvalidemail@test.com');
        $this->assertSame($firstRecord['first_name'], 'Fname');
        $this->assertSame($firstRecord['last_name'], 'Lname');
        $this->assertSame($firstRecord['password'], 'passwordvalid');
        $this->assertSame($firstRecord['platforms'], 'ios');
        $this->assertSame($firstRecord['additional_field'], 'addField');
    }
}
