<?php

namespace MMA\CustomApi\Model;

use MMA\CustomApi\Api\TopRatedRepositoryInterface;

class TopRatedRepository extends ProductRepository implements TopRatedRepositoryInterface {

    /**
     * @inheritDoc
     */
    public function getList($limit = 10)
    {
        $collection = $this->getProductCollection();
        $collection->setPageSize(
            $limit
        )->setCurPage(
            1
        )->getSelect()
            ->from(
                ['review_entity_summary' => $collection->getTable('review_entity_summary')],
                ['summary' => 'SUM(review_entity_summary.rating_summary)']

            )->where('e.entity_id = review_entity_summary.entity_pk_value'
            )->group(
                'review_entity_summary.entity_pk_value'
            )->order(
                'summary ' . \Magento\Framework\DB\Select::SQL_DESC
            )->having(
                'SUM(review_entity_summary.rating_summary) > ?',
                0
            );

        $collection->load();
        $collection->addCategoryIds();
        // TODO: add cache here for products as in ProductRepository

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->count());

        return $searchResults;
    }
}