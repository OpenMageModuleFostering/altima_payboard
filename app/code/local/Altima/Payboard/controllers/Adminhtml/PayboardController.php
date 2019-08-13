<?php

/**
 * Altima Payboard Conversion Optimisation Extension
 *
 * Altima web systems.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is available through the world-wide-web at this URL:
 * http://blog.altima.net.au/lookbook-magento-extension/lookbook-professional-licence/
 *
 * @category   Altima
 * @package    Altima_Payboard
 * @author     Altima Web Systems http://altimawebsystems.com/
 * @license    http://blog.altima.net.au/lookbook-magento-extension/lookbook-professional-licence/
 * @email      support@altima.net.au
 * @copyright  Copyright (c) 2012 Altima Web Systems (http://altimawebsystems.com/)
 */
class Altima_Payboard_Adminhtml_PayboardController extends Mage_Adminhtml_Controller_Action {

    /**
     * constructor - set the used module name
     *
     * @access protected
     * @return void
     * @see Mage_Core_Controller_Varien_Action::_construct()
     */
    protected function _construct() {
        $this->setUsedModuleName('Altima_Payboard');
    }

    /**
     * default action for payboard controller
     *
     * @access public
     * @return bool
     */
    public function indexAction() {
        $this->loadLayout()->renderLayout();
    }

    /**
     * post payboard action
     *
     * @access public
     * @return void
     */
    public function postAction() {
        $post = $this->getRequest()->getPost();
        try {
            if (empty($post)) {
                Mage::throwException($this->__('Invalid form data.'));
            }
            $payboardKey = $this->getRequest()->getParam('api_key');
            $accept = $this->getRequest()->getParam('accept');
            if ($accept !== 'accept'){
                Mage::throwException($this->__('To use this extension you need to accept Terms of Service and Privacy Policy.'));
            }
            $valid_key = Mage::helper('altima_payboard')->checkKey($payboardKey);
            if ($valid_key === false) {
                Mage::throwException($this->__('Invalid key. Please insert valid Api Key!'));
            }
            Mage::getModel('core/config')->saveConfig('payboard/general/apikey', $payboardKey);
            $apiUrl = 'd3px1qgagsf6ei.cloudfront.net/Scripts/' . $payboardKey;

            $message = $this->__('Your key has been submitted successfully.');
            Mage::getSingleton('adminhtml/session')->addSuccess($message);
            Mage::helper('altima_payboard')->sendEmail($payboardKey);
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('*/*');
    }

    /**
     * restrict access
     *
     * @access protected
     * @return bool
     * @see Mage_Adminhtml_Controller_Action::_isAllowed()
     */
    protected function _isAllowed() {
        return Mage::getSingleton('admin/session')->isAllowed('altima_payboard/payboard');
    }

}
