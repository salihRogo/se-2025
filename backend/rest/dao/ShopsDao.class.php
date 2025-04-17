<?php

require_once __DIR__ . '/BaseDao.class.php';

class ShopsDao extends BaseDao {
    public function __construct() 
    {
        parent::__construct("shops");
    }

    public function get_all_shops()
    {
        return $this->get_all();
    }
}