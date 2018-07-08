<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 30.06.18
 * Time: 15:06
 */

namespace Users\Repository;


use Users\Entity\User;
use Zend\Db\Adapter\Exception\InvalidQueryException;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class UserRepository
{
    /** @var TableGateway $tableGateway */
    protected $tableGateway;

    /**
     * UserRepository constructor.
     * @param TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @param $id
     * @return array|\ArrayObject|null
     * @throws \Exception
     */
    public function getUser($id)
    {
        /** @var int $id */
        $id = intval($id);

        /** @var ResultSet $rowset */
        $rowset = $this->tableGateway->select(['id' => $id]);

        /** @var  $result */
        $result = $rowset->current();
        if (!$result) {
            throw new \Exception(sprintf('Can not find user with id %d', $id));
        }
        return $result;
    }

    /**
     * @param User $user
     * @throws \Exception
     */
    public function saveUser(User $user)
    {
        /** @var array $data */
        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
        ];

        /** @var int $id */
        $id = $user->id ?? null;

        if ($id) {
            if ($this->getUser($id)) {
                $this->tableGateway->update($data, ['id' => $id]);
            } else {
                throw new \Exception(sprintf('Can not find user with id %d', $id));
            }
        } else {
            try {
                $this->tableGateway->insert($data);
            } catch (InvalidQueryException $e) {
                die($e->getMessage());
            }
        }
    }

    /**
     * @return ResultSet
     */
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    /**
     * @param $email
     * @return array|\ArrayObject|null
     * @throws \Exception
     */
    public function getUserByEmail($email)
    {
        /** @var ResultSet $rowset */
        $rowset = $this->tableGateway->select(['email' => $email]);
        /** @var User $user */
        $user = $rowset->current();
        if (! $user) {
            throw new \Exception(sprintf('Can not find user with email %s', $email));
        }
        return $user;
    }

    /**
     * @param $id
     */
    public function deleteUser($id)
    {
        $this->tableGateway->delete(['id' => $id]);
    }
}
