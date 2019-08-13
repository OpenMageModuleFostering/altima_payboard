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
class Altima_Payboard_Block_Payboardjs extends Mage_Core_Block_Template {

    public function _toHtml() {
        $helper = Mage::helper('altima_payboard');
        $message = false;
        $key = $helper->getApikey();
        $key_valid = $helper->checkKey($key);
        if ($key_valid) {
            $output = '        
<!-- Begin Payboard Script -->
<script type="text/javascript">
    var payboardCallback = function() {
        Payboard.Events.trackPage();
    };
    var payboardScript = document.createElement("script");
    payboardScript.src = "//d3px1qgagsf6ei.cloudfront.net/Scripts/' . $key . '";
    if (payboardScript.addEventListener) {
        payboardScript.addEventListener("load", payboardCallback, false);
    } else if (payboardScript.readyState) {
        payboardScript.onreadystatechange = payboardCallback;
    }
    document.body.appendChild(payboardScript);
</script>
<!-- End Payboard Script -->
        ';
        } else {
            $output = '';
        }
        return $output;
    }

}
