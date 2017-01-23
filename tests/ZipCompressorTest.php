<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2011, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */

namespace GpsLab\Component\Compressor\Tests;

use GpsLab\Component\Compressor\ZipCompressor;

class ZipCompressorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ZipCompressor
     */
    private $compressor;

    /**
     * @var Filesystem
     */
    private $fs;

    protected function setUp()
    {
        $this->compressor = new ZipCompressor(new \ZipArchive());
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

        $this->fs->put($source);

        $this->assertTrue($this->compressor->compress($source, $compress));
        $this->assertTrue($this->fs->exists($compress));
        $this->assertFalse($this->fs->equals($compress));

        $this->fs->remove($source);

        $this->assertTrue($this->compressor->uncompress($compress, $source));
        $this->assertTrue($this->fs->exists($source));
        $this->assertTrue($this->fs->equals($source));
    }
}
