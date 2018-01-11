<?php
namespace Oradt\ServiceBundle\Services;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Oradt\StoreBundle\Entity\DesignProductDetail;
use Oradt\StoreBundle\Entity\DesignProductStyle;
use Oradt\Utils\Codes;
use Oradt\Utils\RandomString;
use Oradt\Utils;
use Oradt\ServiceBundle\Services\Aliyun\src\OSS\Core\OssException;
use Oradt\ServiceBundle\Services\Aliyun\src\OSS\Http\RequestCore;
use Oradt\ServiceBundle\Services\Aliyun\src\OSS\Http\ResponseCore;
/**
* 阿里云OSS对象存储整合
* @day 2016-5-17
* @author xinggm
* @param
* @function
* @return 
*/
class AliyunService extends BaseService
{
	
	const endpoint = '';
    const accessKeyId = '';
    const accessKeySecret ='';
    const bucket='' ;
    const ossClient = '';
    const mergerUrl = 'http://oradtoss.oss-cn-beijing.aliyuncs.com';
    //读写权限
    private $pubacl  = 'public-read';
    private $pvtacl  = 'private';
    private $prwacl  = 'public-read-write';

	public function __construct(ContainerInterface $container)
	{
		parent::__construct($container);
		include_once dirname(__FILE__) .'/Aliyun/autoload.php';
		include_once dirname(__FILE__) .'/Aliyun/Aliconfig.php';
		include_once dirname(__FILE__) .'/Aliyun/src/OSS/OssClient.php';
		$this->endpoint =\Aliconfig::OSS_ENDPOINT;
		$this->accessKeyId = \Aliconfig::OSS_ACCESS_ID;
		$this->accessKeySecret = \Aliconfig::OSS_ACCESS_KEY;
		$this->bucket = \Aliconfig::OSS_TEST_BUCKET;
		$this->ossClient = $this->getOssClient();
		if (empty($this->ossClient)) {
			return false;
		}
	}
	/**
	 * 是否能够正常连接
	 */
	public function getOssClient()
    {
        try {
            $ossClient = new \OSS\OssClient($this->accessKeyId, $this->accessKeySecret, $this->endpoint, false);
        } catch (\OSS\OssException $e) {
            printf(__FUNCTION__ . "creating OssClient instance: FAILED\n");
            printf($e->getMessage() . "\n");
            return null;
        }
        $this->pvtacl = \OSS\OSSClient::OSS_ACL_TYPE_PRIVATE;
        $this->pubacl = \OSS\OssClient::OSS_ACL_TYPE_PUBLIC_READ;
        $this->prwacl = \OSS\OssClient::OSS_ACL_TYPE_PUBLIC_READ_WRITE;
        return $ossClient;
    }
    /**
     * 获取所有的buckets
     */    
	public function listBuckets()
	{
	    $bucketList = $res = null;
	    try {
	        $bucketListInfo = $this->ossClient->listBuckets();
	    } catch (\OSS\OssException $e) {
	        printf(__FUNCTION__ . ": FAILED\n");
	        printf($e->getMessage() . "\n");
	        return;
	    }
	    print(__FUNCTION__ . ": OK" . "\n");
	    $bucketList = $bucketListInfo->getBucketList();
	    foreach ($bucketList as $bucket) {
	    	$res[] = array(
	    		'address'=>$bucket->getLocation(),
	    		'name'   =>$bucket->getName(),
	    		'time'   =>$bucket->getCreatedate()
	    		);
	    }
	    return $res;
	}
    /**
     * 判断bucket是否生成
     */
	public function doesBucketExist()
	{
	    try {
	        $res = $this->ossClient->doesBucketExist($this->bucket);
	    } catch (\OSS\OssException $e) {
	        printf(__FUNCTION__ . ": FAILED\n");
	        printf($e->getMessage() . "\n");
	        return;
	    }
	    if ($res === true) {
	        return true;
	    } else {
	        return false;
	    }
	}
	/**
	 * 把本地变量的内容到文件
	 *
	 * 简单上传,上传指定变量的内存值作为object的内容
	 *
	 * @param OssClient $ossClient OssClient实例
	 * @param string $bucket 存储空间名称
	 * @return null
	 */
	public function putObject()
	{
	    $object = "oss-php-sdk-test/upload-test-object-name.txt";
	    $content = file_get_contents(__FILE__);
	    $options = array();
	    try {
	        $this->ossClient->putObject($this->bucket, $object, $content, $options);
	    } catch (OssException $e) {
	        printf(__FUNCTION__ . ": FAILED\n");
	        printf($e->getMessage() . "\n");
	        return;
	    }
	    print(__FUNCTION__ . ": OK" . "\n");
	}
	/**
	 * 上传指定的本地文--图片
	 *
	 * @param OssClient $ossClient OssClient实例
	 * @param $object str 上传后的路径
	 * @return null
	 */
	public function uploadFile($object,$filePath)
	{
	    $object   = empty($object)? "upload-test-object-name.jpg":$object;
	    $filePath = empty($filePath)?'./test3.jpg':$filePath;
	    $fileExtension = $filePath->getClientOriginalExtension();
	    $object   = $object.'.'.$fileExtension;
	    $options  = array();
	    try {
	        $this->ossClient->uploadFile($this->bucket, $object, $filePath, $options);
	    } catch (OssException $e) {	        
	        printf($e->getMessage() . "\n");
	        return;
	    }
	    return $object;
	}
	/**
	 * 生成Object的签名url,主要用于私有权限下的读访问控制
	 * 生成一个可以被外界查看，下载的地址.但是有时间限制。
	 * @param $ossClient OssClient OssClient实例
	 * @param $bucket string 存储空间名称
	 * @return null
	 */
	public function getSignedUrlForGettingObject($object)
	{
	    $object = empty($object)?"oss-php-sdk-test/upload-test-object-name.jpg":$object; 
	    $timeout = 3600*24;
	    try {
	        $signedUrl = $this->ossClient->signUrl($this->bucket, $object,$timeout);
	    } catch (\OSS\OssException $e) {
	        printf(__FUNCTION__ . ": FAILED\n");
	        printf($e->getMessage() . "\n");
	        return;
	    }
	    /**
	     * 可以类似的代码来访问签名的URL，也可以输入到浏览器中去访问
	     */
	    $request = new \OSS\Http\RequestCore($signedUrl);
	    $request->set_method('GET');
	    $request->add_header('Content-Type', '');
	    $request->send_request();
	    $res = new \OSS\Http\ResponseCore($request->get_response_header(), $request->get_response_body(), $request->get_response_code());
	    if ($res->isOK()) {
	        return $signedUrl;
	    } else {
	        return false;
	    };
	}
	/**
	 * 获取bucket的acl配置
	 *
	 * @param OssClient $ossClient OssClient实例
	 * @param string $bucket 存储空间名称
	 * @return null
	 */
	function getBucketAcl()
	{
	    try {
	        $res = $this->ossClient->getBucketAcl($this->bucket);
	    } catch (OssException $e) {
	        printf(__FUNCTION__ . ": FAILED\n");
	        printf($e->getMessage() . "\n");
	        return;
	    }
	    switch ($res) {
	    	case $this->pvtacl:
	    		return 1;
	    		break;
	    	case $this->pubacl:
	    		return 2;
	    		break;
	    	case $this->prwacl:
	    		return 3;
	    		break;
	    	default:
	    		return 4;
	    		break;
	    }  
	}
	public function mergerUrl()
    {        
        $url = self::mergerUrl;       
        return $url;
    }
}
?>