<?php

namespace MMA\CustomApi\Model;

use MMA\CustomApi\Api\MostViewedRepositoryInterface;

class MostViewedRepository extends ProductRepository implements MostViewedRepositoryInterface {

    /**
     * @inheritDoc
     */
    public function getList($limit = 10)
    {
        $storeId = $this->storeManager->getStore()->getId();
        $collection = $this->productsFactory->create()
            ->addAttributeToSelect('*')
            ->addViewsCount()->setStoreId($storeId)
            ->setVisibility(
                [
                    \Magento\Catalog\Model\Product\Visibility::VISIBILITY_IN_CATALOG,
                    \Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH
                ]
            )
            ->addStoreFilter($storeId)
            ->setPageSize($limit);

        // TODO: add cache here for products as in ProductRepository

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->count());

        return $searchResults;
    }
}