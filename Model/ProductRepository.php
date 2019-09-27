<?php

namespace MMA\CustomApi\Model;

class ProductRepository {

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
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $localeDate;


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
        \Magento\Catalog\Api\Data\ProductSearchResultsInterfaceFactory $searchResultsFactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate
    ) {
        $this->productsFactory = $productsFactory;
        $this->storeManager = $storeManager;
        $this->productRepository = $productRepository;
        $this->searchResultsFactory  = $searchResultsFactory;
        $this->localeDate = $localeDate;
    }

    public function getProductCollection() {
        $storeId = $this->storeManager->getStore()->getId();
        $collection = $this->productsFactory->create()
            ->addAttributeToSelect('*')
            ->setVisibility(
                [
                    \Magento\Catalog\Model\Product\Visibility::VISIBILITY_IN_CATALOG,
                    \Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH
                ]
            )
            ->addMinimalPrice()
            ->addFinalPrice()
            ->addTaxPercents()
//            ->addAttributeToSelect($this->catalogConfig->getProductAttributes())
            ->setStoreId($storeId)
//            ->addStoreFilter();
            ->addStoreFilter($storeId);
        return $collection;
    }

    /**
     * Predefined collection
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    protected function _getProductCollection($categoryId = false)
    {
        /** @var $collection \Magento\Catalog\Model\ResourceModel\Product\Collection */
        $collection = $this->productsFactory->create();
        $collection->setVisibility($this->_catalogProductVisibility->getVisibleInCatalogIds());

        $collection = $this->_addProductAttributesAndPrices($collection)->addStoreFilter();

        if($categoryId){
            /** @var \Magento\Catalog\Model\ResourceModel\Category\Collection $categories */
            $collection->addCategoriesFilter(['eq'  => $categoryId]);
            $collection->addAttributeToSort('category_id');
        }

        return $collection;
    }
}