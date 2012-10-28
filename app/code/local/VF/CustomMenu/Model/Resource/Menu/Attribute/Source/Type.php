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
 * VF Custom Menu Item Types
 *
 * @category   VF
 * @package    VF_CustomMenu
 * @subpackage Model
 * @author     Vladimir Fishchenko <vladimir.fishchenko@gmail.com>
 */
class VF_CustomMenu_Model_Resource_Menu_Attribute_Source_Type
{
    const LINK_INTERNAL = 1;
    const LINK_EXTERNAL = 2;
    const CATEGORY      = 3;
    const ATTRIBUTE     = 4;

    /**
     * Get Menu Item Type Values
     *
     * @return array
     */
    public static function getValues()
    {
        $helper = Mage::helper('menu');
        return array(
            self::LINK_INTERNAL => $helper->__('Link Internal'),
            self::LINK_EXTERNAL => $helper->__('Link External'),
            self::CATEGORY      => $helper->__('Category'),
            self::ATTRIBUTE     => $helper->__('Attribute Values'),
        );
    }
}