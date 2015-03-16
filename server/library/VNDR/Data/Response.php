<?php
/**
 * Created by PhpStorm.
 * User: aramiszrobert
 * Date: 15. 01. 16.
 * Time: 20:49
 */

namespace VNDR\Data;

class Response {

    protected $data = array();
    protected $outcome = false;
    protected $message = "";

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getOutcome()
    {
        return $this->outcome;
    }

    /**
     * @param mixed $outcome
     */
    public function setOutcome($outcome)
    {
        $this->outcome = $outcome;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message = "")
    {
        $this->message = $message;
    }

    /**
     * Return object to array
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            "data" => $this->getData(),
            "outcome" => $this->getOutcome(),
            "message" => $this->getMessage()
        );
    }



}