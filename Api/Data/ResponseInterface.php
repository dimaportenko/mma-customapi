<?php

namespace MMA\CustomApi\Api\Data;

interface ResponseInterface {
    /**
     * return bool
     */
    public function getStatus();

    /**
     * @param string $status
     */
    public function setStatus($status);

    /**
     * return string
     */
    public function getMessage();

    /**
     * @param string $message
     */
    public function setMessage($message);
}
