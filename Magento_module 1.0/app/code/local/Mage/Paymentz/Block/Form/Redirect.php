<?php 
/**
 Please Do not edit or add any code in this file without permission of paymentz.com.
@Developed by paymentz.com

Magento version 1.9.0.1                 Paymentz Version 1.0
                              
Module Version. pz-1.0                 Module release: May 2017

*/

class Mage_Paymentz_Block_Form_Redirect extends Mage_Core_Block_Abstract
{
    protected function _toHtml()
    {
		 
		 
        $Paymentz = Mage::getModel('Paymentz/method_Paymentz');

        $form = new Varien_Data_Form();
        $form->setAction($Paymentz->getPaymentzUrl())
            ->setId('Paymentz_standard_checkout')
            ->setName('ecom')
            ->setMethod('post')
		    ->setUseContainer(true);
        foreach ($Paymentz->getStandardCheckoutFormFields('redirect') as $field=>$value) {
           $form->addField($field, 'hidden', array('name'=>$field, 'value'=>$value));
        }
		
	
        $html = '<html>
				<body style="text-align:center;">';
       //$html.= $this->__('You will be redirected to Paymentz in a few seconds.<br /><center>');
	  // $html.='<img src="'.$this->getSkinUrl('paymentz/logo.png').'" border="1" alt="Logo" width="185px" height="70px" /><br /><br />';
	   //$html.= '<img src="'.$this->getSkinUrl('paymentz/ajax-loader.gif').'" alt="ajax-loader" align="center" width="128px" height="15px" /><br /></center>';
	   //$html.= $this->__('Copyright Paymentz.com');
	   echo $totype = "You will be redirecting to"." ".Mage::getStoreConfig('payment/Paymentz/partnername')." in few seconds...<br><br>";
       $html.= $form->toHtml();
       $html.= '<script type="text/javascript">
	   			  function formsubmit()
				  {
				  	document.ecom.submit();	
				  }
				  setTimeout("formsubmit()", 3000);
	            </script>';
	  
        $html.= '</body></html>';

        return $html; 
    }
}

