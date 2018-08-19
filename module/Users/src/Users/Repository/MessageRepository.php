<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 19.08.18
 * Time: 14:13
 */

namespace Users\Repository;


use Zend\Db\TableGateway\TableGateway;

/**
 * Class MessageRepository
 * @package Users\Repository
 */
class MessageRepository
{
    /** @var TableGateway */
    protected $tableGateway;

    /**
     * MessageRepository constructor.
     * @param TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    /**
     * @param $message
     * @return int
     */
    public function saveMessage($message)
    {
        return $this->tableGateway->insert($message);
    }
}
