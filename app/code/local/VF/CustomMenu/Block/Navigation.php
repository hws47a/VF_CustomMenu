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
 * Custom menu block
 *
 * @category   VF
 * @package    VF_CustomMenu
 * @subpackage Block
 * @author     Vladimir Fishchenko <vladimir.fishchenko@gmail.com>
 */
class VF_CustomMenu_Block_Navigation extends Mage_Core_Block_Template
{
    protected function _construct()
    {
        $this->addData(array(
            'cache_lifetime' => 86400,
            'cache_tags' => array(Mage_Catalog_Model_Category::CACHE_TAG, Mage_Core_Model_Store_Group::CACHE_TAG),
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
     * @return VF_CustomMenu_Model_Resource_Menu_Collection
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
     * @param VF_CustomMenu_Model_Menu $item
     * @return string
     */
    public function getItemUrl(VF_CustomMenu_Model_Menu $item)
    {
        $url = ltrim($item->getUrl());
        switch ($item->getType()) {
            case VF_CustomMenu_Model_Resource_Menu_Attribute_Source_Type::LINK_INTERNAL:
                return Mage::getBaseUrl() . $url;
            case VF_CustomMenu_Model_Resource_Menu_Attribute_Source_Type::LINK_EXTERNAL:
                return $url;
            case VF_CustomMenu_Model_Resource_Menu_Attribute_Source_Type::CATEGORY:
                return $item->getCategory()->getUrl();
            case VF_CustomMenu_Model_Resource_Menu_Attribute_Source_Type::ATTRIBUTE:
                return 'javascript:;';
            default:
                return $url;
        }
    }

    /**
     * get Dynamic block
     * It's a attribute values or child categories
     *
     * @param VF_CustomMenu_Model_Menu $item
     * @param int $itemNumber
     * @return mixed
     */
    public function getDynamicBlock(VF_CustomMenu_Model_Menu $item, $itemNumber = null)
    {
        if (!$item->hasData('dynamic_block')) {
            $block = '';
            if ($item->getSourceAttribute()) {
                /** @var $attribute Mage_Catalog_Model_Resource_Eav_Attribute */
                $attribute = Mage::getSingleton('eav/config')
                    ->getAttribute('catalog_product', $item->getSourceAttribute());

                /** @var $catalogIndexAttribute Mage_CatalogIndex_Model_Attribute */
                $catalogIndexAttribute = Mage::getSingleton('catalogindex/attribute');
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
                        $block .= "<ul class='level0'>\n";
                        $odd = false;
                        $i = 0;
                        $count = count($items);
                        foreach ($items as $_item) {
                            ++$i;
                            $class = ($odd) ? 'odd' : 'even';
                            if ($itemNumber) {
                                $class .= ' nav-' . $itemNumber . '-' . $i;
                            }
                            if ($i == 1) {
                                $class .= ' first';
                            } elseif ($i == $count) {
                                $class .= ' last';
                            }
                            $odd ^= 1;
                            $class = " class=\"level1 $class\"";

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

                            $block .= "<li{$class}><a href=\"{$href}\">"
                                . "<span>{$this->escapeHtml($_item['label'])}</span></a></li>";
                        }
                        $block .= "</ul>\n";
                    }
                }
            }
            $item->setData('dynamic_block', $block);
        }
        return $item->getData('dynamic_block');
    }
}
