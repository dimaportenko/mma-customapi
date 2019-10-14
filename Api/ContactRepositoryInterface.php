<?php

namespace MMA\CustomApi\Api;

interface ContactRepositoryInterface {

    /**
     * @param string $name
     * @param string $comment
     * @param string $phone
     * @param string $email
     * @return \MMA\CustomApi\Api\Data\ResponseInterface
     */
    public function contact($name, $comment, $phone, $email);
}