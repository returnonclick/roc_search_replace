<?php

/**
 * Created by IntelliJ IDEA.
 * User: lucasnascimento
 * Date: 30/06/2016
 * Time: 11:34 AM
 */
class SearchReplace
{
    
    /**
     * Simple html esc
     *
     * @param string $string Thing that needs escaping
     * @param bool $echo   Do we echo or return?
     *
     * @return string    Escaped string.
     */
    static function esc_html_attr( $string = '', $echo = false ){

        $output = htmlentities( $string, ENT_QUOTES, 'UTF-8' );
        if ( $echo )
            echo $output;
        else
            return $output;
    }


    /**
     * Take a serialised array and unserialise it replacing elements as needed and
     * unserialising any subordinate arrays and performing the replace on those too.
     *
     * @param string $from       String we're looking to replace.
     * @param string $to         What we want it to be replaced with
     * @param array  $data       Used to pass any subordinate arrays back to in.
     * @param bool   $serialised Does the array passed via $data need serialising.
     *
     * @return array	The original array with all elements replaced as needed.
     */
    static function recursive_unserialize_replace( $from = '', $to = '', $data = '', $serialised = false ) {

        // some unseriliased data cannot be re-serialised eg. SimpleXMLElements
        try {



            if ( is_string( $data ) && ( $unserialized = @unserialize( $data ) ) !== false ) {
                
                $data = self::recursive_unserialize_replace( $from, $to, $unserialized, true );
            }

            elseif ( is_array( $data ) ) {

                $_tmp = array( );
                foreach ( $data as $key => $value ) {

                    $_tmp[ $key ] = self::recursive_unserialize_replace( $from, $to, $value, false );

                }

                $data = $_tmp;
                unset( $_tmp );
            }

            else {
                echo "<pre>";
                print_r($data);
                echo "</pre>";

                if ( is_string( $data ) )
                    $data = str_replace( $from, $to, $data );
            }

            if ( $serialised )
                return serialize( $data );

        } catch( Exception $error ) {

        }

        return $data;
    }


    /**
     * The main loop triggered in step 5. Up here to keep it out of the way of the
     * HTML. This walks every table in the db that was selected in step 3 and then
     * walks every row and column replacing all occurences of a string with another.
     * We split large tables into 50,000 row blocks when dealing with them to save
     * on memmory consumption.
     *
     * @param mysql  $connection The db connection object
     * @param string $search     What we want to replace
     * @param string $replace    What we want to replace it with.
     * @param array  $tables     The tables we want to look at.
     *
     * @return array    Collection of information gathered during the run.
     */
    public static function icit_srdb_replacer( $search = '', $replace = '', $tables = array( ) ) {

        $myfile = fopen("./file/logUpdates.sql", "w");

        $report = array( 'tables' => 0,
            'rows' => 0,
            'change' => 0,
            'updates' => 0,
            'start' => microtime( ),
            'end' => microtime( ),
            'errors' => array( ),
        );

        if ( is_array( $tables ) && ! empty( $tables ) ) {
            foreach( $tables as $table ) {
                $report[ 'tables' ]++;

                $columns = array( );

                // Get a list of columns in this table
                $fields = DataBaseCustomer::execute( 'DESCRIBE ' . $table);


                while( $column = $fields -> fetch_array( MYSQLI_ASSOC ) )
                    $columns[ $column[ 'Field' ] ] = $column[ 'Key' ] == 'PRI' ? true : false;

                // Count the number of rows we have in the table if large we'll split into blocks, This is a mod from Simon Wheatley
                $row_count = DataBaseCustomer::execute( 'SELECT COUNT(*) FROM ' . $table );
                $rows_result = $row_count -> fetch_array( MYSQLI_NUM );
                $row_count = $rows_result[ 0 ];
                if ( $row_count == 0 )
                    continue;

                $page_size = 50000;
                $pages = ceil( $row_count / $page_size );

                for( $page = 0; $page < $pages; $page++ ) {

                    $current_row = 0;
                    $start = $page * $page_size;
                    $end = $start + $page_size;
                    // Grab the content of the table
                    $data = DataBaseCustomer::execute( sprintf( 'SELECT * FROM %s LIMIT %d, %d', $table, $start, $end ) );

                    if ( ! $data )
                        $report[ 'errors' ][] = mysql_error( );

                    while ( $row = $data -> fetch_array( MYSQLI_ASSOC ) ) {

                        $report[ 'rows' ]++; // Increment the row counter
                        $current_row++;

                        $update_sql = array( );
                        $where_sql = array( );
                        $upd = false;

                        foreach( $columns as $column => $primary_key ) {

                            $edited_data = $data_to_fix = $row[ $column ];

                            // Run a search replace on the data that'll respect the serialisation.
                            $edited_data = self::recursive_unserialize_replace( $search, $replace, $data_to_fix );

                            // Something was changed
                            if ( $edited_data != $data_to_fix ) {
                                $report[ 'change' ]++;
                                $update_sql[] = $column . ' = "' . DataBaseCustomer::getInstance()->getConnection()->real_escape_string( $edited_data ) . '"';
                                $upd = true;
                            }

                            if ( $primary_key )
                                $where_sql[] = $column . ' = "' . DataBaseCustomer::getInstance()->getConnection()->real_escape_string( $data_to_fix ) . '"';
                        }

                        if ( $upd && ! empty( $where_sql ) ) {
                            $sql = 'UPDATE ' . $table . ' SET ' . implode( ', ', $update_sql ) . ' WHERE ' . implode( ' AND ', array_filter( $where_sql ) );


                            fwrite($myfile, $sql . "\n");

                            $result = DataBaseCustomer::execute( $sql );


                            if ( ! $result )
                                $report[ 'errors' ][] = mysql_error( );
                            else
                                $report[ 'updates' ]++;

                        } elseif ( $upd ) {
                            $report[ 'errors' ][] = sprintf( '"%s" has no primary key, manual change needed on row %s.', $table, $current_row );
                        }

                    }
                }
            }

        }
        $report[ 'end' ] = microtime( );

        return $report;
    }


    /**
     * Take an array and turn it into an English formatted list. Like so:
     * array( 'a', 'b', 'c', 'd' ); = a, b, c, or d.
     *
     * @param array $input_arr The source array
     *
     * @return string    English formatted string
     */
    public static function __init( $srch, $rplc )
    {
        //$srch = self::esc_html_attr($srch, false);
        //s$rplc = self::esc_html_attr($rplc, false);

        //$char = '';

        //DataBaseCustomer::execute( 'SET NAMES ' . self::esc_html_attr($char, true) );

        $all_tables = array();
        $all_tables_mysql = DataBaseCustomer::execute('SHOW TABLES');

        
        
        while ($table = mysqli_fetch_array($all_tables_mysql, MYSQLI_NUM)) {
            $all_tables[] = $table[0];
        }

        self::icit_srdb_replacer($srch, $rplc, $all_tables);
    }
    
}