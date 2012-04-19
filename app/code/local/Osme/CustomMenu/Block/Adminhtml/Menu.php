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
 * Menu grid container
 *
 * @category   Osme
 * @package    Osme_CustomMenu
 * @subpackage Block
 * @author     Vladimir Fishchenko <vladimir.fishchenko@gmail.com>
 */
class Osme_CustomMenu_Block_Adminhtml_Menu extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Init grid container
     */
    public function __construct()
    {
        parent::__construct();
        $this->_controller = 'adminhtml_menu';
        $this->_blockGroup = 'menu';
        $this->_headerText = $this->__('Menu Item Manager');
        $this->_addButtonLabel = $this->__('Add Item');
    }
}