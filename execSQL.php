<?php
/**
 * Created by IntelliJ IDEA.
 * User: lucasnascimento
 * Date: 30/06/2016
 * Time: 10:46 AM
 */

require_once ('./back-end/DataBaseCustomer.php');

//COPY DB
$sql = file_get_contents('./back-end/file/rocmedia.sql');
$sql = explode(";", $sql);
foreach($sql as $query)
    echo (DataBase::executeFile($query));
