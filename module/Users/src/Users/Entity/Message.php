<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 19.08.18
 * Time: 14:05
 */

namespace Users\Entity;

/**
 * Class Message
 * @package Users\Entity
 */
class Message
{
    /** @var int $id */
    public $id;

    /** @var string $user_id */
    public $user_id;

    /** @var string $message */
    public $message;

    /** @var string $time */
    public $time;

    /**
     * @param array $data
     */
    public function exchangeArray(array $data)
    {
        if (isset($data['id'])) {
            $this->id = $data['id'];
        }

        if (isset($data['user_id'])) {
            $this->user_id = $data['user_id'];
        }

        if (isset($data['message'])) {
            $this->message = $data['message'];
        }

        if (isset($data['time'])) {
            $this->time = $data['time'];
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
