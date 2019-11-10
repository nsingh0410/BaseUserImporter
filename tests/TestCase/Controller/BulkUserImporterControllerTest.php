<?php
namespace App\Test\TestCase\Controller;

use App\Controller\BulkUserImporterController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\BulkUserImporterController Test Case
 *
 * @uses \App\Controller\BulkUserImporterController
 */
class BulkUserImporterControllerTest extends TestCase
{
    use IntegrationTestTrait;
    protected $route = [
        'controller' => 'BulkUserImporter',
        'action' => 'index'
        ];

    public function testIndexPostData()
    {
        $sampleFile = __DIR__ . '\..\sample\tech_test_sample.csv';
        $data = [
            "file" => [
            "tmp_name" => $sampleFile,
            "error" => 0,
            "name" => "tech_test_sample.csv",
            "type" => "application/vnd.ms-excel",
            "size" => 739
            ]
        ];
        $this->enableCsrfToken();
        $this->post($this->route, $data);

        $this->assertResponseSuccess();
        $this->assertResponseContains('testvalidemail@test.com');
    }
}
