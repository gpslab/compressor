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
     * @var Filesystem
     */
    private $fs;

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
        $this->compressor = new DummyCompressor();
        $this->fs = new Filesystem();

        $this->source = $this->fs->tempnam();
        $this->target = $this->fs->tempnam();
    }

    protected function tearDown()
    {
        $this->fs->clear();
    }

    public function testCompressDoNothing()
    {
        $this->assertTrue($this->compressor->compress($this->source));
    }

    public function testCompress()
    {
        $this->fs->put($this->source);

        $this->assertTrue($this->compressor->compress($this->source, $this->target));
        $this->assertTrue($this->fs->exists($this->target));
        $this->assertTrue($this->fs->equals($this->target));
    }

    public function testUncompressDoNothing()
    {
        $this->assertTrue($this->compressor->uncompress($this->source, $this->source));
    }

    public function testUncompress()
    {
        $this->fs->put($this->source);

        $this->assertTrue($this->compressor->uncompress($this->source, $this->target));
        $this->assertTrue($this->fs->exists($this->target));
        $this->assertTrue($this->fs->equals($this->target));
    }
}
