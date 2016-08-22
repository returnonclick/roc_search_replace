<?php

class MetaDTO {

    var $meta_id;
    var $roc_id;
    var $meta_key;
    var $meta_value;

    function __construct () {}
    
    function setNewMeta ($roc_idIn,
                         $meta_keyIn,
                         $meta_valueIn ) {
        $this->roc_id = $roc_idIn;
        $this->meta_key = $meta_keyIn;
        $this->meta_value = $meta_valueIn;
    }

    function getMeta_id() {
        return $this->meta_id;
    }
    function setMeta_id($meta_idIn) {
        $this->meta_id = $meta_idIn;
    }

    function getRoc_id() {
        return $this->roc_id;
    }
    function setRoc_id($roc_idIn) {
        $this->roc_id = $roc_idIn;
    }

    function getMeta_key() {
        return $this->meta_key;
    }
    function setMeta_key($meta_keyIn) {
        $this->meta_key = $meta_keyIn;
    }

    function getMeta_value() {
        return $this->meta_value;
    }
    function setMeta_value($meta_valueIn) {
        $this->meta_value = $meta_valueIn;
    }

    function setAll($meta_idIn,
                    $roc_idIn,
                    $meta_keyIn,
                    $meta_valueIn) {
        $this->meta_id = $meta_idIn;
        $this->roc_id = $roc_idIn;
        $this->meta_key = $meta_keyIn;
        $this->meta_value = $meta_valueIn;
    }

    function hasEqualMapping($valueObject) {

        if ($valueObject->getMeta_id() != $this->meta_id) {
            return(false);
        }
        if ($valueObject->getRoc_id() != $this->roc_id) {
            return(false);
        }
        if ($valueObject->getMeta_key() != $this->meta_key) {
            return(false);
        }
        if ($valueObject->getMeta_value() != $this->meta_value) {
            return(false);
        }

        return true;
    }

    function toString() {
        $out = $this->getDaogenVersion();
        $out = $out."\nclass MetaDTO, mapping to table roc_meta\n";
        $out = $out."Persistent attributes: \n";
        $out = $out."meta_id = ".$this->meta_id."\n";
        $out = $out."roc_id = ".$this->roc_id."\n";
        $out = $out."meta_key = ".$this->meta_key."\n";
        $out = $out."meta_value = ".$this->meta_value."\n";
        return $out;
    }


}
