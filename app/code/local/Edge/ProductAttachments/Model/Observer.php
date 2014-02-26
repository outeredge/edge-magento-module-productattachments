<?php

class Edge_ProductAttachments_Model_Observer
{
    public function addFileUploadAttributeType(Varien_Event_Observer $observer)
    {
        $response = $observer->getEvent()->getResponse();
        $types = $response->getTypes();
        $types[] = array(
            'value' => 'file',
            'label' => Mage::helper('productattachments')->__('File')
        );
        $response->setTypes($types);
        return $this;
    }
    
    public function saveFileUploadAttribute(Varien_Event_Observer $observer)
    {
        $product = $observer->getEvent()->getProduct();
        
        if (isset($_FILES['product'])){
            
            foreach ($_FILES['product']['name'] as $attribute=>$filename){
                if ($filename){
                    
                    $_FILES[$attribute] = array(
                        'name'      => $filename,
                        'type'      => $_FILES['product']['type'][$attribute],
                        'tmp_name'  => $_FILES['product']['tmp_name'][$attribute],
                        'error'     => $_FILES['product']['error'][$attribute],
                        'size'      => $_FILES['product']['size'][$attribute],
                    );
                    
                    if ($uploaded = $this->_saveAttachment($attribute)){
                        $product->setData($attribute, $uploaded);
                    }
                }
            }
        }
        
        return $this;
    }
    
    protected function _saveAttachment($name)
    {
        $path = Mage::getBaseDir('media') . '/productattachment/';
        if (!file_exists(($path))){
            mkdir($path);
        }
        
        if (isset($_FILES['product']['name'][$name]) && (file_exists($_FILES['product']['tmp_name'][$name]))){

            try {
                $uploader = new Varien_File_Uploader($name);
                $image = $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'))
                    ->setAllowRenameFiles(true)
                    ->setFilesDispersion(true)
                    ->save($path, $_FILES['product']['name'][$name]);
                
                return $image['file'];

            } catch (Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getTraceAsString());
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                return false;
            }
        }

        return false;
    }
}