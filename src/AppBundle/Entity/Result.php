<?php

namespace AppBundle\Entity;
/**
 * Created by PhpStorm.
namespace Services\Bundle\Rest\Entity;

/**
 * This class contains the format for the json response
 *
 * Class Result
 * @package AppBundle\Entity
 */
class Result
{

    /**
     * contain information if there is been an error
     *
     * @var boolean
     */
    private $success;

    /**
     * contain the message
     *
     * @var string
     */
    private $message;


    /**
     * this contains the information, the core
     *
     * @var
     */
    private $items;

    /**
     * this contains the possible error code
     *
     * @var
     */
    private $errorCode;

    /**
     * get success value
     *
     * @return boolean
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * set success value
     *
     * @param boolean $success
     */
    public function setSuccess($success)
    {
        $this->success = $success;
    }

    /**
     * get messagge
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * set message
     *
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }


    /**
     * get items
     *
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * set items
     *
     * @param mixed $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * get error code
     *
     * @return mixed
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * set error code
     *
     * @param mixed $errorCode
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
    }


}