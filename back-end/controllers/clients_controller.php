<?php
/**
 * Created by IntelliJ IDEA.
 * User: lucasnascimento
 * Date: 24/06/2016
 * Time: 2:53 PM
 */

// always good here
header( 'HTTP/1.1 200 OK' );
header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
header('Pragma: no-cache'); // HTTP 1.0.
header('Expires: 0'); // Proxies.

require_once( 'srdb.class.php' );
require_once ('models/ClientDTO.php');
require_once ('models/MetaDTO.php');
require_once ('config/MetaConstants.php');
require_once ('DataBaseCustomer.php');
require_once ('ConfigDB.php');

//require_once ('Search-Replace-DB-master/SearchReplace.php');

  class ClientsController {
      
      
      public function index() {
          // we store all the posts in a variable
          $clients = Clients::loadAll();
          require_once('views/clients/index.php');
      }

      private function create() {
          $business_name  = !empty($_POST['business_name']) ? $_POST['business_name'] : "";
          $business_phone = !empty($_POST['business_phone']) ? $_POST['business_phone'] : "";
          $business_email = !empty($_POST['business_email']) ? $_POST['business_email'] : "";
          $client = new ClientDTO();
          $client->setBusiness_name($business_name);
          $client->setBusiness_phone($business_phone);
          $client->setBusiness_email($business_email);
          Clients::createClient($client);
          $client_id = Clients::getLastId();
          $this -> createMeta($client_id);
          return $client_id;
      }

      private function update($client_id) {
          $business_name  = !empty($_POST['business_name']) ? $_POST['business_name'] : "";
          $business_phone = !empty($_POST['business_phone']) ? $_POST['business_phone'] : "";
          $business_email = !empty($_POST['business_email']) ? $_POST['business_email'] : "";
          $client = Clients::getObject($client_id);
          $client->setBusiness_name($business_name);
          $client->setBusiness_phone($business_phone);
          $client->setBusiness_email($business_email);
          Clients::saveClient($client);
          $this -> updateMeta($client_id);
      }

      private function createMeta($client_id) {

          //$_POST data
          $main_keyword         = !empty($_POST['main_keyword'])         ? $_POST['main_keyword']        : "";
          $about_us             = !empty($_POST['about_us'])             ? $_POST['about_us']            : "";
          $about_us_short       = !empty($_POST['about_us_short'])       ? $_POST['about_us_short']      : "";
          $service_1            = !empty($_POST['service_1'])            ? $_POST['service_1']           : "";
          $service_1_text       = !empty($_POST['service_1_text'])       ? $_POST['service_1_text']      : "";
          $service_1_excerpt    = !empty($_POST['service_1_excerpt'])    ? $_POST['service_1_excerpt']   : "";
          $area_1               = !empty($_POST['area_1'])               ? $_POST['area_1']              : "";
          $service_2            = !empty($_POST['service_2'])            ? $_POST['service_2']           : "";
          $service_2_text       = !empty($_POST['service_2_text'])       ? $_POST['service_2_text']      : "";
          $service_2_excerpt    = !empty($_POST['service_2_excerpt'])    ? $_POST['service_2_excerpt']   : "";
          $area_2               = !empty($_POST['area_2'])               ? $_POST['area_2']              : "";
          $service_3            = !empty($_POST['service_3'])            ? $_POST['service_3']           : "";
          $service_3_text       = !empty($_POST['service_3_text'])       ? $_POST['service_3_text']      : "";
          $service_3_excerpt    = !empty($_POST['service_3_excerpt'])    ? $_POST['service_3_excerpt']   : "";
          $area_3               = !empty($_POST['area_3'])               ? $_POST['area_3']              : "";
          $service_4            = !empty($_POST['service_4'])            ? $_POST['service_4']           : "";
          $service_4_text       = !empty($_POST['service_4_text'])       ? $_POST['service_4_text']      : "";
          $service_4_excerpt    = !empty($_POST['service_4_excerpt'])    ? $_POST['service_4_excerpt']   : "";
          $area_4               = !empty($_POST['area_4'])               ? $_POST['area_4']              : "";
          $testimonial_1        = !empty($_POST['testimonial_1'])        ? $_POST['testimonial_1']       : "";
          $testimonial_1_text   = !empty($_POST['testimonial_1_text'])   ? $_POST['testimonial_1_text']  : "";
          $testimonial_2        = !empty($_POST['testimonial_2'])        ? $_POST['testimonial_2']       : "";
          $testimonial_2_text   = !empty($_POST['testimonial_2_text'])   ? $_POST['testimonial_2_text']  : "";

          //Main Keyword
          $main_keyword_meta = new MetaDTO();
          $main_keyword_meta -> setNewMeta($client_id, MetaConstants::MAIN_KEYWORD, $main_keyword);
          Metas::createMeta($main_keyword_meta);
          
          
          //About Us
          $about_us_meta = new MetaDTO();
          $about_us_meta -> setNewMeta($client_id, MetaConstants::ABOUT_US, $about_us);
          Metas::createMeta($about_us_meta);

          //About Us
          $about_us_short_meta = new MetaDTO();
          $about_us_short_meta -> setNewMeta($client_id, MetaConstants::ABOUT_US_SHORT, $about_us_short);
          Metas::createMeta($about_us_short_meta);

          //Service 1
          $service_1_meta = new MetaDTO();
          $service_1_meta -> setNewMeta($client_id, MetaConstants::SERVICE_1, $service_1);
          Metas::createMeta($service_1_meta);

          //Service 1 Text
          $service_1_text_meta = new MetaDTO();
          $service_1_text_meta -> setNewMeta($client_id, MetaConstants::SERVICE_1_TEXT, $service_1_text);
          Metas::createMeta($service_1_text_meta);

          //Service 1 Excerpt
          $service_1_excerpt_meta = new MetaDTO();
          $service_1_excerpt_meta -> setNewMeta($client_id, MetaConstants::SERVICE_1_EXCERPT, $service_1_excerpt);
          Metas::createMeta($service_1_excerpt_meta);

          //Area 1
          $area_1_meta = new MetaDTO();
          $area_1_meta -> setNewMeta($client_id, MetaConstants::AREA_1, $area_1);
          Metas::createMeta($area_1_meta);

          //Service 2
          $service_2_meta = new MetaDTO();
          $service_2_meta -> setNewMeta($client_id, MetaConstants::SERVICE_2, $service_2);
          Metas::createMeta($service_2_meta);

          //Service 2 Text
          $service_2_text_meta = new MetaDTO();
          $service_2_text_meta -> setNewMeta($client_id, MetaConstants::SERVICE_2_TEXT, $service_2_text);
          Metas::createMeta($service_2_text_meta);

          //Service 2 Excerpt
          $service_2_excerpt_meta = new MetaDTO();
          $service_2_excerpt_meta -> setNewMeta($client_id, MetaConstants::SERVICE_2_EXCERPT, $service_2_excerpt);
          Metas::createMeta($service_2_excerpt_meta);

          //Area 2
          $area_2_meta = new MetaDTO();
          $area_2_meta -> setNewMeta($client_id, MetaConstants::AREA_2, $area_2);
          Metas::createMeta($area_2_meta);

          //Service 3
          $service_3_meta = new MetaDTO();
          $service_3_meta -> setNewMeta($client_id, MetaConstants::SERVICE_3, $service_3);
          Metas::createMeta($service_3_meta);

          //Service 3 Text
          $service_3_text_meta = new MetaDTO();
          $service_3_text_meta -> setNewMeta($client_id, MetaConstants::SERVICE_3_TEXT, $service_3_text);
          Metas::createMeta($service_3_text_meta);

          //Service 3 Excerpt
          $service_3_excerpt_meta = new MetaDTO();
          $service_3_excerpt_meta -> setNewMeta($client_id, MetaConstants::SERVICE_3_EXCERPT, $service_3_excerpt);
          Metas::createMeta($service_3_excerpt_meta);

          //Area 3
          $area_3_meta = new MetaDTO();
          $area_3_meta -> setNewMeta($client_id, MetaConstants::AREA_3, $area_3);
          Metas::createMeta($area_3_meta);

          //Service 4
          $service_4_meta = new MetaDTO();
          $service_4_meta -> setNewMeta($client_id, MetaConstants::SERVICE_4, $service_4);
          Metas::createMeta($service_4_meta);

          //Service 4 Text
          $service_4_text_meta = new MetaDTO();
          $service_4_text_meta -> setNewMeta($client_id, MetaConstants::SERVICE_4_TEXT, $service_4_text);
          Metas::createMeta($service_4_text_meta);

          //Service 4 Excerpt
          $service_4_excerpt_meta = new MetaDTO();
          $service_4_excerpt_meta -> setNewMeta($client_id, MetaConstants::SERVICE_4_EXCERPT, $service_4_excerpt);
          Metas::createMeta($service_4_excerpt_meta);

          //Area 4
          $area_4_meta = new MetaDTO();
          $area_4_meta -> setNewMeta($client_id, MetaConstants::AREA_4, $area_4);
          Metas::createMeta($area_4_meta);

          //Testimonial 1
          $testimonial_1_meta = new MetaDTO();
          $testimonial_1_meta -> setNewMeta($client_id, MetaConstants::TESTIMONIAL_1, $testimonial_1);
          Metas::createMeta($testimonial_1_meta);

          //Testimonial 1 Text
          $testimonial_1_text_meta = new MetaDTO();
          $testimonial_1_text_meta -> setNewMeta($client_id, MetaConstants::TESTIMONIAL_1_TEXT, $testimonial_1_text);
          Metas::createMeta($testimonial_1_text_meta);

          //Testimonial 2
          $testimonial_2_meta = new MetaDTO();
          $testimonial_2_meta -> setNewMeta($client_id, MetaConstants::TESTIMONIAL_2, $testimonial_2);
          Metas::createMeta($testimonial_2_meta);

          //Testimonial 2 Text
          $testimonial_2_text_meta = new MetaDTO();
          $testimonial_2_text_meta -> setNewMeta($client_id, MetaConstants::TESTIMONIAL_2_TEXT, $testimonial_2_text);
          Metas::createMeta($testimonial_2_text_meta);

      }
      
      private function updateMeta($client_id) {

          //$_POST data
          $main_keyword         = !empty($_POST['main_keyword'])         ? $_POST['main_keyword']        : "";
          $about_us             = !empty($_POST['about_us'])             ? $_POST['about_us']            : "";
          $about_us_short       = !empty($_POST['about_us_short'])       ? $_POST['about_us_short']      : "";
          $service_1            = !empty($_POST['service_1'])            ? $_POST['service_1']           : "";
          $service_1_text       = !empty($_POST['service_1_text'])       ? $_POST['service_1_text']      : "";
          $service_1_excerpt    = !empty($_POST['service_1_excerpt'])    ? $_POST['service_1_excerpt']   : "";
          $area_1               = !empty($_POST['area_1'])               ? $_POST['area_1']              : "";
          $service_2            = !empty($_POST['service_2'])            ? $_POST['service_2']           : "";
          $service_2_text       = !empty($_POST['service_2_text'])       ? $_POST['service_2_text']      : "";
          $service_2_excerpt    = !empty($_POST['service_2_excerpt'])    ? $_POST['service_2_excerpt']   : "";
          $area_2               = !empty($_POST['area_2'])               ? $_POST['area_2']              : "";
          $service_3            = !empty($_POST['service_3'])            ? $_POST['service_3']           : "";
          $service_3_text       = !empty($_POST['service_3_text'])       ? $_POST['service_3_text']      : "";
          $service_3_excerpt    = !empty($_POST['service_3_excerpt'])    ? $_POST['service_3_excerpt']   : "";
          $area_3               = !empty($_POST['area_3'])               ? $_POST['area_3']              : "";
          $service_4            = !empty($_POST['service_4'])            ? $_POST['service_4']           : "";
          $service_4_text       = !empty($_POST['service_4_text'])       ? $_POST['service_4_text']      : "";
          $service_4_excerpt    = !empty($_POST['service_4_excerpt'])    ? $_POST['service_4_excerpt']   : "";
          $area_4               = !empty($_POST['area_4'])               ? $_POST['area_4']              : "";
          $testimonial_1        = !empty($_POST['testimonial_1'])        ? $_POST['testimonial_1']       : "";
          $testimonial_1_text   = !empty($_POST['testimonial_1_text'])   ? $_POST['testimonial_1_text']  : "";
          $testimonial_2        = !empty($_POST['testimonial_2'])        ? $_POST['testimonial_2']       : "";
          $testimonial_2_text   = !empty($_POST['testimonial_2_text'])   ? $_POST['testimonial_2_text']  : "";


          //Main Keyword
          $main_keyword_meta = new MetaDTO();
          $main_keyword_meta -> setNewMeta($client_id, MetaConstants::MAIN_KEYWORD, $main_keyword);
          Metas::saveMeta($main_keyword_meta);

          //About Us
          $about_us_meta = new MetaDTO();
          $about_us_meta -> setNewMeta($client_id, MetaConstants::ABOUT_US, $about_us);
          Metas::saveMeta($about_us_meta);

          //About Us
          $about_us_short_meta = new MetaDTO();
          $about_us_short_meta -> setNewMeta($client_id, MetaConstants::ABOUT_US_SHORT, $about_us_short);
          Metas::saveMeta($about_us_short_meta);

          //Service 1
          $service_1_meta = new MetaDTO();
          $service_1_meta -> setNewMeta($client_id, MetaConstants::SERVICE_1, $service_1);
          Metas::saveMeta($service_1_meta);

          //Service 1 Text
          $service_1_text_meta = new MetaDTO();
          $service_1_text_meta -> setNewMeta($client_id, MetaConstants::SERVICE_1_TEXT, $service_1_text);
          Metas::saveMeta($service_1_text_meta);

          //Service 1 Excerpt
          $service_1_excerpt_meta = new MetaDTO();
          $service_1_excerpt_meta -> setNewMeta($client_id, MetaConstants::SERVICE_1_EXCERPT, $service_1_excerpt);
          Metas::saveMeta($service_1_excerpt_meta);

          //Area 1
          $area_1_meta = new MetaDTO();
          $area_1_meta -> setNewMeta($client_id, MetaConstants::AREA_1, $area_1);
          Metas::saveMeta($area_1_meta);

          //Service 2
          $service_2_meta = new MetaDTO();
          $service_2_meta -> setNewMeta($client_id, MetaConstants::SERVICE_2, $service_2);
          Metas::saveMeta($service_2_meta);

          //Service 2 Text
          $service_2_text_meta = new MetaDTO();
          $service_2_text_meta -> setNewMeta($client_id, MetaConstants::SERVICE_2_TEXT, $service_2_text);
          Metas::saveMeta($service_2_text_meta);

          //Service 2 Excerpt
          $service_2_excerpt_meta = new MetaDTO();
          $service_2_excerpt_meta -> setNewMeta($client_id, MetaConstants::SERVICE_2_EXCERPT, $service_2_excerpt);
          Metas::saveMeta($service_2_excerpt_meta);

          //Area 2
          $area_2_meta = new MetaDTO();
          $area_2_meta -> setNewMeta($client_id, MetaConstants::AREA_2, $area_2);
          Metas::saveMeta($area_2_meta);

          //Service 3
          $service_3_meta = new MetaDTO();
          $service_3_meta -> setNewMeta($client_id, MetaConstants::SERVICE_3, $service_3);
          Metas::saveMeta($service_3_meta);

          //Service 3 Text
          $service_3_text_meta = new MetaDTO();
          $service_3_text_meta -> setNewMeta($client_id, MetaConstants::SERVICE_3_TEXT, $service_3_text);
          Metas::saveMeta($service_3_text_meta);

          //Service 3 Excerpt
          $service_3_excerpt_meta = new MetaDTO();
          $service_3_excerpt_meta -> setNewMeta($client_id, MetaConstants::SERVICE_3_EXCERPT, $service_3_excerpt);
          Metas::saveMeta($service_3_excerpt_meta);

          //Area 3
          $area_3_meta = new MetaDTO();
          $area_3_meta -> setNewMeta($client_id, MetaConstants::AREA_3, $area_3);
          Metas::saveMeta($area_3_meta);

          //Service 4
          $service_4_meta = new MetaDTO();
          $service_4_meta -> setNewMeta($client_id, MetaConstants::SERVICE_4, $service_4);
          Metas::saveMeta($service_4_meta);

          //Service 4 Text
          $service_4_text_meta = new MetaDTO();
          $service_4_text_meta -> setNewMeta($client_id, MetaConstants::SERVICE_4_TEXT, $service_4_text);
          Metas::saveMeta($service_4_text_meta);

          //Service 4 Excerpt
          $service_4_excerpt_meta = new MetaDTO();
          $service_4_excerpt_meta -> setNewMeta($client_id, MetaConstants::SERVICE_4_EXCERPT, $service_4_excerpt);
          Metas::saveMeta($service_4_excerpt_meta);

          //Area 4
          $area_4_meta = new MetaDTO();
          $area_4_meta -> setNewMeta($client_id, MetaConstants::AREA_4, $area_4);
          Metas::saveMeta($area_4_meta);

          //Testimonial 1
          $testimonial_1_meta = new MetaDTO();
          $testimonial_1_meta -> setNewMeta($client_id, MetaConstants::TESTIMONIAL_1, $testimonial_1);
          Metas::saveMeta($testimonial_1_meta);

          //Testimonial 1 Text
          $testimonial_1_text_meta = new MetaDTO();
          $testimonial_1_text_meta -> setNewMeta($client_id, MetaConstants::TESTIMONIAL_1_TEXT, $testimonial_1_text);
          Metas::saveMeta($testimonial_1_text_meta);

          //Testimonial 2
          $testimonial_2_meta = new MetaDTO();
          $testimonial_2_meta -> setNewMeta($client_id, MetaConstants::TESTIMONIAL_2, $testimonial_2);
          Metas::saveMeta($testimonial_2_meta);

          //Testimonial 2 Text
          $testimonial_2_text_meta = new MetaDTO();
          $testimonial_2_text_meta -> setNewMeta($client_id, MetaConstants::TESTIMONIAL_2_TEXT, $testimonial_2_text);
          Metas::saveMeta($testimonial_2_text_meta);

      }

      public function error() {
          require_once('views/clients/error.php');
      }

      public function save() {

          $client_id = $_POST['roc_id'];

          if ( empty( $client_id ) ) {

              $client_id = $this->create();
          } else {

              $this->update($client_id);
          }

          $client = Clients::getObject($client_id);
          $metas = Metas::getObject($client_id);
          require_once('views/clients/show_lock.php');
          
      }

      public function home() {
          require_once('views/clients/home.php');
      }

      public function show_lock() {
          $client_id = $_POST['client_id'];
          $client = Clients::getObject($client_id);
          $metas = Metas::getObject($client_id);
          require_once('views/clients/show.php');
      }

      public function show() {
          $client_id = $_POST['client_id'];
          $client = Clients::getObject($client_id);
          $metas = Metas::getObject($client_id);
          require_once('views/clients/show.php');
      }

      public function generate_sql() {

          $client_id = $_POST['client_id'];
          $client = Clients::getObject($client_id);

          $this -> SplitSQL('./file/rocmedia.sql', ";", $client_id . "-" . $client->business_name);

          //$GUID_FILE    = "new.rocmedia.com.au";
          //$GUID_LOCAL   = "localhost:8888/ROC-Client-System-Generator/website";

          $GUID_FILE    = "[Business-Name]";
          $GUID_LOCAL   = "Test 1";

          //SearchReplace::__init($GUID_FILE, $GUID_LOCAL);


          //$searchreplace =  icit_srdb::__construct();

          //$all_tables = array();
          $all_tables_mysql = DataBaseCustomer::execute('SHOW TABLES');
          //$table = mysqli_fetch_array($all_tables_mysql, MYSQLI_ASSOC);

          while ($table = mysqli_fetch_array($all_tables_mysql, MYSQLI_NUM)) {
              $all_tables[] = $table[0];
          }


          //print_r($all_tables);


          // call search replace class
          $args = array (
              'verbose' => 1,
              'dry_run' => '',
              'host' => ConfigDB::HOST,
              'user' => ConfigDB::USERNAME,
              'name' => ConfigDB::DB_CUSTOMER,
              'pass' => ConfigDB::PASSWORD,
              'search' => $GUID_FILE,
              'replace' => $GUID_LOCAL
          );


          echo '<pre>';

          print_r($args);

          $report = new icit_srdb_roc( $args );

          print_r($report);

          echo '</pre>';

          //SearchReplace::__init($GUID_FILE, $GUID_LOCAL);

          //$client_id = $_POST['client_id'];
          //$client = Clients::getObject($client_id);


          //$GUID_FILE    = "[Business-Name]";
          //$GUID_LOCAL   = "Test 1";

          //SearchReplace::__init(MetaConstants::BUSINESS_NAME, $client->business_name);
          //SearchReplace::__init($GUID_FILE, $GUID_LOCAL);

          /*

          SearchReplace::__init(MetaConstants::BUSINESS_PHONE, $client->business_phone);
          SearchReplace::__init(MetaConstants::BUSINESS_EMAIL, $client->business_email);

          $metas = Metas::getObject($client_id);

          foreach($metas as $meta) {
              print_r($meta->meta_value);
              SearchReplace::__init($meta->meta_key, $meta->meta_value);
          }

*/
          
          $this -> index();
      }

      public function SplitSQL($file, $delimiter, $log_file_name)
      {



          set_time_limit(0);

          if (is_file($file) === true)
          {
              $file = fopen($file, 'r');
              $log_file = fopen("./file/".$log_file_name.".sql", "w");

              if (is_resource($file) === true)
              {
                  $query = array();

                  while (feof($file) === false)
                  {
                      $query[] = fgets($file);

                      if (preg_match('~' . preg_quote($delimiter, '~') . '\s*$~iS', end($query)) === 1)
                      {
                          $query = trim(implode('', $query));

                          ;

                          if (DataBaseCustomer::executeFile($query) === false)
                          {
                              fwrite($log_file, $query . "\n");
                          }

                          else
                          {
                              fwrite($log_file, $query . "\n");
                          }

                          while (ob_get_level() > 0)
                          {
                              ob_end_flush();
                          }

                          flush();
                      }

                      if (is_string($query) === true)
                      {
                          $query = array();
                      }
                  }
                  fclose($log_file);
                  return fclose($file);
              }
          }

          return false;
      }
      
  }
