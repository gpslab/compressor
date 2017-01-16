<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2011, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */

namespace GpsLab\Component\Compressor\Tests;

use GpsLab\Component\Compressor\DummyCompressor;

class DummyCompressorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DummyCompressor
     */
    private $compressor;
    /**
     * @var File
     */
    private $file;

    /**
     * @var string
     */
    private $source = '';

    /**
     * @var string
     */
    private $target = '';

    protected function setUp()
    {
        $this->source = tempnam(sys_get_temp_dir(), 'test');
        $this->target = tempnam(sys_get_temp_dir(), 'test');

        $this->file = new File();
        $this->compressor = new DummyCompressor();
    }

    protected function tearDown()
    {
        if (file_exists($this->source)) {
            unlink($this->source);
        }
        if (file_exists($this->target)) {
            unlink($this->target);
        }
    }

    public function testCompressDoNothing()
    {
        $this->assertTrue($this->compressor->compress($this->source));
    }

    public function testCompress()
    {
        $this->file->put($this->source);

        $this->assertTrue($this->compressor->compress($this->source, $this->target));
        $this->assertTrue(file_exists($this->target));
        $this->assertTrue($this->file->equals($this->target));
    }

    public function testUncompressDoNothing()
    {
        $this->assertTrue($this->compressor->uncompress($this->source, $this->source));
    }

    public function testUncompress()
    {
        $this->file->put($this->source);

        $this->assertTrue($this->compressor->uncompress($this->source, $this->target));
        $this->assertTrue(file_exists($this->target));
        $this->assertTrue($this->file->equals($this->target));
    }
}
