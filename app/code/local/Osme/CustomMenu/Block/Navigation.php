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
        return Mage::getBaseUrl() . $url;
    }
}
