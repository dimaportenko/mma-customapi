<?php

namespace MMA\CustomApi\Api;

interface MostViewedRepositoryInterface {

    /**
     * Get most viewed products
     *
     * @param int $limit
     * @return \Magento\Catalog\Api\Data\ProductSearchResultsInterface
     */
    public function getList($limit = 10);
}