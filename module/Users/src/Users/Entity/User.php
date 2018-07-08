<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 30.06.18
 * Time: 14:32
 */

namespace Users\Entity;

/**
 * Class User
 * @package Users\Entity
 */
class User
{
    /** @var int $id */
    public $id;

    /** @var string $name */
    public $name;

    /** @var string $email */
    public $email;

    /** @var string $password */
    public $password;

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = md5($password);
    }

    /**
     * @param array $data
     */
    public function exchangeArray(array $data)
    {
        if (isset($data['id'])) {
            $this->id = $data['id'];
        }

        if (isset($data['name'])) {
            $this->name = $data['name'];
        }

        if (isset($data['email'])) {
            $this->email = $data['email'];
        }

        if (isset($data['password'])) {
            $this->setPassword($data['password']);
        }
    }

    /**
     * @return array
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
