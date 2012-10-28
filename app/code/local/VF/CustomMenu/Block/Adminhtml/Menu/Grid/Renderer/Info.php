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
 * Menu Grid Info Renderer
 *
 * @category   VF
 * @package    VF_CustomMenu
 * @subpackage Block
 * @author     Vladimir Fishchenko <vladimir.fishchenko@gmail.com>
 */
class VF_CustomMenu_Block_Adminhtml_Menu_Grid_Renderer_Info
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /**
     * Render information about menu item
     *
     * @param   Varien_Object $row
     * @return  string
     */
    public function render(Varien_Object $row)
    {
        $helper = Mage::helper('menu');
        switch ($row->getType()) {
            case VF_CustomMenu_Model_Resource_Menu_Attribute_Source_Type::LINK_INTERNAL:
                return '<strong>' . $helper->__('Path') . ':</strong> ' . $row->getUrl();
                break;
            case VF_CustomMenu_Model_Resource_Menu_Attribute_Source_Type::LINK_EXTERNAL:
                return '<strong>' . $helper->__('Link') . ':</strong> ' . $row->getUrl();
                break;
            case VF_CustomMenu_Model_Resource_Menu_Attribute_Source_Type::CATEGORY:
                return '<strong>' . $helper->__('Category') . ':</strong> '
                    . Mage::getModel('catalog/category')->load($row->getDefaultCategory(), array('name'))->getName();
                break;
            case VF_CustomMenu_Model_Resource_Menu_Attribute_Source_Type::ATTRIBUTE:
                return '<strong>' . $helper->__('Attribute code') . ':</strong> '
                    . $row->getSourceAttribute()
                    . ' <strong>' . $helper->__('Category') . ':</strong> '
                    . Mage::getModel('catalog/category')->load($row->getDefaultCategory(), array('name'))->getName();
                break;
            default:
                return '';
        }
    }
}