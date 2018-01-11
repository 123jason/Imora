<?php

/**
 * @Description: 函数
 * @Author: zhiqiang xie <xiezq@oradt.com> 
 * @Date: 2014-08-18
 * @Version:1.0.0.0
 */

namespace Oradt\ServiceBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Serializer\Exception\Exception;

class GlobalBase
{

    public $em;
    public $betDate;
    public $feeParams = array(
        //'FlightNo',
        'FlightCompany',
        'FlightDepcode',
        'FlightArrcode',
        'FlightDeptimePlanDate',
        'FlightArrtimePlanDate',
        'FlightDeptimeReadyDate',
        'FlightArrtimeReadyDate',
        'FlightDeptimeDate',
        'FlightArrtimeDate',
        'FlightIngateTime',
        'FlightOutgateTime' ,
        'VeryZhunReadyDeptimeDate',
        'VeryZhunReadyArrtimeDate',
        'CheckinTable',
        'BoardGate',
        'BaggageID',
        'BoardState',
        'FlightState',
        'FlightHTerminal',
        'FlightTerminal',
        'FlightDep',
        'FlightArr',
        'stopFlag',
        'shareFlag',
        'LegFlag',
        'ShareFlightNo',
        'FlightCancelTime',
        'FillFlightNo',
        'bridge',
        'FlightDepAirport',
        'FlightArrAirport',
        'alternate_info',
        'AlternateStatus',
        'AlternateDepCity',
        'AlternateArrCity',
        'AlternateDepAirport', 
        'AlternateArrAirport',
        'AlternateDeptimePlan',
        'AlternateArrtimePlan',
        'AlternateDeptime',
        'AlternateArrtime',
        'org_timezone',
        'dst_timezone',
        'fcategory',
        // 'fid'
        );
    /**
     *
     * @param EntityManager $entityManager 
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->betDate = new \DateTime(); //当前时间【datetime类型】
    }

    /** 插入表单
     * $insertarr 数组（键值为表单字段名）
     * $table_name 表单名 
     * $objtable_name 对象
     * $where 修改的find条件
     * @param EntityManager $entityManager 
     */
    public function execute($insertarr, $objTableName, $tableName = null, array $criteria = null)
    {
        $class = new \ReflectionClass($objTableName);
        $classname = "";

        if (!empty($criteria)) {
            // update 
            $entity = $this->em->getRepository("OradtStoreBundle:" . $tableName)->findOneBy($criteria);

            if (!$entity) {
                return false; //该数据不存在
            }
            //表单赋值start 
            foreach ($insertarr as $k => $v) {
                if ($class->hasProperty($k)) {
                    return false;
                }
                $setter = $class->getMethod("set" . ucfirst($k));
                $ok = $setter->invoke($entity, $v);
            }
            //对象赋值
            $classname = $entity;
        } else {
            //表单赋值start  insert
            foreach ($insertarr as $k => $v) {
                if ($class->hasProperty($k)) {
                    return false;
                }
                $setter = $class->getMethod("set" . ucfirst($k));
                $ok = $setter->invoke($objTableName, $v);
            }
            //对象赋值
            $classname = $objTableName;
        }
        //数据提交 
        try {
            $this->em->persist($classname);
            $this->em->flush();
            return $classname;
        } catch (Exception $exc) {
            return false;
        }
    }

    /**
     * 查询某条数据
     * @param type $table
     * @param type $criteria
     */
    public function findOneBy($table, $criteria, array $orderBy = null)
    {
        $repEntity = $this->em->getRepository('OradtStoreBundle:' . $table);
        $entity = $repEntity->findOneBy($criteria, $orderBy);
        return $entity;
    }

    /**
     * 查询数据
     * @param type $table
     * @param type $criteria
     */
    public function findBy($table, array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $repEntity = $this->em->getRepository('OradtStoreBundle:' . $table);
        $entity = $repEntity->findBy($criteria, $orderBy, $limit, $offset);
        return $entity;
    }

    /**
     * 查询数据
     * @param type $table
     * @param type $criteria
     */
    public function find($table, $criteria)
    {
        $repEntity = $this->em->getRepository('OradtStoreBundle:' . $table);
        $entity = $repEntity->find($criteria);
        return $entity;
    }

    /**
     * 查询所有数据
     * @param type $table
     * @param type $criteria
     */
    public function findAll($table)
    {
        $repEntity = $this->em->getRepository('OradtStoreBundle:' . $table);
        $entity = $repEntity->findAll();
        return $entity;
    }

    /**
     * 查询总数据
     * @param type $table
     * @param type $criteria
     */
    public function count($sql, array $criteria = null)
    {
        $query = $this->em->createQuery($sql);
        $query->setParameters($criteria);
        $count = $query->getSingleScalarResult();
        return $count;
    }

    /**
     * 删除某条数据
     * @param type $table
     * @param type $criteria
     */
    public function delete($table, $criteria)
    {
        $repEntity = $this->em->getRepository('OradtStoreBundle:' . $table);
        $entity = $repEntity->findOneBy($criteria);
        if (!empty($entity)) {
            $this->em->remove($entity);
            $this->em->flush();
            return true;
        }
        return FALSE;
    }

    public function delete_entity($entity)
    {
        //var_dump($entity);
        if (!empty($entity)) {
            $this->em->remove($entity);
            $this->em->flush();
            return true;
        }
        return FALSE;
    }
    
    /**
     * 删除某些数据
     * @param type $table
     * @param type $criteria
     */
    public function deleteAll($table, $criteria)
    {
        $repEntity = $this->em->getRepository('OradtStoreBundle:' . $table);
        $entity = $repEntity->findBy($criteria);
        if (!empty($entity)) {
            foreach ($entity as $entityone){
                $this->em->remove($entityone);
                $this->em->flush();
            }
            return true;
        }
        return FALSE;
    }
    /**
     * 修改数据
     * @param type $insertarr
     * @param type $objTableName
     * @param type $entity
     * @return boolean
     * @throws Exception
     */
    public function update($insertarr, $objTableName, $entity,$isempty = true)
    {
        $class = new \ReflectionClass($objTableName);
        if (!empty($entity)) {
            //表单赋值start 
            foreach ($insertarr as $k => $v) {
                if ($class->hasProperty($k)) {
                    throw new Exception($k . " is not a valid property");
                }
                if ($isempty) {
                    if (!empty($v)) {
                        $setter = $class->getMethod("set" . ucfirst($k));
                        $setter->invoke($entity, $v);
                    }      
                }else{
                    $setter = $class->getMethod("set" . ucfirst($k));
                    $setter->invoke($entity, $v);
                }
                              
            }
            //数据提交 
            try {
                $this->em->persist($entity);
                $this->em->flush();
                return true;
            } catch (Exception $exc) {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * createQueryBuilder查询
     *  
     * @param type $table
     * @param type $where
     * @param array $criteria
     * @param array $orderBy
     * @param type $limit
     * @param type $offset
     * @return type
     */
    public function createQueryBuilder($table, $alias = 't', $where = null, array $criteria, $limit = null, $offset = null)
    {
        $repository = $this->em->getRepository('OradtStoreBundle:' . $table);
        $res = $repository->createQueryBuilder($alias)
            ->where($where)
            ->setParameters($criteria)
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
        return $res;
    }

}

