<?php

namespace MMA\CustomApi\Model;

use Magento\Framework\App\ProductMetadataInterface;

class Version implements \MMA\CustomApi\Api\VersionInterface {
    /**
     * @var ProductMetadataInterface
     */
    protected $productMetadata;

    /**
     * @param ProductMetadataInterface $productMetadata
     */
    public function __construct(ProductMetadataInterface $productMetadata)
    {
        $this->productMetadata = $productMetadata;
    }

    /**
     * @inheritdoc
     * @throws \Exception
     */
    public function getVersion() {
        $version = $this->productMetadata->getVersion();
        return $version;
    }
}