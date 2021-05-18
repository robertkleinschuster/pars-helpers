<?php


namespace Pars\Helper\Filesystem;


use Pars\Pattern\Exception\CoreException;

class FilesystemHelper
{
    private const SEPARATOR_HASH = '_hash_';

    public static function deleteDirectory(string $dir)
    {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            if (is_dir($dir . DIRECTORY_SEPARATOR . $file)) {
                self::deleteDirectory($dir . DIRECTORY_SEPARATOR . $file);
            } else {
                unlink($dir . DIRECTORY_SEPARATOR . $file);
            }
        }
        return rmdir($dir);
    }

    public static function injectHash(string $filename, string $hash): string
    {
        $exp = explode('.', $filename);
        $result = '';
        $count = count($exp);
        foreach ($exp as $key => $item) {
            if ($key === $count - 1) {
                $result .= self::SEPARATOR_HASH . $hash;
                $result .= '.' . $item;

            } else {
                $result .= $item;
            }
        }
        return $result;
    }

    public static function extractHash(string $filename)
    {
        $exp = explode('.', $filename);
        array_pop($exp);
        $str = array_pop($exp);
        $exp = explode(self::SEPARATOR_HASH, $str);
        return array_pop($exp);
    }

    /**
     * @param string $directory
     */
    public static function lastModified($directory)
    {
        $newestTime = 0;
        $files = $directory;
        if (!is_array($files)) {
            $files = glob($files . '/*');
        }
        if (is_array($files)) {
            foreach ($files as $file) {
                if (is_file($file) && filemtime($file) > $newestTime) {
                    $newestTime = filemtime($file);
                }
                if (is_dir($file)) {
                    $newestTimeInDir = self::lastModified($file);
                    if ($newestTimeInDir > $newestTime) {
                        $newestTime = $newestTimeInDir;
                    }
                }
            }
            return $newestTime;
        } else {
            throw new CoreException('Invalid directory');
        }
    }

    public static function get_file_dir()
    {
        global $argv;
        $dir = dirname(getcwd() . '/' . $argv[0]);
        $curDir = getcwd();
        chdir($dir);
        $dir = getcwd();
        chdir($curDir);
        return $dir;
    }

    public static function getDir(string $path, bool $isDir = false)
    {
        $dir = $path;
        if (!$isDir) {
            $dir = dirname($path);
        }
        if (!@is_dir($dir)) {
            @mkdir($dir);
        }
        return $dir;
    }


    public static function getPath(string $path)
    {
        return static::getDir($path) . DIRECTORY_SEPARATOR . basename($path);
    }

    /**
     * @param $folder
     * @param $perm
     */
    public static function chmodRec($folder, $perm)
    {
        $result = chmod("$folder", $perm);
        $glob = glob("$folder/*");
        if (is_array($glob)) {
            foreach ($glob as $item) {
                self::chmodRec($item, $perm);
            }
        }
        return $result;
    }
}
