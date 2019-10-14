<?php

namespace MMA\CustomApi\Model\Data;

use MMA\CustomApi\Api\Data\ResponseInterface;
use Magento\Framework\Model\AbstractModel;

class ResponseModel extends AbstractModel implements ResponseInterface {
    const KEY_STATUS = 'status';
    const KEY_MESSAGE = 'message';

    /**
     * @inheritDoc
     */
    public function getStatus()
    {
        return $this->_getData(self::KEY_STATUS);
    }

    /**
     * @inheritDoc
     */
    public function setStatus($status)
    {
        return $this->setData(self::KEY_STATUS, $status);
    }

    /**
     * @inheritDoc
     */
    public function getMessage()
    {
        return $this->_getData(self::KEY_MESSAGE);
    }

    /**
     * @inheritDoc
     */
    public function setMessage($message)
    {
        return $this->setData(self::KEY_MESSAGE, $message);
    }
}