<?php
/**
 * Created by IntelliJ IDEA.
 * User: lucasnascimento
 * Date: 24/06/2016
 * Time: 2:58 PM
 */

  function call($controller, $action) {

      require_once('controllers/' . $controller . '_controller.php');
      
      switch($controller) {
          case 'clients':

              require_once('models/clients.php');
              require_once('models/metas.php');
              $controller = new ClientsController();
              break;
      }

      $controller->{ $action }();
  }

  // we're adding an entry for the new controller and its actions
  $controllers = array('clients' => ['home', 'error', 'save', 'index', 'show','create', 'generate_sql', 'show_lock']);

  if (array_key_exists($controller, $controllers)) {
      if (in_array($action, $controllers[$controller])) {
          call($controller, $action);
      } else {
          call('clients', 'error');
      }
  } else {
      call('clients', 'error');
  }
