<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2011, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */

namespace GpsLab\Component\Compressor;

class ZipCompressor implements CompressorInterface
{
    /**
     * @var \ZipArchive
     */
    protected $zip;

    /**
     * @param \ZipArchive $zip
     */
    public function __construct(\ZipArchive $zip)
    {
        $this->zip = $zip;
    }

    /**
     * @param string $source
     * @param string $target
     *
     * @return bool
     */
    public function compress($source, $target = '')
    {
        $target = $target ?: $source.'.zip';

        if (false === $this->zip->open($target, \ZipArchive::OVERWRITE | \ZipArchive::CREATE)) {
            return false;
        }

        if (false === $this->zip->addFile($source, basename($source))) {
            $this->zip->close();

            return false;
        }

        return $this->zip->close();
    }

    /**
     * @param string $source
     * @param string $target
     *
     * @return bool
     */
    public function uncompress($source, $target)
    {
        if (false === $this->zip->open($source, \ZipArchive::CHECKCONS)) {
            return false;
        }

        if (false === $this->zip->extractTo(dirname($target), basename($target))) {
            $this->zip->close();

            return false;
        }

        return $this->zip->close();
    }
}
