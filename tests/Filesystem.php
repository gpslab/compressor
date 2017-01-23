<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2011, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */

namespace GpsLab\Component\Compressor\Tests;

use Symfony\Component\Filesystem\Filesystem as FilesystemSymfony;

class Filesystem
{
    /**
     * @var string
     */
    const CONTENT = "foo\r\nbar\n";

    /**
     * @var FilesystemSymfony
     */
    private $fs;

    /**
     * @var string
     */
    private $root = '';

    public function __construct()
    {
        $this->fs = new FilesystemSymfony();

        $this->root = sys_get_temp_dir().'/test/';
        $this->fs->mkdir($this->root);
    }

    public function clear()
    {
        $this->fs->remove($this->root);
    }

    /**
     * @param string $file
     *
     * @return bool
     */
    public function exists($file)
    {
        return $this->fs->exists($file);
    }

    /**
     * @return string
     */
    public function tempnam()
    {
        return $this->fs->tempnam($this->root, 'test');
    }

    /**
     * @param string $filename
     */
    public function remove($filename)
    {
        $this->fs->remove($filename);
    }

    /**
     * @param string $filename
     */
    public function put($filename)
    {
        file_put_contents($filename, self::CONTENT);
    }

    /**
     * @param string $filename
     * @param \Closure|null $compressor
     *
     * @return bool
     */
    public function equals($filename, \Closure $compressor = null)
    {
        // not compress as a default
        if (!$compressor) {
            $compressor = function ($content) {
                return $content;
            };
        }

        return self::CONTENT == call_user_func($compressor, file_get_contents($filename));
    }
}
