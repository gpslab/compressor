<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2011, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */

namespace GpsLab\Component\Compressor;

class Bzip2Compressor implements CompressorInterface
{
    /**
     * @param string $source
     * @param string $target
     *
     * @return bool
     */
    public function compress($source, $target = '')
    {
        $target = $target ?: $source.'.bz2';
        $fh = @fopen($source, 'rb');
        $bz = @bzopen($target, 'w');

        if (false === $fh || false === $bz) {
            return false;
        }

        while (!feof($fh)) {
            if (false === bzwrite($bz, fread($fh, 1024))) {
                return false;
            }
        }

        fclose($fh);
        bzclose($bz);

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
        $bz = @bzopen($source, 'r');
        $fh = @fopen($target, 'wb');

        if (false === $fh || false === $bz) {
            return false;
        }

        while (!feof($bz)) {
            if (false === fwrite($fh, bzread($bz, 1024))) {
                return false;
            }
        }

        fclose($fh);
        bzclose($bz);

        return true;
    }
}
