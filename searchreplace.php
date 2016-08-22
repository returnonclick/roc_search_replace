<?php





/**
 * Form action attribute.
 *
 * @return null
 */
function icit_srdb_form_action( ) {
	global $step;
	echo basename( __FILE__ ) . '?step=' . intval( $step + 1 );
}


/**
 * Used to check the $_post tables array and remove any that don't exist.
 *
 * @param array $table The list of tables from the $_post var to be checked.
 *
 * @return array	Same array as passed in but with any tables that don'e exist removed.
 */
function check_table_array( $table = '' ){
	global $all_tables;
	return in_array( $table, $all_tables );
}


/**
 * Simply create a submit button with a JS confirm popup if there is need.
 *
 * @param string $text    Button string.
 * @param string $warning Submit warning pop up text.
 *
 * @return null
 */
function icit_srdb_submit( $text = 'Submit', $warning = '' ){
	$warning = str_replace( "'", "\'", $warning ); ?>
	<input type="submit" class="button" value="<?php echo htmlentities( $text, ENT_QUOTES, 'UTF-8' ); ?>" <?php echo ! empty( $warning ) ? 'onclick="if (confirm(\'' . htmlentities( $warning, ENT_QUOTES, 'UTF-8' ) . '\')){return true;}return false;"' : ''; ?>/> <?php
}


/**
 * Simple html esc
 *
 * @param string $string Thing that needs escaping
 * @param bool $echo   Do we echo or return?
 *
 * @return string    Escaped string.
 */
function esc_html_attr( $string = '', $echo = false ){
	$output = htmlentities( $string, ENT_QUOTES, 'UTF-8' );
	if ( $echo )
		echo $output;
	else
		return $output;
}


/**
 * Walk and array replacing one element for another. ( NOT USED ANY MORE )
 *
 * @param string $find    The string we want to replace.
 * @param string $replace What we'll be replacing it with.
 * @param array $data    Used to pass any subordinate arrays back to the
 * function for searching.
 *
 * @return array    The original array with the replacements made.
 */
function recursive_array_replace( $find, $replace, $data ) {
    if ( is_array( $data ) ) {
        foreach ( $data as $key => $value ) {
            if ( is_array( $value ) ) {
                recursive_array_replace( $find, $replace, $data[ $key ] );
            } else {
                // have to check if it's string to ensure no switching to string for booleans/numbers/nulls - don't need any nasty conversions
                if ( is_string( $value ) )
					$data[ $key ] = str_replace( $find, $replace, $value );
            }
        }
    } else {
        if ( is_string( $data ) )
			$data = str_replace( $find, $replace, $data );
    }
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
function recursive_unserialize_replace( $from = '', $to = '', $data = '', $serialised = false ) {

	// some unseriliased data cannot be re-serialised eg. SimpleXMLElements
	try {

		if ( is_string( $data ) && ( $unserialized = @unserialize( $data ) ) !== false ) {
			$data = recursive_unserialize_replace( $from, $to, $unserialized, true );
		}

		elseif ( is_array( $data ) ) {
			$_tmp = array( );
			foreach ( $data as $key => $value ) {
				$_tmp[ $key ] = recursive_unserialize_replace( $from, $to, $value, false );
			}

			$data = $_tmp;
			unset( $_tmp );
		}

		else {
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
 * Is the string we're dealing with a serialised string? ( NOT USED ANY MORE )
 *
 * @param string $data The string we want to check
 *
 * @return bool    true if serialised.
 */
function is_serialized_string( $data ) {
	// if it isn't a string, it isn't a serialized string
	if ( !is_string( $data ) )
		return false;
	$data = trim( $data );
	if ( preg_match( '/^s:[0-9]+:.*;$/s', $data ) ) // this should fetch all serialized strings
		return true;
	return false;
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
function icit_srdb_replacer( $connection, $search = '', $replace = '', $tables = array( ) ) {
	global $guid, $exclude_cols;

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
		    $fields = mysql_query( 'DESCRIBE ' . $table, $connection );
			while( $column = mysql_fetch_array( $fields ) )
				$columns[ $column[ 'Field' ] ] = $column[ 'Key' ] == 'PRI' ? true : false;

			// Count the number of rows we have in the table if large we'll split into blocks, This is a mod from Simon Wheatley
			$row_count = mysql_query( 'SELECT COUNT(*) FROM ' . $table, $connection );
			$rows_result = mysql_fetch_array( $row_count );
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
				$data = mysql_query( sprintf( 'SELECT * FROM %s LIMIT %d, %d', $table, $start, $end ), $connection );

				if ( ! $data )
					$report[ 'errors' ][] = mysql_error( );

				while ( $row = mysql_fetch_array( $data ) ) {

					$report[ 'rows' ]++; // Increment the row counter
					$current_row++;

					$update_sql = array( );
					$where_sql = array( );
					$upd = false;

					foreach( $columns as $column => $primary_key ) {
						if ( $guid == 1 && in_array( $column, $exclude_cols ) )
							continue;

						$edited_data = $data_to_fix = $row[ $column ];

						// Run a search replace on the data that'll respect the serialisation.
						$edited_data = recursive_unserialize_replace( $search, $replace, $data_to_fix );

						// Something was changed
						if ( $edited_data != $data_to_fix ) {
							$report[ 'change' ]++;
							$update_sql[] = $column . ' = "' . mysql_real_escape_string( $edited_data ) . '"';
							$upd = true;
						}

						if ( $primary_key )
							$where_sql[] = $column . ' = "' . mysql_real_escape_string( $data_to_fix ) . '"';
					}

					if ( $upd && ! empty( $where_sql ) ) {
						$sql = 'UPDATE ' . $table . ' SET ' . implode( ', ', $update_sql ) . ' WHERE ' . implode( ' AND ', array_filter( $where_sql ) );
						$result = mysql_query( $sql, $connection );
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
function __init( $srch, $rplc )
{

	// Tables to scanned
	$tables = array();


//QUERY DB
	$all_tables = array();
	$all_tables_mysql = @mysql_query('SHOW TABLES', DataBase::getInstance()->getConnection());

	print_r($all_tables_mysql);

	while ($table = mysql_fetch_array($all_tables_mysql)) {
		$all_tables[] = $table[0];
	}


	icit_srdb_replacer(DataBase::getInstance()->getConnection(), $srch, $rplc, $tables);
}