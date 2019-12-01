<?php

namespace MMA\CustomApi\Model\PayPal\Transparent;

use Magento\Framework\Model\AbstractModel;
use MMA\CustomApi\Api\PayPal\Transparent\SecurityTokenInterface;

class SecureToken extends AbstractModel implements SecurityTokenInterface
{
    const KEY_RESULT = 'result';
    const KEY_SECURETOKEN = 'securetoken';
    const KEY_SECURETOKENID = 'securetokenid';
    const KEY_RESPMSG = 'respmsg';
    const KEY_RESULT_CODE = 'result_code';

    /**
     * @inheritDoc
     */
    public function setResult($result)
    {
        return $this->setData(self::KEY_RESULT, $result);
    }

    /**
     * @inheritDoc
     */
    public function getResult()
    {
        return $this->_getData(self::KEY_RESULT);
    }

    /**
     * @inheritDoc
     */
    public function setSecuretoken($securetoken)
    {
        return $this->setData(self::KEY_SECURETOKEN, $securetoken);
    }

    /**
     * @inheritDoc
     */
    public function getSecuretoken()
    {
        return $this->_getData(self::KEY_SECURETOKEN);
    }

    /**
     * @inheritDoc
     */
    public function setSecuretokenid($securetokenid)
    {
        return $this->setData(self::KEY_SECURETOKENID, $securetokenid);
    }

    /**
     * @inheritDoc
     */
    public function getSecuretokenid()
    {
        return $this->_getData(self::KEY_SECURETOKENID);
    }

    /**
     * @inheritDoc
     */
    public function setRespmsg($respmsg)
    {
        return $this->setData(self::KEY_RESPMSG, $respmsg);
    }

    /**
     * @inheritDoc
     */
    public function getRespmsg()
    {
        return $this->_getData(self::KEY_RESPMSG);
    }

    /**
     * @inheritDoc
     */
    public function setResultCode($resultCode)
    {
        return $this->setData(self::KEY_RESULT_CODE, $resultCode);
    }

    /**
     * @inheritDoc
     */
    public function getResultCode()
    {
        return $this->_getData(self::KEY_RESULT_CODE);
    }
}