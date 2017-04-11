<?php

/**
 * Override for Magento's Catalog REST API
 */
class ITology_RestApi_Model_Api2_Shop_Rest_Guest_V1 extends Mage_Api2_Model_Resource {

	// shops level in categories tree
	protected $level = 4;

	/**
	 * Retrieve the store
	 * @return store entity
	 */
    protected function _retrieve() {

		$store_id = $this->getRequest()->getParam('store_id');
		$shop_id  = $this->getRequest()->getParam('shop_id');

		$model = Mage::getModel('catalog/category')->setStoreId($store_id)->load($shop_id);

		return  $model;
    }

    /**
     * Retrieves the store collection and returns
     *
     * @return int
     */
     protected function _retrieveCollection() {

		 $store_id = $this->getRequest()->getParam('store_id');

		 $model = Mage::getModel('catalog/category');
		 $model->setStoreId($store_id);

		 $collection = $model->getCollection()
				->addAttributeToSelect(['entity_id','parent_id','description','name','thumbnail'])
				->addAttributeToFilter('level', $this->level)
				->addAttributeToFilter('is_active',1);

		 $this->_applyCollectionModifiers($collection);
		 return  $collection->load();

    }




}

