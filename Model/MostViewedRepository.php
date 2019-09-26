<?php

namespace MMA\CustomApi\Model;

class MostViewedRepository {

    /**
     * @var \Magento\Reports\Model\ResourceModel\Product\CollectionFactory
     */
    protected $productsFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var \Magento\Catalog\Api\Data\ProductSearchResultsInterfaceFactory $searchResultsFactory
     */
    protected $searchResultsFactory;


    /**
     * @param \Magento\Reports\Model\ResourceModel\Product\CollectionFactory $productsFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \Magento\Catalog\Api\Data\ProductSearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        \Magento\Reports\Model\ResourceModel\Product\CollectionFactory $productsFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Catalog\Api\Data\ProductSearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->productsFactory = $productsFactory;
        $this->storeManager = $storeManager;
        $this->productRepository = $productRepository;
        $this->searchResultsFactory  = $searchResultsFactory;
    }

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