<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2011, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */

namespace GpsLab\Component\Compressor\Tests;

use GpsLab\Component\Compressor\GzipCompressor;

class GzipCompressorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GzipCompressor
     */
    private $compressor;

    /**
     * @var Filesystem
     */
    private $fs;

    protected function setUp()
    {
        $this->compressor = new GzipCompressor();
        $this->fs = new Filesystem();
    }

    protected function tearDown()
    {
        $this->fs->clear();
    }

    public function testCompress()
    {
        $source = $this->fs->tempnam();
        $compress = $this->fs->tempnam();
        $uncompress = $this->fs->tempnam();

        $this->fs->put($source);

        $this->assertTrue($this->compressor->compress($source, $compress));
        $this->assertTrue($this->fs->exists($compress));
        $this->assertFalse($this->fs->equals($compress));

        $this->assertTrue($this->compressor->uncompress($compress, $uncompress));
        $this->assertTrue($this->fs->exists($uncompress));
        $this->assertTrue($this->fs->equals($uncompress));
    }
}
