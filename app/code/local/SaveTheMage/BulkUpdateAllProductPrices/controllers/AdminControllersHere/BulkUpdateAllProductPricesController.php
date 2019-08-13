<?php

class SaveTheMage_BulkUpdateAllProductPrices_AdminControllersHere_BulkUpdateAllProductPricesController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
	{
		$this->loadLayout();
		
		$this->_addLeft($this->getLayout()->createBlock('SaveTheMage_BulkUpdateAllProductPrices_Block_ShowTabsAdminBlock'));
		
		$this->renderLayout();
	}
	
            public function postAction()
            {
		
		$post = $this->getRequest();
		
                try {
                        if (empty($post)) {
                            Mage::throwException($this->__('Invalid value.'));
                        }
            		
			$storeId = $post->getParam('storeId'); //Done
                        $AddOrSubtract = $post->getParam('AddOrSubtract'); //Done
                        $PercentOrFlat = $post->getParam('PercentOrFlat'); //Done
                        $PriceAdjustmentValue = $post->getParam('PriceAdjustmentValue'); //Done
                        $SpecialPriceAdjustmentValue = $post->getParam('SpecialPriceAdjustmentValue'); //Done
                        
                        
                        $prefix = Mage::getConfig()->getTablePrefix();
                        
                        $msg = "";
                                
                        //Check if price need to update or not
			if( !empty( $PriceAdjustmentValue ) )
                        {
			$sqlPrice = "";                        
                        $sqlWhere = "val.attribute_id = (
					 SELECT attribute_id FROM " . $prefix . "eav_attribute eav
					 WHERE eav.entity_type_id in ( 4 , 10 )
					   AND eav.attribute_code = 'price'
					)";
                        
			if( $storeId > -1 )  // For particular store
			{
                            $sqlWhere = $sqlWhere . " AND val.store_id = $storeId";
                            
			}
			
                        $sqlPrice = "UPDATE " . $prefix ."catalog_product_entity_decimal val";
                        switch( $PercentOrFlat )
                        {
                            case "Percent":
                        
                                $PriceAdjustmentValue = ( $PriceAdjustmentValue ) / 100 ;

                                if($AddOrSubtract == "ADD")    
                                {
                                    $sqlPrice .= " SET  val.value = ( val.value + ( val.value *  $PriceAdjustmentValue ) )";
                                }
                                else if($AddOrSubtract = "SUBTRACT")
                                {
                                    $sqlPrice .= " SET  val.value = ( val.value - ( val.value *  $PriceAdjustmentValue ) )";
                                }
                                else
                                {
                                    Mage::throwException($this->__('Invalid Operation.'));
                                }
                                break;
                        
                            case "Flat":
                                
                                if($AddOrSubtract == "ADD")    
                                {
                                    $sqlPrice .= " SET  val.value = ( val.value + $PriceAdjustmentValue )";
                                }
                                else if($AddOrSubtract = "SUBTRACT")
                                {
                                    $sqlPrice .= " SET  val.value = ( val.value - $PriceAdjustmentValue )";
                                }
                                else
                                {
                                    Mage::throwException($this->__('Invalid Operation.'));
                                }
                                break;
                                
                            default:
                                Mage::throwException($this->__('Invalid Percent or Flat value.'));
                        }
                        
                        $sqlPrice = $sqlPrice . " WHERE " . $sqlWhere;
                        
			//Run the query here
                        $write = Mage::getSingleton('core/resource')->getConnection('core_write');
			$write->query( $sqlPrice );
			
			$msg = "Price updated for all products successfully.";
                        }
                        
			//Check if special price need to update or not
			if( !empty( $SpecialPriceAdjustmentValue ) )
			{
                            
                            $sqlSpecialWhere = "val.attribute_id = (
					 SELECT attribute_id FROM " . $prefix . "eav_attribute eav
					 WHERE eav.entity_type_id in ( 4 , 10 )
					   AND eav.attribute_code = 'special_price'
					)";
                            
                            if( $storeId > -1 )  // For particular store
                            {
                                $sqlSpecialWhere = $sqlSpecialWhere . " AND val.store_id = $storeId";
                            
                            }
			
                            $sqlSpecialPrice = "UPDATE " . $prefix ."catalog_product_entity_decimal val";
                        switch( $PercentOrFlat )
                        {
                            case "Percent":
                        
                                $SpecialPriceAdjustmentValue = ( $SpecialPriceAdjustmentValue ) / 100 ;

                                if($AddOrSubtract == "ADD")    
                                {
                                    $sqlSpecialPrice .= " SET  val.value = ( val.value + ( val.value *  $SpecialPriceAdjustmentValue ) )";
                                }
                                else if($AddOrSubtract = "SUBTRACT")
                                {
                                    $sqlSpecialPrice .= " SET  val.value = ( val.value - ( val.value *  $SpecialPriceAdjustmentValue ) )";
                                }
                                else
                                {
                                    Mage::throwException($this->__('Invalid Operation.'));
                                }
                                break;
                        
                            case "Flat":
                                
                                if($AddOrSubtract == "ADD")    
                                {
                                    $sqlSpecialPrice .= " SET  val.value = ( val.value + $SpecialPriceAdjustmentValue )";
                                }
                                else if($AddOrSubtract = "SUBTRACT")
                                {
                                    $sqlSpecialPrice .= " SET  val.value = ( val.value - $SpecialPriceAdjustmentValue ) ";
                                }
                                else
                                {
                                    Mage::throwException($this->__('Invalid Operation.'));
                                }
                                break;
                                
                            default:
                                Mage::throwException($this->__('Invalid Percent or Flat value.'));
                        }
                        
                        $sqlSpecialPrice = $sqlSpecialPrice . " WHERE " . $sqlSpecialWhere;
                        
			//Run the query here
                        $write = Mage::getSingleton('core/resource')->getConnection('core_write');
			$write->query( $sqlSpecialPrice );

                            if(!empty( $msg ))
                                $msg = "Special Price and " . $msg;
                            else
                                $msg = "Special Price for all products updated successfully.";
			}
                        
            if( !empty( $msg ) )
            {
            $message = $this->__( $msg );
            Mage::getSingleton('adminhtml/session')->addSuccess($message);
            }
            else
            {
                Mage::getSingleton('adminhtml/session')->addError("Price or Special price is required.");
            }
			
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('*/*');
	}
}