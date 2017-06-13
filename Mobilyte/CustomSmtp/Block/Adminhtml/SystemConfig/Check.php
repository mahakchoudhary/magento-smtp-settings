<?php

namespace Mobilyte\CustomSmtp\Block\Adminhtml\SystemConfig;

use \Magento\Framework\UrlInterface;


class Check extends \Magento\Config\Block\System\Config\Form\Field
{
    /*
    * @var UrlInterface 
    */
    protected $_urlInterface;
    
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        array $data = []
    ) {
        $this->_urlInterface = $context->getUrlBuilder();
        parent::__construct($context, $data);
    }

    /**
     * Set template
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('Mobilyte_CustomSmtp::systemConfig/check.phtml');
    }
    
    /**
     * @return ajax action url
     */   
    public function getTestMailUrl(){
        return $this->_urlInterface->getUrl('mobilytecustomsmtp/check/testmail', array('store' => $this->_request->getParam('store')));
    }

    /**
     * @param  \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        // Remove scope label
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    /**
     * Return element html
     * @param  \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        return $this->_toHtml();
    }

    /**
     * Get configuration test button html
     * @return html
     */
    public function getBlockBtnHtml()
    {
        $html = $this->getLayout()->createBlock('Magento\Backend\Block\Widget\Button')
    			->setData(array(
                	'label' => __('Send Test Email'),
    				'id' => 'mobilytecustomsmtp_debug_result_button',
                	'onclick' => 'javascript:MobilyteCustomSmtpDebugTest(); return false;',
            		)
        		);

        return $html->toHtml();
    }
}