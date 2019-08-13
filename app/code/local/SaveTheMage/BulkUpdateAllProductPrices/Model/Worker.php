<?php
/**
 * Description of Worker
 *
 * @author Rezoanul Alam @ www.savethemage.com
 */
class SaveTheMage_BulkUpdateAllProductPrices_Model_Worker {
    
    public function UpdatePrice($storeId, $priceToUpdate, $specialPriceToUpdate, $addOrSubtract, $percentOrFlat){
        
        $_productCollection = array();
        
        if( $storeId > -1 ){
            $_productCollection = Mage::getModel('catalog/product')->setStoreId( $storeId )->getCollection(); 
        }
        else{
            $_productCollection = Mage::getModel('catalog/product')->getCollection(); 
        }
        
        
        foreach( $_productCollection as $_product ){
                        
            $productId = $_product->getId();
            $productObj = Mage::getModel('catalog/product')->load( $productId );
            
            if( $priceToUpdate > 0 ){
                $this->_updateThePrice($productObj, $percentOrFlat, $addOrSubtract, $priceToUpdate );
            }
            
            if( $specialPriceToUpdate > 0 ){
                $this->_updateTheSpecialPrice($productObj, $percentOrFlat, $addOrSubtract, $specialPriceToUpdate );
            }
            
        }
        
    }
    
    private function _updateThePrice($productObj, $percentOrFlat, $addOrSubtract, $priceToUpdate ){
        
        $price = $productObj->getPrice();
            
            if( $price > 0 ){
                
                switch( $percentOrFlat )
                {
                case "Percent":
                    
                    if( $addOrSubtract == "ADD" ){
                        $price = $price + ( $price * ( $priceToUpdate / 100 ) );
                    }
                    else{
                        $price = $price - ( $price * ( $priceToUpdate / 100 ) );
                    }
                    break;
                case "Flat":
                    if( $addOrSubtract == "ADD" ){
                        $price = $price + $priceToUpdate;
                    }
                    else{
                        $price = $price - $priceToUpdate;
                    }
                    break;
                
                }
                
                $productObj->setPrice( $price );
                $productObj->save();
            }
    }
    
    private function _updateTheSpecialPrice($productObj, $percentOrFlat, $addOrSubtract, $specialPriceToUpdate ){
        
        $price = $productObj->getSpecialPrice();
            
            if( $price > 0 ){
                
                switch( $percentOrFlat )
                {
                case "Percent":
                    
                    if( $addOrSubtract == "ADD" ){
                        $price = $price + ( $price * ( $specialPriceToUpdate / 100 ) );
                    }
                    else{
                        $price = $price - ( $price * ( $specialPriceToUpdate / 100 ) );
                    }
                    break;
                case "Flat":
                    if( $addOrSubtract == "ADD" ){
                        $price = $price + $specialPriceToUpdate;
                    }
                    else{
                        $price = $price - $specialPriceToUpdate;
                    }
                    break;
                
                }
                
                $productObj->setSpecialPrice( $price );
                $productObj->save();
            }
    }
}

?>
