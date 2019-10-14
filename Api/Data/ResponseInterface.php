<?php

namespace MMA\CustomApi\Api\Data;

interface ResponseInterface {
    /**
     * @return bool
     */
    public function getStatus();

    /**
     * @param string $status
     * @return void
     */
    public function setStatus($status);

    /**
     * @return string
     */
    public function getMessage();

    /**
     * @param string $message
     * @return void
     */
    public function setMessage($message);
}
