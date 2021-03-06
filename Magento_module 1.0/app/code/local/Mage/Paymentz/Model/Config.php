<?php
/**
*************************************************************************************
 Please Do not edit or add any code in this file without permission of paymentz.com.
@Developed by paymentz.com

Magento version 1.9.0.1                 Paymentz Version 1.0
                              
Module Version. pz-1.0                 Module release: May 2017
**************************************************************************************
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


class Mage_Paymentz_Model_Config
{
    protected static $_methods;

    
    public function getActiveMethods($store=null)
    {
        $methods = array();
        $config = Mage::getStoreConfig('Paymentz', $store);
        foreach ($config as $code => $methodConfig) {
            if (Mage::getStoreConfigFlag('Paymentz/'.$code.'/active', $store)) {
                $methods[$code] = $this->_getMethod($code, $methodConfig);
            }
        }
        return $methods;
    }

    
    public function getAllMethods($store=null)
    {
        $methods = array();
        $config = Mage::getStoreConfig('Paymentz', $store);
        foreach ($config as $code => $methodConfig) {
            $methods[$code] = $this->_getMethod($code, $methodConfig);
        }
        return $methods;
    }

    protected function _getMethod($code, $config, $store=null)
    {
        if (isset(self::$_methods[$code])) {
            return self::$_methods[$code];
        }
        $modelName = $config['model'];
        $method = Mage::getModel($modelName);
        $method->setId($code)->setStore($store);
        self::$_methods[$code] = $method;
        return self::$_methods[$code];
    }

	 
   
    public function getMonths()
    {
        $data = Mage::app()->getLocale()->getTranslationList('month');
        foreach ($data as $key => $value) {
            $monthNum = ($key < 10) ? '0'.$key : $key;
            $data[$key] = $monthNum . ' - ' . $value;
        }
        return $data;
    }

   
    public function getYears()
    {
        $years = array();
        $first = date("Y");

        for ($index=0; $index <= 10; $index++) {
            $year = $first + $index;
            $years[$year] = $year;
        }
        return $years;
    }

    
    static function comparePaymentzTypes($a, $b)
    {
        if (!isset($a['order'])) {
            $a['order'] = 0;
        }

        if (!isset($b['order'])) {
            $b['order'] = 0;
        }

        if ($a['order'] == $b['order']) {
            return 0;
        } else if ($a['order'] > $b['order']) {
            return 1;
        } else {
            return -1;
        }

    }
	public function getPaymentzServerUrl()
	{   if(Mage::getStoreConfig('payment/Paymentz/test')){
		
	    //$url='https://staging.paymentz.com/transaction/PayProcessController';
		$url=Mage::getStoreConfig('payment/Paymentz/testurl');
		return $url;
	} else
	     //$url=Mage::getStoreConfig('payment/Paymentz/processingurl');
	    //$urllive = 'https://secure.theflyingmerchant.com/transaction/PayProcessController';
		// $urllive = Mage::getStoreConfig('payment/Paymentz/liveurl');
		 $urllive =Mage::getStoreConfig('payment/Paymentz/liveurl');
		
         return $urllive;
	}
	
	public function getPaymentzRedirecturl()
	{
		  $url= Mage::getUrl('Paymentz/Paymentz/success',array('_secure' => true));
	
		 return $url;
	}
}
		
 