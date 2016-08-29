<?php

/**
 * Created by IntelliJ IDEA.
 * User: lucasnascimento
 * Date: 22/08/2016
 * Time: 9:41 AM
 */

require_once( 'controllers/srdb.class.php' );
require_once ('ConfigDB.php');

class icit_srdb_roc extends icit_srdb {

    public function __construct( $SEARCH, $REPLACE ) {

        $args = array (
            'verbose' => 0,
            'dry_run' => false,
            'host' => ConfigDB::HOST,
            'user' => ConfigDB::USERNAME,
            'name' => ConfigDB::DB_CUSTOMER,
            'pass' => ConfigDB::PASSWORD,
            'search' => $SEARCH,
            'replace' => $REPLACE
        );
        
        parent::__construct( $args);
    }

}