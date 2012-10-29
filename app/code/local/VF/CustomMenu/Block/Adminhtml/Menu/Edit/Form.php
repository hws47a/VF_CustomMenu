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
 * Menu edit form
 *
 * @category   VF
 * @package    VF_CustomMenu
 * @subpackage Block
 * @author     Vladimir Fishchenko <vladimir.fishchenko@gmail.com>
 */
class VF_CustomMenu_Block_Adminhtml_Menu_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @return Mage_Adminhtml_Block_Widget_Form|void
     */
    protected function _prepareForm()
    {
        //add form
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id', null))),
            'method' => 'post'
        ));
        $form->setUseContainer(true);
        $this->setForm($form);

        //add fieldset
        $fieldSet = $form->addFieldset(
            'custom_menu_form',
            array('legend' => $this->__('Menu Item'))
        );

        $fieldSet->addField('label', 'text', array(
            'label'     => $this->__('Label'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'label'
        ));

        $fieldSet->addField('type', 'select', array(
            'label'     => $this->__('Type'),
            'class'     => 'required-entry',
            'required'  => 'true',
            'name'      => 'type',
            'options'   => VF_CustomMenu_Model_Resource_Menu_Attribute_Source_Type::getValues()
        ));

        $fieldSet->addField('url', 'text', array(
            'label'     => $this->__('Url'),
            'name'      => 'url',
            'note'      => $this->__(
                'Url without base url. Example: for url link http://www.domain.com/test-page.html use test-page.html'
            )
        ));

        $fieldSet->addField('title', 'text', array(
            'label'     => $this->__('Title'),
            'name'      => 'title'
        ));

        $fieldSet->addField('position', 'text', array(
            'label'     => $this->__('Position'),
            'name'      => 'position',
            'note'      => $this->__('Default 0')
        ));

        $fieldSet->addField('source_attribute', 'select', array(
            'label'     => $this->__('Source Attribute'),
            'name'      => 'source_attribute',
            'note'      => $this->__('If you select attribute, '
                . 'you will see dropdown with its values for layered navigation'),
            'values'    => Mage::getModel('menu/attribute')->getSourceAttributes()
        ));


        /** @var $categories Mage_Catalog_Model_Resource_Eav_Mysql4_Category_Collection */
        $categories = Mage::getModel('catalog/category')->getCollection();
        $categories->addAttributeToSelect('name');
        $values = array(array('label' => '', 'value' => ''));
        foreach ($categories as $_category) {
            $catId = $_category->getId();
            $values[] = array('value' => $catId, 'label' => $_category->getName() . " ($catId)");
        }

        $fieldSet->addField('default_category', 'select', array(
            'label'     => $this->__('Category'),
            'name'      => 'default_category',
            'note'      => $this->__('Custom default category'),
            'values'    => $values
        ));

        $data = Mage::registry('current_menu');
        $showChildren = false;
        if ($data) {
            $showChildren = $data->getShowChildren();
        }

        $fieldSet->addField('show_children', 'checkbox', array(
            'label'     => $this->__('Show Children'),
            'name'      => 'show_children',
            'checked'   => $showChildren
        ));

        if ($data) {
            $form->setValues($data->getData());
        }

        parent::_prepareForm();
    }
}
