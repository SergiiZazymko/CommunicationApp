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
        $this->name = $data['name'] ?? null;
        $this->email = $data['email'] ?? null;
        if (isset($data['password'])) {
            $this->setPassword($data['password']);
        }
    }
}
