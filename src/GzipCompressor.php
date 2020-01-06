<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2011, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */

namespace GpsLab\Component\Compressor;

class GzipCompressor implements CompressorInterface
{
    /**
     * @param string $source
     * @param string $target
     *
     * @return bool
     */
    public function compress($source, $target = '')
    {
        $target = $target ?: $source.'.gz';
        $fh = @fopen($source, 'rb');
        $gz = @gzopen($target, 'wb9');

        if (false === $fh || false === $gz) {
            return false;
        }

        while (!feof($fh)) {
            if (false === gzwrite($gz, fread($fh, 1024))) {
                return false;
            }
        }

        fclose($fh);
        gzclose($gz);

        return true;
    }

    /**
     * @param string $source
     * @param string $target
     *
     * @return bool
     */
    public function uncompress($source, $target)
    {
        $gz = @gzopen($source, 'rb');
        $fh = @fopen($target, 'wb');

        if (false === $fh || false === $gz) {
            return false;
        }

        while (!feof($gz)) {
            if (false === fwrite($fh, gzread($gz, 1024))) {
                return false;
            }
        }

        fclose($fh);
        gzclose($gz);

        return true;
    }
}
