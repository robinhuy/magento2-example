<?php

namespace Robin\Banner\Model;

class Banner extends \Magento\Framework\Model\AbstractModel
{

    protected function _construct()
    {
        $this->_init('Robin\Banner\Model\ResourceModel\Banner');
    }

}