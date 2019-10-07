<?php
namespace MMA\CustomApi\Model\Review;

use MMA\CustomApi\Api\ReviewInterface;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Review\Model\Review;

class ReviewManagement implements ReviewInterface
{

    /**
     * Review collection
     *
     * @var ReviewCollection
     */
    protected $_reviewsCollection;

    /**
     * Review resource model
     *
     * @var \Magento\Review\Model\ResourceModel\Review\CollectionFactory
     */
    protected $_reviewsColFactory;

    /**
     * Review table
     *
     * @var string
     */
    protected $_reviewTable;

    /**
     * Review Detail table
     *
     * @var string
     */
    protected $_reviewDetailTable;

    /**
     * Review status table
     *
     * @var string
     */
    protected $_reviewStatusTable;

    /**
     * Review entity table
     *
     * @var string
     */
    protected $_reviewEntityTable;

    /**
     * Review store table
     *
     * @var string
     */
    protected $_reviewStoreTable;

    /**
     * Review aggregate table
     *
     * @var string
     */
    protected $_aggregateTable;
    /**
     * Core date model
     *
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_date;
    /**
     * Rating model
     *
     * @var \Magento\Review\Model\RatingFactory
     */
    protected $_ratingFactory;
    /**
     * Review model
     *
     * @var \Magento\Review\Model\ReviewFactory
     */
    protected $_reviewFactory;
    /**
     * Rating resource model
     *
     * @var \Magento\Review\Model\ResourceModel\Rating\Option
     */
    protected $_ratingOptions;
    /**
     * Cache of deleted rating data
     *
     * @var array
     */
    private $_deleteCache = [];

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;


    public function __construct(
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Review\Model\RatingFactory $ratingFactory,
        \Magento\Review\Model\ReviewFactory $reviewFactory,
        \Magento\Review\Model\ResourceModel\Review\CollectionFactory $collectionFactory,
        \Magento\Review\Model\Rating\Option $ratingOptions,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {

        $this->_date = $date;
        $this->_reviewsColFactory = $collectionFactory;
        $this->_ratingFactory = $ratingFactory;
        $this->_reviewFactory = $reviewFactory;
        $this->_ratingOptions = $ratingOptions;
        $this->_storeManager = $storeManager;
    }

    /**
     * Get reviews of the product
     * @param int $productId
     * @return array|bool
     */

    public function getReviewsList($productId)
    {
        if (null === $this->_reviewsCollection) {
            $this->_reviewsCollection = $this->_reviewsColFactory->create()
                ->addStatusFilter(
                    \Magento\Review\Model\Review::STATUS_APPROVED
                )->addEntityFilter(
                    'product',
                    $productId
                )->setDateOrder();
        }
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $storeId = $objectManager->get
        ('\Magento\Store\Model\StoreManager')->getStore()->getId();
        $product = $objectManager->get('Magento\Catalog\Model\Product')
            ->load($productId);
        $this->_reviewFactory->create()->getEntitySummary($product,
            $storeId);//$this->_storeManager->getStore()->getId());
        $ratingSummary = $product->getRatingSummary()->getRatingSummary();
        $reviewArray = [];
        $reviewCollection = $this->_reviewsCollection;
        $collection = $reviewCollection->load()->addRateVotes();
        $count = count($collection);
        foreach ($collection as $reviewCollection) {
            $rating = $reviewCollection->getRatingVotes()->getData();
            $data = [
                "review_id"       => $reviewCollection->getReviewId(),
                "created_at"      => $reviewCollection->getCreatedAt(),
                "entity_id"       => $reviewCollection->getEntityId(),
                "entity_pk_value" => $reviewCollection->getEntityPkValue(),
                "status_id"       => $reviewCollection->getStatusId(),
                "detail_id"       => $reviewCollection->getDetailId(),
                "title"           => $reviewCollection->getTitle(),
                "detail"          => $reviewCollection->getDetail(),
                "nickname"        => $reviewCollection->getNickname(),
                "customer_id"     => $reviewCollection->getCustomerId(),
                "entity_code"     => $reviewCollection->getEntityCode(),
                "title"           => $reviewCollection->getTitle(),
                "rating_votes"    => $rating
            ];
            $reviewArray[] = $data;
        }
        $reviewData[] = [
            "avg_rating_percent" => $ratingSummary,
            "count"              => $count,
            "reviews"            => $reviewArray
        ];

        return $reviewData;
    }

    /**
     * Return Rating options.
     *
     * @param int $storeId
     * @return array
     *
     */
    public function getRatings($storeId = null){
        $ratingCollection = $this->_ratingFactory->create()->getCollection();
        $ratingCollection->addFieldToFilter('store_id', [
            'eq' => $storeId
        ]);
        $ratingCollection->join(
            ['rating_store'=>'rating_store'],
            'main_table.rating_id = rating_store.rating_id'
        );

        return $ratingCollection->getData();
    }

    /**
     * Added review and rating for the product.
     * @param int $productId
     * @param string $title
     * @param string $nickname
     * @param string $detail
     * @param MMA\CustomApi\Api\Data\RatingInterface[] $ratingData
     * @param int $customer_id
     * @param int $store_id
     *
     * @return array
     */
    public function writeReviews(
        $productId,
        $nickname,
        $title,
        $detail,
        $ratingData,
        $customer_id = null
    ) {
        $storeId = $this->_storeManager->getStore()->getId();

        $data = [
            "nickname" => $nickname,
            "title"    => $title,
            "detail"   => $detail
        ];

        if(empty($title)){
            throw new InputException(__('Not a valid Title'));
        }

        $ratings = [];
        if(empty($ratingData)){
            throw new InputException(__('Not a valid rating data'));
        }
        //map vote option id with the star value
        foreach ($ratingData as $rating){
            $ratings[$rating->getRatingId()] = $this->getVoteOption($rating->getRatingId(), $rating->getRatingValue());
        }

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $product = $objectManager
            ->get('Magento\Catalog\Model\Product')->load($productId);
        if(!$product->getId()){
            throw new NoSuchEntityException(__('Product doesn\'t exist'));
        }
        if (($product) && !empty($data)) {
            $review = $this->_reviewFactory->create()->setData($data);
            $review->unsetData('review_id');

            $validate = $review->validate();
            if ($validate === true) {
                try {
                    $review->setEntityId($review
                        ->getEntityIdByCode(Review::ENTITY_PRODUCT_CODE))
                        ->setEntityPkValue($product->getId())
                        ->setStatusId(Review::STATUS_PENDING)
                        ->setCustomerId($customer_id)
                        ->setStoreId($storeId)
                        ->setStores([$storeId])
                        ->save();
                    if(count($ratings)) {
                        foreach ($ratings as $ratingId => $optionId) {
                            $this->_ratingFactory->create()
                                ->setRatingId($ratingId)
                                ->setReviewId($review->getId())
                                ->setCustomerId($customer_id)
                                ->addOptionVote($optionId, $product->getId());
                        }
                    }

                    $review->aggregate();
                    $status = true;
                    $message = 'You submitted your review for moderation.';
                } catch (\Exception $e) {
                    $message = 'We can\'t post your review right now. '.$e->getMessage();
                    $status = false;
                }
            }
        }
        $response[] = [
            "status"  => $status,
            "message" => $message
        ];

        return $response;
    }

    public function getVoteOption($ratingId, $value){
        $optionId = 0;
        $ratingOptionCollection = $this->_ratingOptions->getCollection()
            ->addFieldToFilter('rating_id', $ratingId)
            ->addFieldToFilter('value', $value);
        if(count($ratingOptionCollection)){
            foreach ($ratingOptionCollection as $row) {
                $optionId = $row->getOptionId();
            }
        }
        return $optionId;
    }
}

