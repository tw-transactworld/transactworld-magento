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


class Mage_Paymentz_Block_Info_Paymentz extends Mage_Payment_Block_Info
{
    
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('Paymentz/info/Paymentz.phtml');
    }

    
    public function getPaymentzTypeName()
    {
        $types = Mage::getSingleton('Paymentz/config')->getPaymentzTypes();
        if (isset($types[$this->getInfo()->getPaymentzType()])) {
            return $types[$this->getInfo()->getPaymentzType()];
        }
        return $this->getInfo()->getPaymentzType();
    }

   
}
 ?>