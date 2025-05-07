<?php

use Symfony\Component\Yaml\Yaml;

require_once __DIR__ . '/../dao/ShopsDao.class.php';
require_once 'BaseService.class.php';

class ShopsService extends BaseService
{
    private $shopsDao;

    public function __construct()
    {
        $this->shopsDao = new ShopsDao();
        parent::__construct($this->shopsDao);
    }

    public function get_all_shops()
    {
        return $this->shopsDao->get_all_shops();
    }

    public function get_shop_by_id($id)
    {
        return $this->shopsDao->get_shop_by_id($id);
    }

    public function add_shop($shops)
    {
        return $this->shopsDao->add_shop($shops);
    }

    public function delete_shop($id)
    {
        return $this->shopsDao->delete_shop($id);
    }

    public function update_shop($id, $shops)
    {
        return $this->shopsDao->update_shop($id, $shops);
    }
}
