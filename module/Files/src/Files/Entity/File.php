<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 08.07.18
 * Time: 18:33
 */

namespace Files\Entity;

/**
 * Class File
 * @package Files\Entity
 */
class File
{
    /**
     * @param $data
     */
    public function exchangeArray($data)
    {
        foreach ($data as $key => $val) {
            $this->$key = $val;
        }
    }
}
