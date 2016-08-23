<?php

namespace Robin\Banner\Block\Banner;

use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Widget\Block\BlockInterface;
use Robin\Banner\Model\ResourceModel\Banner\CollectionFactory;

class BannerWidget extends Template implements BlockInterface
{

    protected $bannerCollectionFactory;

    public function __construct(
        Template\Context $context,
        array $data,
        CollectionFactory $bannerCollectionFactory)
    {
        $this->setTemplate('widget.phtml');
        $this->bannerCollectionFactory = $bannerCollectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * Set data to View
     */
    protected function _beforeToHtml()
    {
        // Init collection
        $collection = $this->bannerCollectionFactory->create();

        // Get enabled images
        $banners = $collection->addFieldToFilter('status', ['eq' => true])->getData();

        // Set data
        $this->setData('banners', $banners);
        $this->setData('mediaURL', $this->_storeManager->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'banner/images/');

        // Return to View
        return parent::_beforeToHtml();
    }

}