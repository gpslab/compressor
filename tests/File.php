<?php

/**
 * Pkvs package
 *
 * @package Pkvs
 * @author  Peter Gribanov <pgribanov@1tv.com>
 */
namespace GpsLab\Component\Compressor\Tests;

class File
{
    /**
     * Image in base64
     *
     * @var string
     */
    const IMAGE = 'R0lGODlhAQAFAKIAAPX19e/v7/39/fr6+urq6gAAAAAAAAAAACH5BAAAAAAALAAAAAABAAUAAAMESAEjCQA7';

    /**
     * @param string $filename
     */
    public function put($filename)
    {
        file_put_contents($filename, base64_decode(self::IMAGE));
    }

    /**
     * @param string $filename
     *
     * @return bool
     */
    public function equals($filename)
    {
        return base64_decode(self::IMAGE) == file_get_contents($filename);
    }
}
