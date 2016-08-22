<?php

require_once ('models/ClientDTO.php');
require_once ('DataBaseDefault.php');

class ClientDTODao {

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


    /**
     * createValueObject-method. This method is used when the Dao class needs
     * to create new value object instance. The reason why this method exists
     * is that sometimes the programmer may want to extend also the valueObject
     * and then this method can be overrided to return extended valueObject.
     * NOTE: If you extend the valueObject class, make sure to override the
     * clone() method in it!
     */
    function createValueObject() {
        return new ClientDTO();
    }


    /**
     * getObject-method. This will create and load valueObject contents from database
     * using given Primary-Key as identifier. This method is just a convenience method
     * for the real load-method which accepts the valueObject as a parameter. Returned
     * valueObject will be created using the createValueObject() method.
     */
    function getObject( $roc_id ) {

        $valueObject = $this->createValueObject();
        $valueObject->setRoc_id($roc_id);
        $this->load($valueObject);
        return $valueObject;
    }


    /**
     * load-method. This will load valueObject contents from database using
     * Primary-Key as identifier. Upper layer should use this so that valueObject
     * instance is created and only primary-key should be specified. Then call
     * this method to complete other persistent information. This method will
     * overwrite all other fields except primary-key and possible runtime variables.
     * If load can not find matching row, NotFoundException will be thrown.
     *
     * @param conn         This method requires working database connection.
     * @param valueObject  This parameter contains the class instance to be loaded.
     *                     Primary-key field must be set for this to work properly.
     */
    function load( $valueObject ) {

        if (!$valueObject->getRoc_id()) {
            print "Can not select without Primary-Key!";
            return false;
        }

        $sql = "SELECT * FROM roc_client WHERE (roc_id = ".$valueObject->getRoc_id().") ";

        if ($this->singleQuery( $sql, $valueObject))
            return true;
        else
            return false;
    }


    /**
     * LoadAll-method. This will read all contents from database table and
     * build an Vector containing valueObjects. Please note, that this method
     * will consume huge amounts of resources if table has lot's of rows.
     * This should only be used when target tables have only small amounts
     * of data.
     *
     * @param conn         This method requires working database connection.
     */
    function loadAll() {

        // Check the cache status and use Cache if possible.
        if ($this->cacheOk) {
            return $this->cacheData;
        }

        $sql = "SELECT * FROM roc_client ORDER BY roc_id ASC ";

        $searchResults = $this->listQuery($sql);

        // Update cache and mark it ready.
        $this->cacheData = $searchResults;
        $this->cacheOk = true;

        return $searchResults;
    }



    /**
     * create-method. This will create new row in database according to supplied
     * valueObject contents. Make sure that values for all NOT NULL columns are
     * correctly specified. Also, if this table does not use automatic surrogate-keys
     * the primary-key must be specified. After INSERT command this method will
     * read the generated primary-key back to valueObject if automatic surrogate-keys
     * were used.
     *
     * @param conn         This method requires working database connection.
     * @param valueObject  This parameter contains the class instance to be created.
     *                     If automatic surrogate-keys are not used the Primary-key
     *                     field must be set for this to work properly.
     */
    function create( $valueObject ) {

        $valueObject->setBusiness_name( mysqli_real_escape_string(DataBase::getInstance()->getConnection(), $valueObject->getBusiness_name()));

        $sql = "INSERT INTO roc_client ( business_name, business_phone, ";
        $sql = $sql."business_email) VALUES (";
        $sql = $sql."'".$valueObject->getBusiness_name()."', ";
        $sql = $sql."'".$valueObject->getBusiness_phone()."', ";
        $sql = $sql."'".$valueObject->getBusiness_email()."') ";
        
        $result = $this->databaseUpdate($sql);
        
        return $result;
    }


    /**
     * save-method. This method will save the current state of valueObject to database.
     * Save can not be used to create new instances in database, so upper layer must
     * make sure that the primary-key is correctly specified. Primary-key will indicate
     * which instance is going to be updated in database. If save can not find matching
     * row, NotFoundException will be thrown.
     *
     * @param conn         This method requires working database connection.
     * @param valueObject  This parameter contains the class instance to be saved.
     *                     Primary-key field must be set for this to work properly.
     */
    function save($valueObject) {

        $valueObject->setBusiness_name( mysqli_real_escape_string(DataBase::getInstance()->getConnection(), $valueObject->getBusiness_name()));

        $sql = "UPDATE roc_client SET business_name = '".$valueObject->getBusiness_name()."', ";
        $sql = $sql."business_phone = '".$valueObject->getBusiness_phone()."', ";
        $sql = $sql."business_email = '".$valueObject->getBusiness_email()."'";
        $sql = $sql." WHERE (roc_id = ".$valueObject->getRoc_id().") ";
        $result = $this->databaseUpdate($sql);

        if ($result != 1) {
            print "PrimaryKey Error when updating DB!";
            return false;
        }

        return $result;
    }


    /**
     * delete-method. This method will remove the information from database as identified by
     * by primary-key in supplied valueObject. Once valueObject has been deleted it can not
     * be restored by calling save. Restoring can only be done using create method but if
     * database is using automatic surrogate-keys, the resulting object will have different
     * primary-key than what it was in the deleted object. If delete can not find matching row,
     * NotFoundException will be thrown.
     *
     * @param conn         This method requires working database connection.
     * @param valueObject  This parameter contains the class instance to be deleted.
     *                     Primary-key field must be set for this to work properly.
     */
    function delete($valueObject) {


        if (!$valueObject->getRoc_id()) {
            print "Can not delete without Primary-Key!";
            return false;
        }

        $sql = "DELETE FROM roc_client WHERE (roc_id = ".$valueObject->getRoc_id().") ";
        $result = $this->databaseUpdate($sql);

        if ($result != 1) {
            print "PrimaryKey Error when updating DB!";
            return false;
        }
        return $result;
    }


    /**
     * deleteAll-method. This method will remove all information from the table that matches
     * this Dao and ValueObject couple. This should be the most efficient way to clear table.
     * Once deleteAll has been called, no valueObject that has been created before can be
     * restored by calling save. Restoring can only be done using create method but if database
     * is using automatic surrogate-keys, the resulting object will have different primary-key
     * than what it was in the deleted object. (Note, the implementation of this method should
     * be different with different DB backends.)
     *
     * @param conn         This method requires working database connection.
     */
    function deleteAll() {

        $sql = "DELETE FROM roc_client";
        $result = $this->databaseUpdate($sql);

        return $result;
    }


    /**
     * coutAll-method. This method will return the number of all rows from table that matches
     * this Dao. The implementation will simply execute "select count(primarykey) from table".
     * If table is empty, the return value is 0. This method should be used before calling
     * loadAll, to make sure table has not too many rows.
     *
     * @param conn         This method requires working database connection.
     */
    function countAll() {

        // Check the cache status and use Cache if possible.
        if ($this->cacheOk) {
            return count($this->cacheData);
        }

        $sql = "SELECT count(*) FROM roc_client";
        $allRows = 0;

        $result = DataBase::execute($sql);

        if ($row = DataBase::nextRow($result))
            $allRows = $row[0];

        return $allRows;
    }


    /**
     * searchMatching-Method. This method provides searching capability to
     * get matching valueObjects from database. It works by searching all
     * objects that match permanent instance variables of given object.
     * Upper layer should use this by setting some parameters in valueObject
     * and then  call searchMatching. The result will be 0-N objects in vector,
     * all matching those criteria you specified. Those instance-variables that
     * have NULL values are excluded in search-criteria.
     *
     * @param conn         This method requires working database connection.
     * @param valueObject  This parameter contains the class instance where search will be based.
     *                     Primary-key field should not be set.
     */
    function searchMatching($valueObject) {

        $first = true;
        $sql = "SELECT * FROM roc_client WHERE 1=1 ";

        if ($valueObject->getRoc_id() != 0) {
            if ($first) { $first = false; }
            $sql = $sql."AND roc_id = ".$valueObject->getRoc_id()." ";
        }

        if ($valueObject->getBusiness_name() != "") {
            if ($first) { $first = false; }
            $sql = $sql."AND business_name LIKE '".$valueObject->getBusiness_name()."%' ";
        }

        if ($valueObject->getBusiness_phone() != "") {
            if ($first) { $first = false; }
            $sql = $sql."AND business_phone LIKE '".$valueObject->getBusiness_phone()."%' ";
        }

        if ($valueObject->getBusiness_email() != "") {
            if ($first) { $first = false; }
            $sql = $sql."AND business_email LIKE '".$valueObject->getBusiness_email()."%' ";
        }


        $sql = $sql."ORDER BY roc_id ASC ";

        // Prevent accidential full table results.
        // Use loadAll if all rows must be returned.
        if ($first)
            return array();

        $searchResults = $this->listQuery($sql);

        return $searchResults;
    }


    /**
     * getDaogenVersion will return information about
     * generator which created these sources.
     */
    function getDaogenVersion() {
        return "DaoGen version 2.4.1";
    }


    /**
     * databaseUpdate-method. This method is a helper method for internal use. It will execute
     * all database handling that will change the information in tables. SELECT queries will
     * not be executed here however. The return value indicates how many rows were affected.
     * This method will also make sure that if cache is used, it will reset when data changes.
     *
     * @param conn         This method requires working database connection.
     * @param stmt         This parameter contains the SQL statement to be excuted.
     */
    function databaseUpdate($sql) {

        $result = DataBase::execute($sql);

        $this->resetCache();

        return $result;

    }



    /**
     * databaseQuery-method. This method is a helper method for internal use. It will execute
     * all database queries that will return only one row. The resultset will be converted
     * to valueObject. If no rows were found, NotFoundException will be thrown.
     *
     * @param conn         This method requires working database connection.
     * @param stmt         This parameter contains the SQL statement to be excuted.
     * @param valueObject  Class-instance where resulting data will be stored.
     */
    function singleQuery( $sql, $valueObject) {

        $result = DataBase::execute($sql);

        if ($row = DataBase::nextRow($result)) {

            $valueObject->setRoc_id($row[0]);
            $valueObject->setBusiness_name($row[1]);
            $valueObject->setBusiness_phone($row[2]);
            $valueObject->setBusiness_email($row[3]);
        } else {
            print " Object Not Found!";
            return false;
        }
        return $result;
    }


    /**
     * databaseQuery-method. This method is a helper method for internal use. It will execute
     * all database queries that will return multiple rows. The resultset will be converted
     * to the List of valueObjects. If no rows were found, an empty List will be returned.
     *
     * @param conn         This method requires working database connection.
     * @param stmt         This parameter contains the SQL statement to be excuted.
     */
    function listQuery($sql) {

        $searchResults = array();
        $result = DataBase::execute($sql);

        while ($row = DataBase::nextRow($result)) {
            $temp = $this->createValueObject();

            $temp->setRoc_id($row[0]);
            $temp->setBusiness_name($row[1]);
            $temp->setBusiness_phone($row[2]);
            $temp->setBusiness_email($row[3]);
            array_push($searchResults, $temp);
        }

        return $searchResults;
    }


    function getLastId() {

        $result = DataBase::returnLast();
        return $result;
        
    }
}

?>

