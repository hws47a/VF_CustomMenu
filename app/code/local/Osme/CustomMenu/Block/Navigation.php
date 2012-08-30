<?php 
/**
 * Osme extension for Magento
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
 * the Osme CustomMenu module to newer versions in the future.
 * If you wish to customize the Osme CustomMenu module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Osme
 * @package    Osme_CustomMenu
 * @copyright  Copyright (C) 2012 Osme
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Custom menu block
 *
 * @category   Osme
 * @package    Osme_CustomMenu
 * @subpackage Block
 * @author     Vladimir Fishchenko <vladimir.fishchenko@gmail.com>
 */
class Osme_CustomMenu_Block_Navigation extends Mage_Core_Block_Template
{
    protected function _construct()
    {
        $this->addData(array(
            'cache_lifetime'    => 86400,
            'cache_tags'        => array(Mage_Catalog_Model_Category::CACHE_TAG, Mage_Core_Model_Store_Group::CACHE_TAG),
        ));
    }

    /**
     * Get Key pieces for caching block content
     *
     * @return array
     */
    public function getCacheKeyInfo()
    {
        return array(
            'CATALOG_NAVIGATION',
            Mage::app()->getStore()->getId(),
        );
    }

    /**
     * get menu items
     *
     * @return Osme_CustomMenu_Model_Resource_Menu_Collection
     */
    public function getMenuItems()
    {
        $collection = Mage::getModel('menu/menu')->getCollection()
            ->setOrder('position', 'asc');
        return $collection;
    }

    /**
     * get item url
     *
     * @param \Osme_CustomMenu_Model_Menu $item
     * @return string
     */
    public function getItemUrl(Osme_CustomMenu_Model_Menu $item)
    {
        $url = ltrim($item->getUrl());
        return (strpos($url, 'javascript:') === false) ? Mage::getBaseUrl() . $url : $url;
    }

    public function getDynamicBlock(Osme_CustomMenu_Model_Menu $item) {
        $block = '';
        if ($item->getSourceAttribute()) {
            /** @var $attribute Mage_Catalog_Model_Resource_Eav_Attribute */
            $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', $item->getSourceAttribute());

            /** @var $catalogIndexAttribute Mage_CatalogIndex_Model_Attribute */
            $catalogIndexAttribute =  Mage::getSingleton('catalogindex/attribute');
            /** @var $rootCategory Mage_Catalog_Model_Category */
            $rootCategory = Mage::getModel('catalog/category')->load($item->getDefaultCategoryId());
            $entityFilter = $rootCategory->getProductCollection()->getSelect()->distinct();
            $activeOptions = array_keys($catalogIndexAttribute->getCount($attribute, $entityFilter));
            if ($attribute->usesSource()) {
                $allOptions = $attribute->getSource()->getAllOptions(false);
                $items = array();
                foreach ($allOptions as $_option) {
                    if (in_array($_option['value'], $activeOptions)) {
                        $items[] = $_option;
                    }
                }
                if (!empty($items)) {
                    $block .= "<ul>\n";
                    $odd = false;
                    foreach ($items as $_item) {
                        $class = ($odd) ? 'odd' : 'even';
                        $odd ^= 1;
                        $class = " class=\"$class\"";

                        $route = 'catalog/category/view';
                        $params = array(
                            'id' => $rootCategory->getId(),
                            '_query' => array($attribute->getAttributeCode() => $_item['value']),
                            '_use_rewrite' => true,
                        );

                        $result = new Varien_Object();
                        Mage::dispatchEvent(
                            'custom_menu_popup_update_item_url',
                            array('route' => $route, 'params' => $params, 'result' => $result)
                        );
                        if ($result->getUrl()) {
                            $href = $result->getUrl();
                        } else {
                            $href = $rootCategory->getUrl() . '?' . http_build_query($params['_query']);
                        }

                        $block .= "<li{$class}><a href=\"{$href}\">{$this->escapeHtml($_item['label'])}</a></li>";
                    }
                    $block .= "</ul>\n";
                }
            }
        }
        return $block;
    }
}
