<?php

/**
 * Created by IntelliJ IDEA.
 * User: lucasnascimento
 * Date: 24/06/2016
 * Time: 10:59 AM
 */

require_once('./Datasource.php');
require_once('./ClientDTO.php');
require_once('./ClientDTODao.php');
require_once ('./MetaDTO.php');
require_once ('./MetaDTODao.php');



//require_once ('./DataBaseDefault.php');


class ClientDTOTest {


    private $_host = "localhost";
    private $_username = "root";
    private $_password = "Aus.2013";
    private $_database = "returnonclick_searchreplace";
    public $_connection;
    public $_client;
    public $_client_id;
    public $_client_dao;
    public $_meta;
    public $_meta_dao;

    function __construct() {




        $this -> _connection = new Datasource($this -> _host, $this -> _database,  $this -> _username, $this -> _password );

        $this->clientNew();

        $this -> saveClient($this -> _client);

        $this -> _client_id = $this ->  getLastClientID();
        
        $this->metaNew();

        $this->saveMeta($this->_meta);


    }

    function metaNew () {
        $this->_meta = new MetaDTO();
        $this -> _meta -> roc_id = $this -> _client_id;
        $this->_meta -> meta_key = "[Main-Keyword]";
        $this->_meta -> meta_value = "Test";
    }

    function clientNew () {
        $this -> _client = new ClientDTO();
        $this -> _client -> business_name = "Client 1";
        $this -> _client -> business_phone = "9999 999 999";
        $this -> _client -> business_email = "test@test.com.au";
    }

    function saveClient (ClientDTO $client) {
        $this -> _client_dao = new ClientDTODao();
        $this->_client_dao -> create($this->_connection, $client);
    }

    function saveMeta (MetaDTO $meta) {
        $this -> _meta_dao = new MetaDTODao();
        $this->_meta_dao -> create($this->_connection, $meta);
    }

    function getLastClientID () {
        return $this -> _client_dao -> getLastId($this->_connection);
    }


    

}

new ClientDTOTest();