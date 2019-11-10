<?php
namespace App\Test\TestCase\Files\export;

use App\Files\export\PresentationLayer;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Files\export\PresentationLayerTest Test Case
 *
 * @uses \App\Test\TestCase\Files\export\PresentationLayerTest
 */
class PresentationLayerTest extends TestCase
{
    use IntegrationTestTrait;
    protected $sampleDir = __DIR__ . '/../../sample';
    protected $sampleValidRows = '/validRows.json';

    /**
     * test process method
     * @throws \App\Files\Exceptions\FileException
     */
    public function testProcess()
    {
        $options['outputFileDir'] = $this->sampleDir;
        $options['outputfileName'] = $this->sampleValidRows;
        $presentationLayer = new PresentationLayer($options);
        $testOutput = ['key' => 'value'];
        $presentationLayer->exportToJsonFile($testOutput);
        $this->assertSame('{"key":"value"}', $presentationLayer->getJsonResult());
    }
}
