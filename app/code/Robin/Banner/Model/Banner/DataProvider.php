<?php

namespace Robin\Banner\Model\Banner;

use Robin\Banner\Model\ResourceModel\Banner\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    protected $collection;
    protected $dataPersistor;
    protected $loadedData;
    protected $storeManager;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $bannerCollectionFactory,
        DataPersistorInterface $dataPersistor,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $bannerCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->storeManager = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->meta = $this->prepareMeta($this->meta);
    }

    /**
     * Prepares Meta
     */
    public function prepareMeta(array $meta)
    {
        return $meta;
    }

    /**
     * Get data
     */
    public function getData()
    {
        // Get items
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();

        
        foreach ($items as $banner) {
            $data = $banner->getData();
            $image = $data['image'];
            if ($image && is_string($image)) {
                $data['images'][0]['name'] = $image;
                $data['images'][0]['url'] = $this->storeManager->getStore()
                        ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)
                    . 'banner/images/' . $image;
            }

            $this->loadedData[$banner->getId()] = $data;
        }

        $data = $this->dataPersistor->get('banner');
        if (!empty($data)) {
            $banner = $this->collection->getNewEmptyItem();
            $banner->setData($data);
            $this->loadedData[$banner->getId()] = $banner->getData();
            $this->dataPersistor->clear('banner');
        }

        return $this->loadedData;
    }
}
