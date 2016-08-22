<?php
/**
 * Created by IntelliJ IDEA.
 * User: lucasnascimento
 * Date: 25/06/2016
 * Time: 9:44 AM
 */

require_once ('models/ClientDTODao.php');

class Clients {

    public $client;
    
    public function __construct(ClientDTO $client) {
        $this -> client = $client;
    }
    
    public static function createClient (ClientDTO $client) {
        $_clientDAO = new ClientDTODao();
        $_clientDAO->create($client);
    }

    public static function saveClient (ClientDTO $client) {
        $_clientDAO = new ClientDTODao();
        $_clientDAO->save($client);
    }
    
    public static function deleteClient(ClientDTO $client) {
        $_clientDAO = new ClientDTODao();
        $_clientDAO->delete($client);
    }

    public static function getLastId() {
        $_clientDAO = new ClientDTODao();
        return $_clientDAO->getLastId();
    }

    public static function getObject ($client_id) {
        $_clientDAO = new ClientDTODao();
        return $_clientDAO->getObject($client_id);
    }
    
    public static function loadAll () {
        $_clientDAO = new ClientDTODao();
        return $_clientDAO->loadAll();
    }

    

}
