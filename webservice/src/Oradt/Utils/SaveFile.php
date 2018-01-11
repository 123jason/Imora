<?php

namespace Oradt\Utils;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * 文件操作类
 * @author huangxm
 *
 */
class SaveFile extends File
{   
    private $filename = '';
    private $pathname = '';
    private $size = 0;
    private $extension = "";
    /**
     * 
     * @param string $path 文件全路径
     * @param string $fileName 客户端文件名
     */
    public function __construct($path, $fileName='')
    {
        $this->filename = $fileName;
        
        if(empty($this->filename))
        {
            $this->filename = pathinfo($path, PATHINFO_FILENAME) . '.' . pathinfo($path, PATHINFO_EXTENSION);
        }
        
        $this->pathname = $path;
        $this->size = filesize($this->pathname);
        $this->extension = pathinfo($this->filename, PATHINFO_EXTENSION);
        parent::__construct($path);
    }
    
    
    /**
     * 复制文件
     * 
     * @param strng 目标文件路径 $targetFile
     * @throws FileException
     * @return \Symfony\Component\HttpFoundation\File\File
     */
    public function copy($targetFile)
    {
        $directory = pathinfo($targetFile, PATHINFO_DIRNAME);
        $name = pathinfo($targetFile, PATHINFO_BASENAME);// . '.' . pathinfo($targetFile, PATHINFO_EXTENSION);
        $target = $this->getTargetFile($directory,$name);
        if (!@copy($this->getPathname(), $target)) {
            $error = error_get_last();
            throw new FileException(sprintf('Could not move the file "%s" to "%s" (%s)', $this->getPathname(), $target, strip_tags($error['message'])));
        }        
        @chmod($target, 0666 & ~umask());
        return $target;
    }
    
    public function getClientSize()
    {
        return $this->size;
    }
    /**
     * 获取文件名
     * @return string
     */
    public function getClientOriginalName()
    {
        return $this->filename;
    }
    /**
     * 获取文件后辍
     * @return string
     */
    public function getClientOriginalExtension()
    {
        return $this->extension;
    }
    
    /**
     * 
     * @return string
     */
    public function getPathName()
    {
        return $this->pathname;
    }

    /**
     * construct Upload File object from path
     * @param string $path
     * @param string originalName
     * @return \Oradt\Utils\SaveFile
     */
    public static function getSaveFile($path) {
        $originalName = basename($path);
        $temp_file = tempnam(sys_get_temp_dir(), 'test');
        //$temp_file = tempnam('F:\xampp\tmp\\', 'test');
        file_put_contents($temp_file, file_get_contents($path));
        $upfile = new SaveFile($temp_file,$originalName);
        return $upfile;
    }
}
