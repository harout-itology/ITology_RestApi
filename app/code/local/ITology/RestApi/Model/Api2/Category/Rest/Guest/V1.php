<?php

/**
 * Override for Magento's Catalog REST API
 */
class ITology_RestApi_Model_Api2_Category_Rest_Guest_V1 extends Mage_Api2_Model_Resource {

	/**
	 * Retrieve the category
	 * @return category entity
	 */
    protected function _retrieve() {

		$store_id = $this->getRequest()->getParam('store_id');
		$category_id  = $this->getRequest()->getParam('category_id');

		$model = Mage::getModel('catalog/category')->setStoreId($store_id)->load($category_id);

		$sub_model = $model->getResource()->getChildren($model, false);

		$data = array();
		foreach($sub_model as $category_id ){

			$sub_category = Mage::getModel('catalog/category')->setStoreId($store_id)->load($category_id);

			$sub_data = array();
			$sub_data['entity_id'] = $category_id;
			$sub_data['name'] = $sub_category->getName();
			$sub_data['description'] = $sub_category->getDescription();
			$sub_data['thumbnail'] = $sub_category->getThumbnail();

			$data[$category_id] = $sub_data;

		}
		$model['children'] = $data;

		return  $model;

    }

    /**
     * Retrieves the category collection and returns
     *
     * @return int
     */
     protected function _retrieveCollection() {

		 $store_id = $this->getRequest()->getParam('store_id');

		 $model = Mage::getModel('catalog/category');
		 $model->setStoreId($store_id);

		 $collection = $model->getCollection()
			 ->addAttributeToSelect(['entity_id','parent_id','description','name','thumbnail'])
			 ->addAttributeToFilter('is_active',1);

		 $this->_applyCollectionModifiers($collection);
		 return  $collection->load();

    }

	
}

