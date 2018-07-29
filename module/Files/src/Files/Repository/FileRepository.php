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
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

/**
 * Class FileRepository
 * @package Files\Repository
 */
class FileRepository
{
    /** @var TableGateway $tableGateway */
    protected $tableGateway;

    /** @var TableGateway $fileSharingTableGateway */
    protected $fileSharingTableGateway;

    /**
     * FileRepository constructor.
     * @param TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway, TableGateway $fileSharingTableGateway)
    {
        $this->tableGateway = $tableGateway;
        $this->fileSharingTableGateway = $fileSharingTableGateway;
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
                $this->tableGateway->update($data, ['id' => $id]);
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

    /**
     * @param $fileId
     * @param $userId
     */
    public function addSharing($fileId, $userId)
    {
        /** @var array $data */
        $data = [
            'file_id' => intval($fileId),
            'user_id' => intval($userId),
        ];

        $this->fileSharingTableGateway->insert($data);
    }

    /**
     * @param $fileId
     * @param $userId
     */
    public function deleteSharing($fileId, $userId)
    {
        /** @var array $data */
        $data = [
            'file_id' => intval($fileId),
            'user_id' => intval($userId),
        ];

        $this->fileSharingTableGateway->delete($data);
    }

    /**
     * @param $fileId
     * @return ResultSet
     */
    public function getSharedUsers($fileId)
    {
        /** @var int $fileId */
        $fileId = intval($fileId);

        return $this->fileSharingTableGateway->select(function (Select $select) use ($fileId) {
            $select->columns([])
                ->where(['file_sharing.file_id' => $fileId])
                ->join('user', 'file_sharing.user_id = user.id');
        });
    }

    /**
     * @param $userId
     * @return ResultSet
     */
    public function getSharedFilesForUserId($userId)
    {
        /** @var int $userId */
        $userId = intval($userId);

        return $this->fileSharingTableGateway->select(function (Select $select) use ($userId) {
            $select->columns([])
                ->where(['file_sharing.user_id' => $userId])
                ->join('file', 'file_sharing.file_id = file.id');
        });
    }
}
