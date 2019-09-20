<?php

namespace MMA\CustomApi\Api;

/**
 * Interface Version
 * @api
 */
interface VersionInterface
{
    /**
     * Generate a new client token if necessary
     * @return string
     */
    public function getVersion();
}