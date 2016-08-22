<?php

class ClientDTO {

    var $roc_id;
    var $business_name;
    var $business_phone;
    var $business_email;

    function getRoc_id() {
        return $this->roc_id;
    }
    function setRoc_id($roc_idIn) {
        $this->roc_id = $roc_idIn;
    }

    function getBusiness_name() {
        return $this->business_name;
    }
    function setBusiness_name($business_nameIn) {
        $this->business_name = $business_nameIn;
    }

    function getBusiness_phone() {
        return $this->business_phone;
    }
    function setBusiness_phone($business_phoneIn) {
        $this->business_phone = $business_phoneIn;
    }

    function getBusiness_email() {
        return $this->business_email;
    }
    function setBusiness_email($business_emailIn) {
        $this->business_email = $business_emailIn;
    }


    function setAll($roc_idIn,
                    $business_nameIn,
                    $business_phoneIn,
                    $business_emailIn) {
        $this->roc_id = $roc_idIn;
        $this->business_name = $business_nameIn;
        $this->business_phone = $business_phoneIn;
        $this->business_email = $business_emailIn;
    }


    function hasEqualMapping($valueObject) {

        if ($valueObject->getRoc_id() != $this->roc_id) {
            return(false);
        }
        if ($valueObject->getBusiness_name() != $this->business_name) {
            return(false);
        }
        if ($valueObject->getBusiness_phone() != $this->business_phone) {
            return(false);
        }
        if ($valueObject->getBusiness_email() != $this->business_email) {
            return(false);
        }

        return true;
    }


    function toString() {
        $out = $this->getDaogenVersion();
        $out = $out."\nclass ClientDTO, mapping to table roc_client\n";
        $out = $out."Persistent attributes: \n";
        $out = $out."roc_id = ".$this->roc_id."\n";
        $out = $out."business_name = ".$this->business_name."\n";
        $out = $out."business_phone = ".$this->business_phone."\n";
        $out = $out."business_email = ".$this->business_email."\n";
        return $out;
    }

}