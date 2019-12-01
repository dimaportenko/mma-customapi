<?php

namespace MMA\CustomApi\Api\PayPal\Transparent;

interface SecurityTokenManagerInterface {

    /**
     * Set category name
     *
     * @param int $quoteId
     * @return MMA\CustomApi\Api\PayPal\Transparent\SecurityTokenInterface
     */
    public function getSecurityToken($quoteId);
}
