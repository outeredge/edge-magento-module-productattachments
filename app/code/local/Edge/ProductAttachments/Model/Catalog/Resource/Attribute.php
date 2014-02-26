<?php

class Edge_ProductAttachments_Model_Catalog_Resource_Attribute extends Mage_Catalog_Model_Resource_Attribute
{
    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        if ($object->getFrontendInput() === 'file'){
            $object->setBackendType('text');
            $object->setFrontendInputRenderer('productattachments/attribute_renderer');
        }
        return parent::_beforeSave($object);
    }
}
