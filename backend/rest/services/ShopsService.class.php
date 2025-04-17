<?php

require_once __DIR__ . '/../dao/ShopsDao.class.php';
require_once 'BaseService.class.php';

class ShopsService extends BaseService
{
    private $shopsDao;

    public function __construct()
    {
        $this -> shopsDao = new ShopsDao();
        parent::__construct($this -> shopsDao);
    }

    public function get_all_shops()
    {
        return $this -> shopsDao -> get_all_shops();
    }
}