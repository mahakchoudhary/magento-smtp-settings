<?php
namespace Mobilyte\CustomSmtp\Model\Config;
class Authentication implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
 
    public function toOptionArray()
    {
 
        return array(
            array('value' => 'ssl', 'label' => 'SSL'),
            array('value' => 'tls', 'label' => 'TLS')
        );

    }
}