<?php
/**
 * depends kernel container
 * @author huangxm
 *
 */
namespace Oradt\Utils;

trait RedisTrait {
    protected static $cacheObject    = null;


    /**
     * 缓存键名
     * @param string $key 后辍
     * @param string $pre 前辍
     * @return string
     */
    protected function getCacheKey($key,$pre='') {
        return $pre . '_' . $key;
    }
    
    protected function getCacheKeyByApi($key,$pre='') {
        if($this->container->hasParameter('redis_key_pre')){
            $pre .= '_'.$this->container->getParameter('redis_key_pre');
        }
        return $pre . '_' . $key;
    }
    /**
     * 检测cacheKey 是否存在
     */
    protected function checkCacheKeyExists($key){
        if($this->getCacheService()->isActive()){
            return $this->getCacheService()->exists($key);
        }
        return FALSE;
    }
    
    /**
     * 缓存键名
     * @param string $key 键名
     */
    protected function removeCache($key) {
        if($this->getCacheService()->isActive()){
            $this->getCacheService()->del($key);
        }
    }
    
    protected function getCacheService() {
//        if(null === $this->cacheObject) {
//            //$this->cacheObject = $this->container->get("cache_redis_service");
//            $this->cacheObject = $this->container->get("predis_service");
//        }
//        return $this->cacheObject;
        
        if(null === self::$cacheObject) {
            self::$cacheObject = $this->container->get("predis_service");
        }
        return self::$cacheObject;
    }
    
    /**
     * 断开连接
     */
    public function disConnectCacheService(){
        if($this->getCacheService()->isActive()){
            $this->getCacheService()->disConnect();
        }
    }
    /**
     * 获取缓存  只支持 redis  get 命令
     * @param string $key
     * @return NULL
     */
    protected function getCache($key) {
        if($this->getCacheService()->isActive()){
            return $this->getCacheService()->get($key);
        }
        return null;
    }
    
    /**
     * 添加缓存  只支持 set redis 命令
     * @param string $key
     * @param string $value
     */
    protected function setCache($key,$value) {
        if($this->getCacheService()->isActive()){
            $this->getCacheService()->set($key,$value);
        }
    }
    /**
     * 获取缓存  只支持 redis  hmget 命令
     * @param string $key
     * @return NULL
     */
    protected function hmGetCache($key,$fieldArray=array()) {
        if($this->getCacheService()->isActive()){
            return $this->getCacheService()->hMget($key,$fieldArray);
        }
        return null;
    }
    
    /**
     * 添加缓存  只支持 hmset redis 命令
     * @param string $key
     * @param array  $fieldArray
     */
    protected function hmSetCache($key,$fieldArray=array()) {
        if($this->getCacheService()->isActive()){
            $this->getCacheService()->hMset($key,$fieldArray);
        }
    }
    
    /**
     * 设置缓存 过期时间
     * @param sting  $key 要设置的key值
     * @param number $time 过期的时间-以秒（s）为单位
     */
    protected function setCacheExpireTime($key,$time = Codes::CACHE_EXPIRE_TIME){
        if($this->getCacheService()->isActive()){
            $this->getCacheService()->expire($key,$time);
        }
    }
    
    /**
     * @param type $key
     */
    public function hGetallCache($key){
        if($this->getCacheService()->isActive()){
            return $this->getCacheService()->hgetall($key);
        }
        return null;
    }

    /**
     *
     * @param type $key
     * @param type $val
     * @return type
     */
    public function setObjCache($key, $val) {
        if($this->getCacheService()->isActive()){
            try {
                $val = serialize($val);
                return $this->getCacheService()->set($key,$val);
            } catch (Exception $ex) { }
            return false;
        }
    }
    
    /**
     *
     * @param type $key
     * @return type
     */
    public function getObjCache($key) {
        if($this->getCacheService()->isActive()){
            try {
                $val = $this->getCacheService()->get($key);
                if ($val && strlen($val) > 0) {
                    return unserialize($val);
                }
            } catch (Exception $ex) { }
            return false;
        }
    }
    
}