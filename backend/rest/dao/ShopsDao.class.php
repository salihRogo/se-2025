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
        $query = "SELECT s.name, s.address, s.city, si.image_url
                    FROM shops s
                    LEFT JOIN (
                        SELECT shop_id, MIN(image_url) AS image_url
                        FROM shop_images
                        GROUP BY shop_id
                    ) si ON s.id = si.shop_id;
        ";
        $params = [];
        return $this->query($query, $params);
    }

    public function get_shops_for_home()
    {
        $query = "SELECT s.name, s.address, s.city, si.image_url
                    FROM shops s
                    JOIN (
                        SELECT city, MIN(id) AS min_id
                        FROM shops
                        WHERE city IN ('Sarajevo', 'Mostar', 'Banja Luka')
                        GROUP BY city
                    ) sub ON s.id = sub.min_id
                    LEFT JOIN (
                    SELECT shop_id, MIN(image_url) AS image_url
                    FROM shop_images
                    GROUP BY shop_id
                    ) si ON s.id = si.shop_id;
                ";
        $params = [];
        return $this->query($query, $params);
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
