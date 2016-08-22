<?php

require_once ('models/MetaDTO.php');
require_once ('DataBaseDefault.php');

class MetaDTODao {

    // Cache contents:
    var $cacheOk;
    var $cacheData;
    
    function __construct() {
        $this->resetCache();
    }
    
    function resetCache() {
        $this->cacheOk = false;
        $this->cacheData = null;
    }
    
    function createValueObject() {
        return new MetaDTO();
    }

    function getObject($roc_id) {

        $valueObject = $this->createValueObject();
        $valueObject->setRoc_id($roc_id);
        $this->load($valueObject);
        return $valueObject;
    }
    
    function load($valueObject) {

        if (!$valueObject->getRoc_id()) {
            print "Can not select without Primary-Key!";
            return false;
        }

        $sql = "SELECT * FROM roc_meta WHERE (roc_id = ".$valueObject->getRoc_id().") ";

        if ($this->singleQuery($sql, $valueObject))
            return true;
        else
            return false;
    }

    function loadAllMetas($roc_id) {


        // Check the cache status and use Cache if possible.
        if ($this->cacheOk) {
            return $this->cacheData;
        }

        $sql = "SELECT * FROM roc_meta WHERE (roc_id = ".$roc_id.") ORDER BY meta_id ASC ";

        $searchResults = $this->listQuery($sql);

        // Update cache and mark it ready.
        $this->cacheData = $searchResults;
        $this->cacheOk = true;

        return $searchResults;
    }
    
    function loadAll() {


        // Check the cache status and use Cache if possible.
        if ($this->cacheOk) {
            return $this->cacheData;
        }

        $sql = "SELECT * FROM roc_meta ORDER BY meta_id ASC ";

        $searchResults = $this->listQuery($sql);

        // Update cache and mark it ready.
        $this->cacheData = $searchResults;
        $this->cacheOk = true;

        return $searchResults;
    }
    
    function create($valueObject) {

        $valueObject->setMeta_value( mysqli_real_escape_string(DataBase::getInstance()->getConnection(), $valueObject->getMeta_value()));

        $sql = "INSERT INTO roc_meta ( roc_id, meta_key, ";
        $sql = $sql."meta_value) VALUES (";
        $sql = $sql."".$valueObject->getRoc_id().", ";
        $sql = $sql."'".$valueObject->getMeta_key()."', ";
        $sql = $sql."'".$valueObject->getMeta_value()."') ";
        $result = $this->databaseUpdate($sql);


        return $result;
    }

    function save($valueObject) {

        $valueObject->setMeta_value( mysqli_real_escape_string(DataBase::getInstance()->getConnection(), $valueObject->getMeta_value()));

        $sql = "UPDATE roc_meta SET meta_value = '".$valueObject->getMeta_value()."'";
        $sql = $sql." WHERE (roc_id = ".$valueObject->getRoc_id().") AND ( meta_key = '".$valueObject->getMeta_key()."') ";
        $result = $this->databaseUpdate($sql);

        if ($result != 1) {
            print "PrimaryKey Error when updating DB!";
            return false;
        }

        return $result;
    }

    function delete($valueObject) {


        if (!$valueObject->getRoc_id()) {
            print "Can not delete without Primary-Key!";
            return false;
        }

        $sql = "DELETE FROM roc_meta WHERE (roc_id = ".$valueObject->getRoc_id().") ";
        $result = $this->databaseUpdate($sql);

        if ($result != 1) {
            print "PrimaryKey Error when updating DB!";
            return false;
        }
        return $result;
    }
    
    function deleteAll() {

        $sql = "DELETE FROM roc_meta";
        $result = $this->databaseUpdate($sql);

        return $result;
    }

    function countAll() {

        // Check the cache status and use Cache if possible.
        if ($this->cacheOk) {
            return count($this->cacheData);
        }

        $sql = "SELECT count(*) FROM roc_meta";
        $allRows = 0;

        $result = DataBase::execute($sql);

        if ($row = DataBase::nextRow($result))
            $allRows = $row[0];

        return $allRows;
    }
    
    function searchMatching($valueObject) {

        $first = true;
        $sql = "SELECT * FROM roc_meta WHERE 1=1 ";

        if ($valueObject->getMeta_id() != 0) {
            if ($first) { $first = false; }
            $sql = $sql."AND meta_id = ".$valueObject->getMeta_id()." ";
        }

        if ($valueObject->getRoc_id() != 0) {
            if ($first) { $first = false; }
            $sql = $sql."AND roc_id = ".$valueObject->getRoc_id()." ";
        }

        if ($valueObject->getMeta_key() != "") {
            if ($first) { $first = false; }
            $sql = $sql."AND meta_key LIKE '".$valueObject->getMeta_key()."%' ";
        }

        if ($valueObject->getMeta_value() != "") {
            if ($first) { $first = false; }
            $sql = $sql."AND meta_value LIKE '".$valueObject->getMeta_value()."%' ";
        }


        $sql = $sql."ORDER BY meta_id ASC ";

        // Prevent accidential full table results.
        // Use loadAll if all rows must be returned.
        if ($first)
            return array();

        $searchResults = $this->listQuery($sql);

        return $searchResults;
    }
    
    function databaseUpdate($sql) {

        $result = DataBase::execute($sql);

        $this->resetCache();

        return $result;
    }
    
    function singleQuery($sql, $valueObject) {

        $result = DataBase::execute($sql);

        if ($row = DataBase::nextRow($result)) {

            $valueObject->setMeta_id($row[0]);
            $valueObject->setRoc_id($row[1]);
            $valueObject->setMeta_key($row[2]);
            $valueObject->setMeta_value($row[3]);
        } else {
            print " Object Not Found!";
            return false;
        }
        return $result;
    }
    
    function listQuery($sql) {

        $searchResults = array();
        $result = DataBase::execute($sql);

        while ($row = DataBase::nextRow($result)) {
            $temp = $this->createValueObject();

            $temp->setMeta_id($row[0]);
            $temp->setRoc_id($row[1]);
            $temp->setMeta_key($row[2]);
            $temp->setMeta_value($row[3]);
            array_push($searchResults, $temp);
        }

        return $searchResults;
    }

    function getLastId() {

        $result = DataBase::returnLast();
        return $result;

    }
    
}
