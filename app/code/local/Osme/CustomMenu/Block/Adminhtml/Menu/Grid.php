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
 * Menu grid
 *
 * @category   Osme
 * @package    Osme_CustomMenu
 * @subpackage Block
 * @author     Vladimir Fishchenko <vladimir.fishchenko@gmail.com>
 */
class Osme_CustomMenu_Block_Adminhtml_Menu_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Init grid
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('menuGrid');
        $this->setDefaultSort('position');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection for grid
     *
     * @return this
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('menu/menu')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid columns
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('item_id', array(
            'header'    =>  $this->__('ID'),
            'align'     =>  'right',
            'width'     =>  '50px',
            'type'      =>  'int',
            'index'     =>  'item_id'
        ));

        $this->addColumn('label', array(
            'header'    =>  $this->__('Label'),
            'align'     =>  'left',
            'index'     =>  'label'
        ));

        $this->addColumn('url', array(
            'header'    =>  $this->__('Url'),
            'align'     =>  'left',
            'index'     =>  'url'
        ));

        $this->addColumn('title', array(
            'header'    =>  $this->__('Title'),
            'align'     =>  'left',
            'index'     =>  'title'
        ));

        $this->addColumn('position', array(
            'header'    =>  $this->__('Position'),
            'align'     =>  'left',
            'width'     =>  '50px',
            'index'     =>  'position'
        ));

        return parent::_prepareColumns();
    }

    /**
     * get the row url for edit
     *
     * @param $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    /**
     * prepare mass action methods
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('item_id');
        $this->getMassactionBlock()->setFormFieldName('menu');

        $this->getMassactionBlock()->addItem('delete', array(
            'label'    => $this->__('Delete'),
            'url'      => $this->getUrl('*/*/massDelete'),
            'confirm'  => $this->__('Are you sure?')
        ));

        return parent::_prepareMassaction();
    }

    /**
     * get the grid url for ajax updates
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }
}
