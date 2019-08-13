<?php

class SaveTheMage_BulkUpdateAllProductPrices_Block_BlockForFormBulkUpdateAllProductPrices extends Mage_Core_Block_Template
{
	
    public function __construct()
    {   	
        parent::__construct();
        $this->setTemplate('SaveTheMage/tab_container_FormBulkUpdateAllProductPrices.phtml');   
    }	 
}