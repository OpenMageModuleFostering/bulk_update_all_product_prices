<?php

class SaveTheMage_BulkUpdateAllProductPrices_Block_ShowTabsAdminBlock extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('tabs_BulkUpdateAllProductPrices');
        
        $this->setTitle(Mage::helper('BulkUpdateAllProductPricesHelper1')->__('To Update Product Price in Bulk'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('tab1_BulkUpdateAllProductPrices', array(
            'label'     => Mage::helper('BulkUpdateAllProductPricesHelper1')->__('Bulk Update All Product Prices'),
            'title'     => Mage::helper('BulkUpdateAllProductPricesHelper1')->__('Bulk Update All Product Prices'),
            'content'   => $this->getLayout()->createBlock("BulkUpdateAllProductPricesBlock1/BlockForFormBulkUpdateAllProductPrices")->toHtml(),
            'active'    => true
        ));          
        
		
		$about="<fieldset class='box' style='clear: both;'><table>
		<tr><td>
		<a title='SaveTheMage Magento Extensions' href='http://www.savethemage.com/'>
		<img alt='SaveTheMage Magento Extensions' src='http://www.savethemage.com/skin/frontend/default/magik_aura/images/savethemage-logo-icon.png'>
		</a>
		</td></tr>
		<tr><td><a href='mailto:support@savethemage.com'>Email Us</a></td></tr>
		</table></fieldset>";
		$this->addTab('tab2_about', array(
            'label'     => Mage::helper('BulkUpdateAllProductPricesHelper1')->__('About'),
            'title'     => Mage::helper('BulkUpdateAllProductPricesHelper1')->__('About'),
            'content'   => $about, 
            'active'    => false
        ));    
		
        return parent::_beforeToHtml();
    }  
}