<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace MMA\CustomApi\Api;


/**
 * Gateway vault payment token repository interface.
 *
 * @api
 * @since 100.1.0
 */
interface PaymentTokenManagementInterface extends \Magento\Vault\Api\PaymentTokenManagementInterface
{
    /**
     * @param string $publicHash payment token hash.
     * @param int $customerId Customer ID.
     * @return string
     */
    public function getPaymentNonce($publicHash, $customerId);
}
