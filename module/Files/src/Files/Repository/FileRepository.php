<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 08.07.18
 * Time: 18:37
 */

namespace Files\Repository;


use Files\Entity\File;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

/**
 * Class FileRepository
 * @package Files\Repository
 */
class FileRepository
{
    /** @var TableGateway $tableGateway */
    protected $tableGateway;

    /**
     * FileRepository constructor.
     * @param TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @param File $file
     * @throws \Exception
     */
    public function saveFile(File $file)
    {
        /** @var array $data */
        $data = [];
        foreach ($file as $key => $val) {
            if ($key == 'id') {
                continue;
            }
            $data[$key] = $val;
        }

        /** @var int|null $id */
        $id = $file->id ?? null;

        if ($id) {
            if ($this->getFile($id)) {
                $this->tableGateway->update($data, ['id' => $is]);
            } else {
                throw new \Exception(sprintf('Can\'t find file whith id %d', $id));
            }
        } else {
            try {
                $this->tableGateway->insert($data);
            } catch (\Exception $e) {
                die($e->getMessage());
            }
        }
    }

    /**
     * @param $id
     * @return File
     * @throws \Exception
     */
    public function getFile($id)
    {
        /** @var ResultSet $rowset */
        $rowset = $this->tableGateway->select(['id' => $id]);
        /** @var File $file */
        $file = $rowset->current();
        if (!$file) {
            throw new \Exception(sprintf('Can\'t find file whith id %d', $id));
        }
        return $file;
    }

    /**
     * @return ResultSet
     */
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    /**
     * @param $id
     */
    public function deleteFile($id)
    {
        $this->tableGateway->delete(['id' => $id]);
    }

    /**
     * @param $userId
     * @return ResultSet
     */
    public function getUploadsByUserId($userId)
    {
        return $this->tableGateway->select(['user_id' => $userId]);
    }
}
