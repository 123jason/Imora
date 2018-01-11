<?php
namespace Oradt\Utils;
use ZipArchive;
/**
 * phpZip class 实现了对名片包的解压与压缩
 * 调用方法 ：import('Zip', LIB_ROOT_PATH.'Classes/');
 *
/**
 * 读取压缩包
 * @param int $userId 用户id
 * @param int $cardId 名片id

public function index($cardId,$userId)
{
    //返回一个二维数组 key为路径 value为文件名称
    return    $this->getZipOriginalsize($cardId,$_SERVER['DOCUMENT_ROOT'].'Public/temp/'.$userId.'/');
    //  return  111;

}
 */
/**
 * 压缩文件
 * @param int $userId 用户id
 * @param int $cardId 名片id

public function fileList($cardId,$userId)
{

    // return  $this -> Zip($_SERVER['DOCUMENT_ROOT'].'Public/temp/'.$userId.'/'.$cardId.'/',$_SERVER['DOCUMENT_ROOT'].'Public/temp/'.$userid.'/'.$cardId.'.zip');
    $zip=new ZipArchive();
    if($zip->open($_SERVER['DOCUMENT_ROOT'].'/Public/temp/'.$userId.'/'.$cardId.'.zip', ZipArchive::OVERWRITE)=== TRUE){
        $this ->addFileToZip($_SERVER['DOCUMENT_ROOT'].'Public/temp/'.$userId.'/'.$cardId,$zip,$userid,$cardid); //调用方法，对要打包的根目录进行操作，并将ZipArchive的对象传递给方法
        $zip->close(); //关闭处理的zip文件
        //  return  111;

    }}
 *
 *
 * @example
 *  $zip = new Zip();
 *  $zip->zip('./myTest.zip', array('.'));
 *  $zip->unzip('./test.zip', './');
 *
 */
class PhpZip
{
    /*
     * Files list to be added into zipball
     * @var array
     */
    protected $filesList = array();

    /**
     * Unzip file to the specified folder
     * @param string $zipFilePath The zipball file path
     * @param string $targetFolder The folder to place the unzipped files
     * @param boot $overwrite If overwrite the existing files @todo Has not been implemented
     *
     * @return boolean
     */
    public function unzip ($zipFilePath, $targetFolder='.', $overwrite=true)
    {
        // zipball is not existing
        if (! is_file($zipFilePath)) {
            return false;
        }
        // if dir is not existing, return false
        if (! is_dir($targetFolder)) {
            return false;
        }

        $zip = new ZipArchive();
        $zip->open($zipFilePath);
        // if zipball has no file, return false
        if (! $zip->numFiles) {
            return false;
        }
        $filesList = array();
        for($i=0; $i < $zip->numFiles; $i++) {
            $filesList[] = $zip->getNameIndex($i);
        }
        // extract file to specified folder
        if($zip->extractTo($targetFolder)) {
            $result = $filesList;
        } else {
            $result = false;
        }

        return $result;
    }

    /**
     * All file/folder to zipball
     * @param string $filePath The file/folder path to be added into zipball
     * @return phpZip
     */
    public function addFileIntoZip ($filePath, $filenameInZip=null)
    {
        if (is_int($filenameInZip) || is_null($filenameInZip) || !is_string($filenameInZip)) {
            $filenameInZip = $filePath;
        }
        if (is_file($filePath)) {// is file . add it into directly
            $this->filesList[$filenameInZip] = $filePath;
        } else if (is_dir($filePath)) { // is folder. we need to add files recursively
            $dirHandler = new DirectoryIterator($filePath);
            if (! $dirHandler->isReadable()) { // dir is not readable
                return $this;
            }
            foreach ($dirHandler as $_fileInfo) {
                if ($_fileInfo->isDot()) { // it's . or ..
                    continue;
                }
                $currentNameInZip = $filenameInZip.'/'.$_fileInfo->getFilename();
                if ($_fileInfo->isDir()) { // is still dir
                    $_dir = $_fileInfo->getPath()
                                . DIRECTORY_SEPARATOR
                                . $_fileInfo->getFilename();
                    $this->filesList[$currentNameInZip] = $_dir; // add an empty folder first
                    $this->addFileIntoZip($_dir, $currentNameInZip); // add file recursively
                } else if ($_fileInfo->isFile()) {
                    $this->filesList[$currentNameInZip] = $_fileInfo->getPath()
                                . DIRECTORY_SEPARATOR
                                . $_fileInfo->getFilename();
                }
            } // end foreach
        }

        return $this;
    }

    /**
     * Create a new zipball file, and add files to be zipped
     * @param string $newZipFilePath The new zipball file path
     * @param array $filesToBeZipped The files to be added into zipball
     * @return boolean
     */
    public function zip ($newZipFilePath, $filesToBeZipped=array())
    {
        // zipball is already existing
        if (is_file($newZipFilePath)) {
            return false;
        }
        // add files into zipball
        foreach ($filesToBeZipped as $_key=>$_file) {
            $this->addFileIntoZip($_file, $_key);
        }
        // no file to be added into zipball
        if (! $this->filesList) {
            return false;
        }

        // create zipball file
        $zip = new ZipArchive();
        $operation = is_file($newZipFilePath) ? ZipArchive::OVERWRITE : ZipArchive::CREATE;
        $zip->open($newZipFilePath, $operation);
        foreach ($this->filesList as $_key=>$_file) {
            if (is_file($_file)) {
                $zip->addFile($_file, $_key);
            } else {
                $zip->addEmptyDir($_file, $_key);
            }
        }
        $zip->close();
        $result = is_file($newZipFilePath);

        return $result;
    }


    /**********************************************************
     * 解压部分
    **********************************************************/
    /**
     * 解压并遍历指定文件夹
     * @param string $path  路径 $filename 文件名
     */
    function getZipOriginalsize($filenameno, $path)
    {
        $filename=$filenameno.'.zip';
        //先判断待解压的文件是否存在
        if (!file_exists($path.'/'.$filename)) {
            return '文件' .$path.'/'.$filename. '不存在！';
            die();
        }
       // $starttime = explode(' ', microtime()); //解压开始的时间

        //将文件名和路径转成windows系统默认的gb2312编码，否则将会读取不到
        $filename = iconv("utf-8", "gb2312", $filename);
        $path = iconv("utf-8", "gb2312", $path);
        $filename=$path.'/'.$filename;
        //打开压缩包
        $resource = zip_open($filename);
        //dump($resource);
        $j = 0;
        $arrzip=array();
        //遍历读取压缩包里面的一个个文件
        while ($dir_resource = zip_read($resource))
        {
          // dump($dir_resource);
            //如果能打开则继续
            if (zip_entry_open($resource, $dir_resource)) {
                //获取当前项目的名称,即压缩包里面文件名
                $fileZipName = zip_entry_name($dir_resource);
                //获取当前项目的名称,即压缩包里面当前对应的文件名
                $file_name = $path . $fileZipName;
                //以最后一个“/”分割,再用字符串截取出路径部分
                $file_path = substr($file_name, 0, strrpos($file_name, "/"));
                //如果路径不存在，则创建一个目录，true表示可以创建多级目录
                if (!is_dir($file_path)) {
                    mkdir($file_path, 0777, true);
                }
                //如果不是目录，则写入文件
                if (!is_dir($file_name)) {
                    //读取这个文件
                    //取出文件名
                  // str_replace($filenameno.'/','',$fileZipName;
                   $fileZipPath = substr($fileZipName, 0, strrpos($fileZipName, "/"));
                   $fileZipName = str_replace($fileZipPath.'/','',$fileZipName);
                    //以解压缩相对路径和名称 生成一个数组
                    $fileA=array($fileZipPath => $fileZipName);
                   // dump($fileA);
                    //$arrzip = array_push($arrzip, $fileA);
                    $arrzip[$j] =  $fileA;

                    $file_size = zip_entry_filesize($dir_resource);
                    //最大读取6M，如果文件过大，跳过解压，继续下一个
                    if ($file_size < (1024 * 1024 * 6)) {
                        $file_content = zip_entry_read($dir_resource, $file_size);
                        file_put_contents($file_name, $file_content);
                    } else {
                       // echo "<p> " . $i++ . " 此文件已被跳过，原因：文件过大， -> " . iconv("gb2312", "utf-8", $file_name) . " </p>";
                    }
                }
                //关闭当前
                zip_entry_close($dir_resource);
            }
            $j++ ;
        }
        zip_close($resource);
        return  $arrzip;
    }

    /**********************************************************
     * 压缩部分 需要开启extension=php_zip.dll
     **********************************************************/
    /**
     * 遍历指定文件夹
     * @param string $path  路径
     * @param string $zip  上传类对象
     * @param string $userid  用户id
     * @param string $cardid  名片id
     */

    function addFileToZip($path,$zip,$userid,$cardid)
    {
        //打开当前文件夹由$path指定。
        $handler=opendir($path);
        while(($filename=readdir($handler))!==false){
            if($filename != '.'&& $filename != '..'){//文件夹文件名字为'.'和‘..’，不要对他们进行操作
                if(is_dir($path."/".$filename)){// 如果读取的某个对象是文件夹，则递归
                    $filedir= $filename;
                    $this->addFileToZip($path."/".$filename, $zip,$userid,$cardid);
                }else{ //将文件加入zip对象
                  ///  $zip->addFile($file,$file_info_arr['basename']);//去掉层级目录
                    $filedir=str_replace($_SERVER['DOCUMENT_ROOT'].'Public/temp/'.$userid.'/'.$cardid.'/', '', $path."/".$filename);
                    dump($filename);
                    $zip->addFile($path."/".$filename,$filedir);
                }

            }

	    }

            @closedir($path);
    }


}

/* EOF */