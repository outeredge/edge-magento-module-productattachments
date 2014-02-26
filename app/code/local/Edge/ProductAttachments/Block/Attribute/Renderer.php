<?php

class Edge_ProductAttachments_Block_Attribute_Renderer extends Varien_Data_Form_Element_File
{
    public function getAfterElementHtml()
    {
        if ($this->getEscapedValue()){
            $fileUrl = Mage::getBaseUrl('media') . 'productattachment' . $this->getEscapedValue();
            return '<a href="' . $fileUrl . '" target="_blank">' . $this->getEscapedValue() . '</a>';
        }
        return $this->getData('after_element_html');
    }
}