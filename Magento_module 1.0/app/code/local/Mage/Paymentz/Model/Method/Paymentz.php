<?php
/**
*************************************************************************************
 Please Do not edit or add any code in this file without permission of paymentz.com.
@Developed by paymentz.com

Magento version 1.9.0.1                 Paymentz Version 1.0
                              
Module Version. pz-1.0                 Module release: May 2017
**************************************************************************************
*//**
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



class Mage_Paymentz_Model_Method_Paymentz extends Mage_Payment_Model_Method_Abstract
{
    protected $_formBlockType = 'Paymentz/form_Paymentz';
    protected $_infoBlockType = 'Paymentz/info_Paymentz';
    protected $_canSavePaymentz     = false;
	protected $_code  = 'Paymentz';

   
    public function assignData($data)
    {
		if (!($data instanceof Varien_Object)) {
            $data = new Varien_Object($data);
        }
        $info = $this->getInfoInstance();
        $info->setPaymentzType($this->getPaymentzAccountId1())	
			->settoid($data->gettoid())
			->setpartenerid($data->getpartenerid())
			->setipaddr($data->getipaddr())
			->setpctype($data->getpctype())
			->setdescription($data->getdescription())
			->setamount($data->getamount())
			->setCurrency_code($data->getCurrency_code())
			->setShipping($data->getShipping())
			->setchecksum($data->getchecksum())
			->setTax($data->getTax())
			->setTMPL_street($data->getTMPL_street())
			->setTMPL_city($data->getTMPL_city())
			->setTMPL_state($data->getTMPL_state())
			->setTMPL_zip($data->getTMPL_zip())
			->setTMPL_IN($data->getTMPL_IN())
			->setTMPL_telno($data->getTMPL_telno())
			->setTMPL_telnocc($data->getTMPL_telnocc())
			->setTMPL_emailaddr($data->getTMPL_emailaddr())
			->setorderdescription($data->getorderdescription())
			->setreservedField1($data->getreservedField1())
			->setreservedField2($data->getreservedField2())
			->settotype($data->gettotype())
			->setpaymenttype($data->getpaymenttype())
			->setcardtype($data->getcardtype())
			->setTMPL_AMOUNT($data->getTMPL_AMOUNT())
			->setTMPL_CURRENCY($data->getTMPL_CURRENCY())
			->setredirecturl($data->getredirecturl());
		
        return $this;
    }

    
    public function prepareSave()
    {
        $info = $this->getInfoInstance();
        if ($this->_canSavePaymentz) {
            $info->setPaymentzNumberEnc($info->encrypt($info->getPaymentzNumber()));
        }
        $info->setPaymentzNumber(null)
            ->setPaymentzCid(null);
        return $this;
    }
	public function getProtocolVersion()
    {
        return '1.0';
    }
	
	
    public function getSession()
    {
        return Mage::getSingleton('Paymentz/session');
    }

    
    public function getCheckout()
    {
        return Mage::getSingleton('checkout/session');
    }
	
    public function getQuote()
    {
        
	    return $this->getCheckout()->getQuote();
    }
	
	public function getStandardCheckoutFormFields($option = '')
    {
       
	    if ($this->getQuote()->getIsVirtual()) {
            $a = $this->getQuote()->getBillingAddress();
            $b = $this->getQuote()->getShippingAddress();
        } else {
            $a = $this->getQuote()->getShippingAddress();
            $b = $this->getQuote()->getBillingAddress();
        }



		$data=$this->getQuoteData($option);
        $sArr = array(	
		    'toid' => $data['toid'],
			'partenerid' => $data['partenerid'],
		    'pctype' => "1_1|1_2",
		    'paymenttype' => "",
		    'cardtype' => "",
			'ipaddr' => $data['ipaddr'],
		    'totype' => $data['totype'],
    		'description' => $data['description'],
			'amount' => $data['amount'],
			'currency_code' => 	$data['currency_code'],
			'shipping'=>$data['shipping'],
			'tax'=>$data['tax'],
			'checksum'=>$data['checksum'],
			'TMPL_street'  		=> $data['TMPL_street'],
			'TMPL_city' 			=> $data['TMPL_city'],
			'TMPL_state'    		=> $data['TMPL_state'],
			'TMPL_zip'      		=> $data['TMPL_zip'],
			'TMPL_IN'  		=> $data['TMPL_IN'],
			'TMPL_telno'      		=> $data['TMPL_telno'],
			'TMPL_emailaddr'    		=> $data['TMPL_emailaddr'],
			'redirecturl'              	=> $data['redirecturl'],
			'orderdescription'              	=> $data['orderdescription'],
			'toid'              	=> $data['toid'],
			'totype'              	=> $data['totype'],
			'reservedField1'              	=> $data['reservedField1'],
			'reservedField2'              	=> $data['reservedField2'],
			'paymenttype'              	=> $data['paymenttype'],
			'cardtype'              	=> $data['cardtype'],			
			'TMPL_AMOUNT'              	=> $data['TMPL_AMOUNT'],	
			'TMPL_CURRENCY'              	=> $data['TMPL_CURRENCY'],	
				
				
		    //'Order_Id' => $data['Order_Id'],
			//'Amount' => $data['Amount'],
			//'currency_code' => 	$data['currency_code'],
			//'shipping'=>$data['shipping'],
			//'tax'=>$data['tax'],
			//'Checksum'=>$data['Checksum'],
			//'billing_cust_name' 			=> $data['billing_cust_name'],
			//'billing_cust_address'  		=> $data['billing_cust_address'],
			//'billing_cust_city' 			=> $data['billing_cust_city'],
			//'billing_cust_state'    		=> $data['billing_cust_state'],
			//'billing_zip_code'      		=> $data['billing_zip_code'],
			//'billing_cust_country'  		=> $data['billing_cust_country'],
			//'billing_cust_tel'      		=> $data['billing_cust_tel'],
			//'billing_cust_email'    		=> $data['billing_cust_email'],
			//'delivery_cust_name'    		=> $data['delivery_cust_name'],
			//'delivery_cust_address'     	=> $data['delivery_cust_address'],
			//'delivery_cust_city' 			=> $data['delivery_cust_city'],
			//'delivery_cust_state'   		=> $data['delivery_cust_state'],
			//'delivery_zip_code'     		=> $data['delivery_zip_code'],
			//'delivery_cust_country'     	=> $data['delivery_cust_country'],
			//'delivery_cust_tel'       		=> $data['delivery_cust_tel'],
			//'billing_cust_notes'    		=> $data['billing_cust_notes'],
			//'Redirect_Url'              	=> $data['Redirect_Url'],

			);
			
			// echo "<pre>";
				// print_r($sArr);
				// echo "</pre>";
        $sReq = '';
        $rArr = array();
        foreach ($sArr as $k=>$v) {
           
            $value =  str_replace("&","and",$v);
            $rArr[$k] =  $value;
            $sReq .= '&'.$k.'='.$value;
        }
        return $rArr;
    }

    public function getPaymentzUrl()
    {    
		 $url=$this->_getPaymentzConfig()->getPaymentzServerUrl();
         return $url;
    }
	
	
	 public function getOrderPlaceRedirectUrl()
    {
	         return Mage::getUrl('Paymentz/Paymentz/redirect');
    }

	public function getQuoteData($option = '')
    {					
	
		if ($option == 'redirect') {
    		$orderIncrementId = $this->getCheckout()->getLastRealOrderId();
    		$quote = Mage::getModel('sales/order')->loadByIncrementId($orderIncrementId);
		} else {
			$quote = $this->getQuote();
		}

		$data=array();
				 	
		if ($quote)
		{
			if($quote->getShippingAddress())
			{
				if ($quote->getIsVirtual()) {
					$a = $quote->getBillingAddress();
					$b = $quote->getShippingAddress();
				} else {
					$a = $quote->getShippingAddress();
					$b = $quote->getBillingAddress();
				}
			}
			else
			{
				$a = $quote->getBillingAddress();
				$b = $quote->getBillingAddress();
			}


			$toid = Mage::getStoreConfig('payment/Paymentz/merchantid');
			$totype = Mage::getStoreConfig('payment/Paymentz/partnername');
			$description = $this->getCheckout()->getLastRealOrderId();
			$amount2  = Mage::app()->getStore()->roundPrice($quote->getGrandTotal());
			$amount = number_format((float)$amount2, 2, '.', '');
			$key = Mage::getStoreConfig('payment/Paymentz/workingkey');
			$Url = $this->_getPaymentzConfig()->getPaymentzRedirecturl();

			$pattern='http://www.';
			if(!(Eregi($pattern,$Url,$reg)))
			eregi_replace('http://', $pattern, $Url);
			$WorkingKey =  Mage::getStoreConfig('payment/Paymentz/workingkey');
						
		    $str ="$MerchantId|$OrderId|$Amount|$Url|$WorkingKey";
			$adler = 1;
			$BASE =  65521 ;
			
			$s1 = $adler & 0xffff ;
			$s2 = ($adler >> 16) & 0xffff;
			for($i = 0 ; $i < strlen($str) ; $i++)
			{
				$s1 = ($s1 + Ord($str[$i])) % $BASE ;
				$s2 = ($s2 + $s1) % $BASE ;
			
			}
			
			$str = $s2;
			$num = 16;
			$dec ='';
			
			$str = DecBin($str);
			
			for( $i = 0 ; $i < (64 - strlen($str)) ; $i++)
			$str = "0".$str ;
			
			for($i = 0 ; $i < $num ; $i++) 
			{
				$str = $str."0";
				$str = substr($str , 1 ) ;
			}
			$num=$str;
			for ($n = 0 ; $n < strlen($num) ; $n++)
			{
				$temp = $num[$n] ;
				$dec =  $dec + $temp*pow(2 , strlen($num) - $n - 1);
			}

			//$Checksum = $dec + $s1;
			//$checksum = '1bb75d8d73545207d53b7de3877e5ec3';
			//$checksum = getchecksum($toid,$totype,$amount,$description , $redirecturl,$key);

			$redirecturl = $this->_getPaymentzConfig()->getPaymentzRedirecturl();
			//$totype 		='Paymentz';
			$strnew = "$toid|$totype|$amount|$description|$redirecturl|$key";
	        //echo $strnew;
			$checksum = md5($strnew);


			$AuthDesc = 'N';
			
			//$data['Merchant_Id'] = Mage::getStoreConfig('payment/Paymentz/merchantid');
			//$data['Order_Id'] = $this->getCheckout()->getLastRealOrderId();
			//$data['Amount']  = $Amount;
			//$data['currency_code']  = $quote->getBaseCurrencyCode();

			$data['toid'] = Mage::getStoreConfig('payment/Paymentz/merchantid');
			$data['partenerid'] = Mage::getStoreConfig('payment/Paymentz/partenerid');
			$data['ipaddr'] = Mage::getStoreConfig('payment/Paymentz/ipaddr');
			$data['totype'] = Mage::getStoreConfig('payment/Paymentz/partnername');
			$data['description'] = $this->getCheckout()->getLastRealOrderId();
			$data['amount']  = $amount;
			$data['TMPL_CURRENCY']  = $quote->getBaseCurrencyCode();
			$data['currency_code']  = $quote->getBaseCurrencyCode();
			if($quote->getShippingAmount())
			{
				$data['shipping'] = sprintf('%.2f', $quote->getShippingAmount());
			}
			else
			{
				$data['shipping'] = '0';
			}
			$data['tax']      = sprintf('%.2f', $quote->getTaxAmount());
			//$data['checksum']=$checksum;
			
			if($this->getQuote()->getCustomer())
			{
				$email_id =$this->getQuote()->getCustomer()->getEmail();
			}
			
			//$data['billing_cust_name'] 			=$b->getFirstname()." ".$b->getLastname();
			//$data['billing_cust_address'] 		=$b->getStreet(1)."   ".$b->getStreet(2);
			//$data['billing_cust_city'] 			=$b->getCity();
			//$data['billing_cust_state'] 		=$b->getRegionCode();
			//$data['billing_zip_code']   		=$b->getPostcode();
			//$data['billing_cust_country'] 		=$b->getCountryModel()->getName();
			//$data['billing_cust_tel'] 		    =$b->getTelephone();
			//$data['billing_cust_email'] 		=$quote->getCustomerEmail();
			//$data['delivery_cust_name'] 		=$a->getFirstname()." ".$a->getLastname();
			//$data['delivery_cust_address']  	=$a->getStreet(1)."   ".$a->getStreet(2);
			//$data['delivery_cust_city']         =$a->getCity();
			//$data['delivery_cust_state'] 		=$a->getRegionCode();
			//$data['delivery_zip_code']  		=$a->getPostcode();
			//$data['delivery_cust_country']  	= $a->getCountryModel()->getName();
			//$data['delivery_cust_tel']   		=$a->getTelephone();
			//$data['billing_cust_notes'] 		='';
			//$data['Redirect_Url']           	=$this->_getPaymentzConfig()->getPaymentzRedirecturl();


			$data['TMPL_street'] 		=$b->getStreet(1)."   ".$b->getStreet(2);
			$data['TMPL_city'] 			=$b->getCity();
			$data['TMPL_state'] 		=$b->getRegionCode();
			$data['TMPL_zip']   		=$b->getPostcode();
			$data['TMPL_IN'] 		=$b->getCountryModel()->getName();
			$data['TMPL_telno'] 		    =$b->getTelephone();
			$data['TMPL_emailaddr'] 		=$quote->getCustomerEmail();
			$data['orderdescription'] 		='Paymentz eCommerce Platform';
			$data['totype'] 		=$totype;
			$data['reservedField1'] 		='';
			$data['reservedField2'] 		='';
			$data['TMPL_AMOUNT'] 		= 1;
			$data['TMPL_CURRENCY'] 		='USD';
			$data['TMPL_telnocc'] 		= 091;
			$data['paymenttype'] 		= "";
			$data['cardtype'] 		= "";
			//$data['redirecturl']    =$this->_getPaymentzConfig()->getPaymentzRedirecturl();
			$data['redirecturl']    =$redirecturl;
			
			$data['checksum']=$checksum;

			}
		 
		return $data; 
	}
	

//public function getchecksum($MerchantId,$Amount,$OrderId ,$URL,$WorkingKey)
//	{
//		$str ="$MerchantId|$OrderId|$Amount|$URL|$WorkingKey";
//		$adler = 1;
//		$adler = $this->adler32($adler,$str);
//		return $adler;
//	}


public function getchecksum($toid,$totype,$amount,$description , $redirecturl,$key)
{
	$strnew = "$toid|$totype|$amount|$description|$redirecturl|$key";
	$generatedChecksum = md5($strnew);
	return $generatedChecksum;
}

	public function verifychecksum($MerchantId,$OrderId,$Amount,$AuthDesc,$CheckSum,$WorkingKey)
	{
		$str = "$MerchantId|$OrderId|$Amount|$AuthDesc|$WorkingKey";
		$adler = 1;
		$adler = $this->adler32($adler,$str);
		
		if($adler == $checkSum)
			return "true" ;
		else
			return "false" ;
	}
	
	public function adler32($adler , $str)
	{
		$BASE =  65521 ;
	
		$s1 = $adler & 0xffff ;
		$s2 = ($adler >> 16) & 0xffff;
		for($i = 0 ; $i < strlen($str) ; $i++)
		{
			$s1 = ($s1 + Ord($str[$i])) % $BASE ;
			$s2 = ($s2 + $s1) % $BASE ;
	
		}
		return $this->leftshift($s2 , 16) + $s1;
	}
	
	public function leftshift($str , $num)
	{
	
		$str = DecBin($str);
	
		for( $i = 0 ; $i < (64 - strlen($str)) ; $i++)
			$str = "0".$str ;
	
		for($i = 0 ; $i < $num ; $i++) 
		{
			$str = $str."0";
			$str = substr($str , 1 ) ;
		}
		return $this->cdec($str) ;
	}
	
	public function cdec($num)
	{
		$dec = '';
		for ($n = 0 ; $n < strlen($num) ; $n++)
		{
		   $temp = $num[$n] ;
		   $dec =  $dec + $temp*pow(2 , strlen($num) - $n - 1);
		}
	
		return $dec;
	}

	 protected function _getPaymentzConfig()
    {
        return Mage::getSingleton('Paymentz/config');
    }
	
	public function isAvailable($quote=null)
    {
        if (is_null($quote)) {
           return false;
        }
		$return = parent::isAvailable($quote);
		if($return==false)return false;
				
		return true;
		
    }	
}
 