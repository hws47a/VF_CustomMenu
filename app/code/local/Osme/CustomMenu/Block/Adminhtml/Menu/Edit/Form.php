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
 * Menu edit form
 *
 * @category   Osme
 * @package    Osme_CustomMenu
 * @subpackage Block
 * @author     Vladimir Fishchenko <vladimir.fishchenko@gmail.com>
 */
class Osme_CustomMenu_Block_Adminhtml_Menu_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
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

        $fieldSet->addField('url', 'text', array(
            'label'     => $this->__('Url'),
            'class'     => 'required-entry',
            'required'  => true,
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

        $data = Mage::registry('current_menu');
        if ($data) {
            $form->setValues($data->getData());
        }

        parent::_prepareForm();
    }
}
