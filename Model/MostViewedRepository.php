<?php

namespace MMA\CustomApi\Model;

use MMA\CustomApi\Api\MostViewedRepositoryInterface;

class MostViewedRepository extends ProductRepository implements MostViewedRepositoryInterface {

    /**
     * @inheritDoc
     */
    public function getList($limit = 10)
    {
        $collection = $this->getProductCollection()
            ->setPageSize($limit);

        $collection->load();
        $collection->addCategoryIds();
        // TODO: add cache here for products as in ProductRepository

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->count());

        return $searchResults;
    }
}