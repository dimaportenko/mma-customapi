<?php
/**
 * Created by PhpStorm.
 * User: Dmytro Portenko
 * Date: 8/4/18
 * Time: 2:03 PM
 */

namespace MMA\CustomApi\Model;

class CategoryManagement extends \Magento\Catalog\Model\CategoryManagement
    implements \MMA\CustomApi\Api\CategoryManagementInterface
{
    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * @var \MMA\CustomApi\Model\Category\Tree
     */
    protected $categoryTree;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
     */
    private $categoriesFactory;

    /**
     * @param \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository
     * @param \MMA\CustomApi\Model\Category\Tree $categoryTree
     * @param \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoriesFactory
     */
    public function __construct(
        \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository,
        \MMA\CustomApi\Model\Category\Tree $categoryTree,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoriesFactory
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->categoryTree = $categoryTree;
        $this->categoriesFactory = $categoriesFactory;
    }


}