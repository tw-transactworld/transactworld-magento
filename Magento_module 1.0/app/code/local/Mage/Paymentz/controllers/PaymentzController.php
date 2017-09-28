<?php

/**
 * ************************************************************************************
  Please Do not edit or add any code in this file without permission of paymentz.com.
  @Developed by paymentz.com

  Magento version 1.9.0.1                 Paymentz Version 1.0

  Module Version. pz-1.0                 Module release: May 2017
 * *************************************************************************************
 */

/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Mage
 * @package    Mage_Paymentz
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Mage_Paymentz_PaymentzController extends Mage_Core_Controller_Front_Action {

    protected $_order;

    public function getOrder() {
        if ($this->_order == null) {
            
        }
        return $this->_order;
    }

    protected function _expireAjax() {
        if (!Mage::getSingleton('checkout/session')->getQuote()->hasItems()) {
            $this->getResponse()->setHeader('HTTP/1.1', '403 Session Expired');
            exit;
        }
    }

    public function getStandard() {
        return Mage::getSingleton('Paymentz/standard');
    }

    public function redirectAction() {

        $session = Mage::getSingleton('checkout/session');
        $session->setPaymentzStandardQuoteId($session->getQuoteId());
        $order = Mage::getModel('sales/order');
        $order->load(Mage::getSingleton('checkout/session')->getLastOrderId());
        $order->sendNewOrderEmail();
        $order->save();

        $this->getResponse()->setBody($this->getLayout()->createBlock('Paymentz/form_redirect')->toHtml());
        $session->unsQuoteId();
    }

    public function cancelAction() {
        $session = Mage::getSingleton('checkout/session');
        $session->setQuoteId($session->getPaymentzStandardQuoteId(true));


        if ($session->getLastRealOrderId()) {
            $order = Mage::getModel('sales/order')->loadByIncrementId($session->getLastRealOrderId());
            if ($order->getId()) {
                $order->cancel()->save();
            }
        }


        Mage::getSingleton('checkout/session')->addError("Payment has been cancelled and the transaction has been declined.");
        $this->_redirect('checkout/cart');
    }

    public function successAction() {
        $status = true;
        $authDesc = "N";

        if (!$this->getRequest()->isPost()) {
            $this->cancelAction();
            return false;
        }

        $response = $this->getRequest()->getPost();
        if (empty($response)) {
            $status = false;
        }

        //$WorkingKey = Mage::getStoreConfig('payment/Paymentz/workingkey');
        if (isset($response["amount"]))
            $amount = $response["amount"];
        if (isset($response["desc"]))
            $order_Id = $response["desc"];
        if (isset($response["newchecksum"]))
            $checksum = $response["newchecksum"];
        if (isset($response["status"]))
            $authDesc = $response["status"];

        $order = Mage::getModel('sales/order')->loadByIncrementId($order_Id);
        if (!$order) {
            return;
        }

        if ($authDesc == "Y") {
            $order->setState(Mage_Sales_Model_Order::STATE_PROCESSING, true, 'Payment Success.');
            $order->save();
        } else if ($authDesc == "N") {
            $this->getCheckout()->setPaymentzErrorMessage('Payment Failed');
            $this->cancelAction();
            return false;
        }

        $f_passed_status = Mage::getStoreConfig('payment/Paymentz/payment_success_status');
        $message = Mage::helper('Paymentz')->__('Your payment is authorized.');

        $payment_confirmation_mail = Mage::getStoreConfig('payment/Paymentz/payment_confirmation_mail');
        if ($payment_confirmation_mail == "1") {
            $order->sendOrderUpdateEmail(true, 'Your payment is authorized.');
        }

        $order->save();
        $session = Mage::getSingleton('checkout/session');
        $session->addError("Thank you for shopping with us. Your account has been charged and your transaction is successful. We will be shipping your order to you soon.");
        $session->setQuoteId($session->getPaymentzStandardQuoteId(true));

        Mage::getSingleton('checkout/session')->getQuote()->setIsActive(false)->save();
        $this->_redirect('checkout/onepage/success', array('_secure' => true));
        
       // Mage::getSingleton('checkout/session')->addError("Payment has been cancelled and the transaction has been declined.");
        
    }

    public function errorAction() {
        $this->_redirect('checkout/onepage/');
    }

    public function getCheckout() {
        return Mage::getSingleton('checkout/session');
    }

}
