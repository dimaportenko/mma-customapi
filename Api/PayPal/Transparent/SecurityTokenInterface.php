<?php

namespace MMA\CustomApi\Api\PayPal\Transparent;

interface SecurityTokenInterface {

    /**
     * @param string $result
     * @return void
     */
    public function setResult($result);

    /**
     * @return string
     */
    public function getResult();

    /**
     * @param string $securetoken
     * @return void
     */
    public function setSecuretoken($securetoken);

    /**
     * @return string
     */
    public function getSecuretoken();

    /**
     * @param string $securetokenid
     * @return void
     */
    public function setSecuretokenid($securetokenid);

    /**
     * @return string
     */
    public function getSecuretokenid();

    /**
     * @param string $respmsg
     * @return void
     */
    public function setRespmsg($respmsg);

    /**
     * @return string
     */
    public function getRespmsg();

    /**
     * @param string $resultCode
     * @return void
     */
    public function setResultCode($resultCode);

    /**
     * @return string
     */
    public function getResultCode();

}
