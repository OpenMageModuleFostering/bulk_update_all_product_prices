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
                        
                        if( $PriceAdjustmentValue == 0 && $SpecialPriceAdjustmentValue == 0 )
                        {
                             Mage::getSingleton('adminhtml/session')->addError("Price or Special price is required.");
                        }
                        else if( $PercentOrFlat != 'Percent' && $PercentOrFlat !="Flat" ){
                            Mage::getSingleton('adminhtml/session')->addError("Percent or Flat is required.");
                        }
                        else if( $AddOrSubtract !='ADD' && $AddOrSubtract !='SUBTRACT' ){
                            Mage::getSingleton('adminhtml/session')->addError("Add or Subtract is required.");
                        }
                        else{
                            
                            $model = Mage::getModel('savethemagebulkupdateallproductprices/Worker');
                            if( empty( $model ) )
                            {
                                require_once ( Mage::getBaseDir('app') . '/code/local/SaveTheMage/BulkUpdateAllProductPrices/Model/Worker.php');
                                $model = new SaveTheMage_BulkUpdateAllProductPrices_Model_Worker();
                            }
                            if( !empty( $model ) ){
                                
                                //UpdatePrice($storeId, $priceToUpdate, $specialPriceToUpdate, $addOrSubtract, $percentOrFlat)
                                $model->UpdatePrice($storeId, $PriceAdjustmentValue, $SpecialPriceAdjustmentValue, $AddOrSubtract, $PercentOrFlat);
                                
                                $msg = "Price or Special Price Updated successfully";
                                $message = $this->__( $msg );
                                Mage::getSingleton('adminhtml/session')->addSuccess($message);
                            }
                            else{
                                Mage::getSingleton('adminhtml/session')->addError("Can't perform the operation right now, please contact with support@savethemage.com.");
                            }
                        }
                        
                        
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
            $this->_redirect('*/*');
	}
        
}