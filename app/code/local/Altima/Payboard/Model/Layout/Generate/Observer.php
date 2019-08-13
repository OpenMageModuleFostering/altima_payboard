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
class Altima_Payboard_Model_Layout_Generate_Observer {

    public function includeJavascripts($observer) {
        $helper = Mage::helper('altima_payboard');
        if ($helper->getEnabled()) {
            $layout = Mage::app()->getLayout();
            $content = $layout->getBlock('footer');
            $block = $layout->createBlock('altima_payboard/payboardjs');
            $content->insert($block);
        }
    }

}
