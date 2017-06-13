<?php
namespace Mobilyte\CustomSmtp\Controller\Adminhtml\Check;

class Testmail extends \Magento\Backend\App\Action
{

    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;
    
    /**
     * @var Data
     */
    protected $helper;

    /**
     * @param Magento\Backend\App\Action\Context $context
     * @param Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param Mobilyte\CustomSmtp\Helper\Data $helper
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Mobilyte\CustomSmtp\Helper\Data $helper
    ) {
        $this->_resultPageFactory = $resultPageFactory;
        $this->helper = $helper;
        parent::__construct($context);
        
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute() {

        $name       = 'Mobilyte Custom SMTP Test Email';
        $request    = $this->getRequest();
        $store_id   = $request->getParam('store', null);

        $uname      = $request->getPost('uname');
        $pass       = $request->getPost('pass');
        $to         = $request->getPost('email') ? $request->getPost('email') : $uname;
        $host       = $request->getPost('host');
        $auth       = strtolower($request->getPost('auth'));
        $sslType    = $request->getPost('ssltype');
        $port       = $request->getPost('port');


        if(!$request->getParam('store', false)){
            if(empty($uname) || empty($pass)){
                $this->getResponse()->setBody(__('Invalid or blank username/password'));
                return;
            }
        }

        $pass = ($pass == '******') ? $this->helper->getConfigPassword($store_id) : $pass;
        
        $smtpConf = array(
            'auth' => $auth,
            'ssl' => $sslType,
            'username' => $uname,
            'password' => $pass,
            'port' => $port
        );

        $transport = new \Zend_Mail_Transport_Smtp($host, $smtpConf);
        
        //sending email
        $testMail = new \Zend_Mail();
        $testMail->setFrom($uname, $name);
        $testMail->setSubject('Test SMTP Email from Mobilyte');
        $testMail->addTo($to, $to);
        $testMail->setBodyText('Thank you for choosing Mobilyte SMTP Settings Extension.');
        
        try {
            if (!$testMail->send($transport) instanceof \Zend_Mail){}
            $result = __('Test Email send to you. Please check your email account : ') . $to;
        } catch (\Exception $e) {
            $result = __($e->getMessage());
        }
        $this->getResponse()->setBody($result);
    }
    
    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Mobilyte_CustomSmtp');
    }
}