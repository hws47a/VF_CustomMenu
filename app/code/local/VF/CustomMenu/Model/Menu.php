<?php
/**
 * VF extension for Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * 
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade
 * the VF CustomMenu module to newer versions in the future.
 * If you wish to customize the VF CustomMenu module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   VF
 * @package    VF_CustomMenu
 * @copyright  Copyright (C) 2012 Vladimir Fishchenko (http://fishchenko.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Menu model
 *
 * @method string getSourceAttribute
 * @method string getUrl
 * @method string getTitle
 * @method string getLabel
 *
 * @category   VF
 * @package    VF_CustomMenu
 * @subpackage Model
 * @author     Vladimir Fishchenko <vladimir.fishchenko@gmail.com>
 */
class VF_CustomMenu_Model_Menu extends Mage_Core_Model_Abstract
{
    /**
     * Initialize resources
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('menu/menu');
    }

    /**
     * Get default category id
     *
     * @return int
     */
    public function getDefaultCategoryId()
    {
        $category = Mage::app()->getStore()->getRootCategoryId();
        if ($this->getDefaultCategory()) {
            $category = intval($this->getDefaultCategory());
        }
        return $category;
    }

    /**
     * @return Mage_Catalog_Model_Category
     */
    public function getCategory()
    {
        if (!$this->hasData('category_object')) {
            $category = Mage::getModel('catalog/category');
            if ($this->getDefaultCategory()) {
                $category->load($this->getDefaultCategory());
            }
            $this->setData('category_object', $category);
        }
        return $this->getData('category_object');
    }
}
