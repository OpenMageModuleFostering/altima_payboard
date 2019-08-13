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
class Altima_Payboard_Helper_Data extends Mage_Core_Helper_Abstract {

    public function convertOptions($options) {
        $converted = array();
        foreach ($options as $option) {
            if (isset($option['value']) && !is_array($option['value']) &&
                    isset($option['label']) && !is_array($option['label'])) {
                $converted[$option['value']] = $option['label'];
            }
        }
        return $converted;
    }

    public function getEnabled() {
        $key = Mage::getStoreConfig('payboard/general/apikey');
        if (!empty($key)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getApikey() {
        return Mage::getStoreConfig('payboard/general/apikey');
    }

    public function checkKey($key) {
        $url = 'http://d3px1qgagsf6ei.cloudfront.net/Scripts/' . $key;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
// $retcode > 400 -> not found, $retcode = 200, found. 
        curl_close($ch);
        if ($retcode == 200) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function sendEmail($key, $event = 'activated') {
        $storeId = Mage::app()->getStore()->getId();
        $senderName = Mage::getStoreConfig('trans_email/ident_general/name', $storeId);
        $senderEmail = Mage::getStoreConfig('trans_email/ident_general/email', $storeId);
        $storeUrl = Mage::getBaseUrl('web');
        if ($event == 'installed') {
            $message = 'Altima Payboard Conversion Optimisation Extension ' . $event . '.<br/>'
                    . 'Store url: ' . $_SERVER[HTTP_HOST] . '<br/>';
            $senderName = $_SERVER[HTTP_HOST];
        } else {
            $message = 'Altima Payboard Conversion Optimisation Extension ' . $event . '.<br/>'
                    . 'Store url: ' . $storeUrl . '<br/>'
                    . 'Store name: ' . $senderName . '<br/>'
                    . 'Store mail: ' . $senderEmail . '<br/>'
                    . 'Api key: ' . $key;
        }
        $mail = Mage::getModel('core/email');
        $mail->setToName('Payboard Group');
        $mail->setToEmail('payboard@altima.net.au');
        //$mail->setToEmail('andrey.stepin@altima.com.ua');
        $mail->setBody($message);
        $mail->setSubject('Payboard');
        $mail->setFromEmail($senderEmail);
        $mail->setFromName($senderName);
        $mail->setType('html'); // YOu can use Html or text as Mail format
        $mail->send();
    }

}
