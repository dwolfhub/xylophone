<?php

namespace Xylophone\QueryRepository;

use Doctrine\DBAL\Connection;

/**
 * Class AbstractQueryRepository
 * @package Xylophone\QueryRepository
 */
abstract class AbstractQueryRepository
{
    /**
     * @var Connection
     */
    protected $conn;

    /**
     * @return string
     */
    abstract function getTableName();

    /**
     * AbstractQueryRepository constructor.
     * @param Connection $conn
     */
    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $queryBuilder = $this->conn->createQueryBuilder();

        return $queryBuilder->select(['*'])
            ->from($this->getTableName())
            ->where(
                $queryBuilder->expr()->eq('id', $id)
            )
            ->execute()
            ->fetch();
    }

    /**
     * @return array
     */
    public function findAll()
    {
        $queryBuilder = $this->conn->createQueryBuilder();

        return $queryBuilder->select(['*'])
            ->from($this->getTableName())
            ->execute()
            ->fetchAll();
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param int|null $limit
     * @param int|null $offset
     * @return array
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $queryBuilder = $this->conn->createQueryBuilder();

        return $queryBuilder->select(['*'])
            ->from($this->getTableName())
            ->where($criteria)
            ->orderBy($orderBy)
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->execute()
            ->fetchAll();
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @return mixed
     */
    public function findOneBy(array $criteria, array $orderBy = null)
    {
        $queryBuilder = $this->conn->createQueryBuilder();

        return $queryBuilder->select(['*'])
            ->from($this->getTableName())
            ->where($criteria)
            ->orderBy($orderBy)
            ->setMaxResults(1)
            ->execute()
            ->fetch();
    }
}