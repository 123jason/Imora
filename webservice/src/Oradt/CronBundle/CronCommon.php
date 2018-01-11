<?php
/**
 * 
 * @param unknown $className
 * @return object
 */
function getClass($className) {
	global $kernel,$functionName;
	$className = $className . 'Work';
	$classFile = dirname(__FILE__).'/Gearman/'.$className.'.php';
	if(!file_exists($classFile)) {
		echo $classFile . ' not found ' . $className;
		return null;
	}

	include $classFile;
	//$class = new $className($kernel->getContainer());
	$class = new ReflectionClass($className);

	$classObj = $class->newInstance($kernel->getContainer());
	return $classObj;
}