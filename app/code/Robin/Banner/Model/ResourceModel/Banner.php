<?php

namespace Robin\Banner\Model\ResourceModel;

class Banner extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    protected function _construct()
    {
        // Table name + primary key column
        $this->_init('banner', 'id');
    }

    protected function _afterSave(\Magento\Framework\Model\AbstractModel $object)
    {
        // Get image data before and after save
        $oldImage = $object->getOrigData('image');
        $newImage = $object->getData('image');

        // Check when new image uploaded
        if ($newImage != null && $newImage != $oldImage) {
            $imageUploader = \Magento\Framework\App\ObjectManager::getInstance()
                ->get('Robin\Banner\BannerImageUpload');
            $imageUploader->moveFileFromTmp($newImage);
        }

        return $this;
    }

}