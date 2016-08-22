<?php
/**
 * Created by IntelliJ IDEA.
 * User: lucasnascimento
 * Date: 26/06/2016
 * Time: 1:28 PM
 */

require_once ('models/MetaDTODao.php');

class Metas {

    public $meta;

    public function __construct(MetaDTO $meta) {
        $this -> meta = $meta;
    }

    public static function createMeta (MetaDTO $meta) {
        $_metaDAO = new MetaDTODao();
        $_metaDAO->create($meta);
    }

    public static function saveMeta (MetaDTO $meta) {
        $_metaDAO = new MetaDTODao();
        $_metaDAO->save($meta);
    }

    public static function deleteMeta(MetaDTO $meta) {
        $_metaDAO = new MetaDTODao();
        $_metaDAO->delete($meta);
    }

    public static function getObject ($client_id) {
        $_metaDAO = new MetaDTODao();
        return $_metaDAO->loadAllMetas($client_id);
    }



}