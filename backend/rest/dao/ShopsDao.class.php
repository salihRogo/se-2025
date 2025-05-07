<?php

require_once __DIR__ . '/BaseDao.class.php';

class ShopsDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct("shops");
    }

    public function get_all_shops()
    {
        return $this->get_all();
    }

    public function get_shop_by_id($id)
    {
        return $this->get_by_id($id);
    }

    public function add_shop($shops)
    {
        return $this->add($shops);
    }

    public function delete_shop($id)
    {
        return $this->delete($id);
    }

    public function update_shop($id, $shops)
    {
        return $this->update($shops, $id, "id");
    }
}
