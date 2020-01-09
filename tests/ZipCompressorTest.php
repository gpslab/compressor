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
use PHPUnit\Framework\TestCase;

class ZipCompressorTest extends TestCase
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

    public function testCompressOnIncorrectFilePath()
    {
        $source = '/this/bzip/file/is/not/existed';

        $this->assertFalse($this->compressor->compress($source));
    }

    public function testUncompressOnIncorrectFilePath()
    {
        $source = '/this/bzip/file/is/not/existed';
        $target = '/this/target/bzip/file/is/not/existed';

        $this->assertFalse($this->compressor->uncompress($source, $target));
    }
}
