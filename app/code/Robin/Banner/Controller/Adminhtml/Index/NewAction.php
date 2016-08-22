<?php

namespace Robin\Banner\Controller\Adminhtml\Index;

class NewAction extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Robin_Banner::save';

    protected $resultForwardFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
    ) {
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        // Forward to Edit page
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}
