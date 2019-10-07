<?php

namespace MMA\CustomApi\Api;

interface ReviewInterface
{
    /**
     * Return Added review item.
     *
     * @param int $productId
     * @return array
     *
     */
    public function getReviewsList($productId);

    /**
     * Return Rating options.
     *
     * @param int $storeId
     * @return array
     *
     */
    public function getRatings($storeId = null);

    /**
     * Added review and rating for the product.
     * @param int $productId
     * @param string $title
     * @param string $nickname
     * @param string $detail
     * @param MMA\CustomApi\Api\Data\RatingInterface[] $ratingData
     * @param int $customer_id
     * @param int $store_id
     * @return boolean
     *
     */
    public function writeReviews(
        $productId,
        $nickname,
        $title,
        $detail,
        $ratingData,
        $customer_id = null
    );
}