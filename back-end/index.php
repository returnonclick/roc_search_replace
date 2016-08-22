<?php
/**
 * Created by IntelliJ IDEA.
 * User: lucasnascimento
 * Date: 24/06/2016
 * Time: 2:49 PM
 */

if (isset($_GET['controller']) && isset($_GET['action'])) {
    $controller = $_GET['controller'];
    $action     = $_GET['action'];
} else {
    $controller = 'clients';
    $action     = 'index';
}

require_once('views/layout.php');