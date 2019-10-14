<?php

namespace MMA\CustomApi\Model;

use MMA\CustomApi\Api\BestSellerRepositoryInterface;

class BestSellerRepository extends ProductRepository implements BestSellerRepositoryInterface {

    /**
     * @inheritDoc
     */
    public function getList($limit = 10)
    {
        $collection = $this->getProductCollection();
        $connection = $collection->getConnection();
        $orderTableAliasName = $connection->quoteIdentifier('order');
        $orderJoinCondition = [
            $orderTableAliasName . '.entity_id = order_items.order_id',
            $connection->quoteInto("{$orderTableAliasName}.state <> ?", \Magento\Sales\Model\Order::STATE_CANCELED),
        ];

        $collection->setPageSize(
            $limit
        )->setCurPage(
            1
        )->getSelect()
            ->from(
                ['order_items' => $collection->getTable('sales_order_item')],
                ['ordered_qty' => 'SUM(order_items.qty_ordered)','product_id']
            )->joinInner(
                ['order' => $collection->getTable('sales_order')],
                implode(' AND ', $orderJoinCondition),
                []
            )->where(
                'e.entity_id = order_items.product_id and parent_item_id IS NULL'
            )->group(
                'order_items.product_id'
            )->order(
                'ordered_qty ' . \Magento\Framework\DB\Select::SQL_DESC
            )->having(
                'SUM(order_items.qty_ordered) > ?',
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