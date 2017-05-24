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
 
/**

****
****
*/

class Mage_Paymentz_Block_Form_Paymentz extends Mage_Payment_Block_Form
{
    protected function _construct()
    {
        parent::_construct();
		        $this->setTemplate('Paymentz/form/Paymentz.phtml');
    }

    
    protected function _getPaymentzConfig()
    {
        return Mage::getSingleton('Paymentz/config');
    }
	

   
	
    public function getPaymentzServiceTypes()
    {
		 
		
         $types = $this->_getPaymentzConfig()->getPaymentzServiceTypes();
        if ($method = $this->getMethod()) {
            $availableTypes = $method->getConfigData('Paymentztypes');
            if ($availableTypes) {
                $availableTypes = explode(',', $availableTypes);
                foreach ($types as $code=>$name) {
                    if (!in_array($code, $availableTypes)) {
                        unset($types[$code]);
                    }
                }
            }
        }
		
        return $types;
    }
	
    
    public function getPaymentzMonths()
    {
        $months = $this->getData('Paymentz_months');
        if (is_null($months)) {
            $months[0] =  $this->__('Month');
            $months = array_merge($months, $this->_getPaymentzConfig()->getMonths());
            $this->setData('Paymentz_months', $months);
        }
        return $months;
    }

   
    public function getPaymentzYears()
    {
        $years = $this->getData('Paymentz_years');
        if (is_null($years)) {
            $years = $this->_getPaymentzConfig()->getYears();
            $years = array(0=>$this->__('Year'))+$years;
            $this->setData('Paymentz_years', $years);
        }
        return $years;
    }

    
    public function hasVerification()
    {
        if ($this->getMethod()) {
            $configData = $this->getMethod()->getConfigData('useccv');
            if(is_null($configData)){
                return true;
            }
            return (bool) $configData;
        }
        return true;
    }
	public function getQuoteData()
    {
		return $this->getMethod()->getQuoteData();
	}
	public function getBillingAddress()
	{
		if ($this->getMethod())
		{
			$this->getMethod()->getQuote();
			$aa= $this->getMethod()->getQuote()->getBillingAddress()->getCountry();
		}
	}
}
