<?php

/**
 * Created by IntelliJ IDEA.
 * User: lucasnascimento
 * Date: 22/08/2016
 * Time: 9:41 AM
 */
class icit_srdb_roc extends icit_srdb {



    public function __construct( $args ) {
        parent::__construct( $args);
    }
    
    public function log( $type = '' ) {

        $args = array_slice( func_get_args(), 1 );

        $output = "";

        switch( $type ) {
            case 'error':
                list( $error_type, $error ) = $args;
                $output .= "$error_type: $error";
                break;
            case 'search_replace_table_start':
                list( $table, $search, $replace ) = $args;
                $output .= "{$table}: replacing {$search} with {$replace}";
                break;
            case 'search_replace_table_end':
                list( $table, $report ) = $args;
                $time = number_format( $report[ 'end' ] - $report[ 'start' ], 8 );
                $output .= "{$table}: {$report['rows']} rows, {$report['change']} changes found, {$report['updates']} updates made in {$time} seconds";
                break;
            case 'search_replace_end':
                list( $search, $replace, $report ) = $args;
                $time = number_format( $report[ 'end' ] - $report[ 'start' ], 8 );
                $dry_run_string = $this->dry_run ? "would have been" : "were";
                $output .= "
Replacing {$search} with {$replace} on {$report['tables']} tables with {$report['rows']} rows
{$report['change']} changes {$dry_run_string} made
{$report['updates']} updates were actually made
It took {$time} seconds";
                break;
            case 'update_engine':
                list( $table, $report, $engine ) = $args;
                $output .= $table . ( $report[ 'converted' ][ $table ] ? ' has been' : 'has not been' ) . ' converted to ' . $engine;
                break;
            case 'update_collation':
                list( $table, $report, $collation ) = $args;
                $output .= $table . ( $report[ 'converted' ][ $table ] ? ' has been' : 'has not been' ) . ' converted to ' . $collation;
                break;
        }

        if ( $this->verbose )
            echo $output . "\n";

    }

}