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
        $query = "SELECT s.*, si.image_url
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
        $query = "SELECT s.id, s.name, s.address, s.city, si.image_url
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

    public function get_shop_by_id($shop_id)
    {
        $query = "SELECT s.*, si.image_url
                    FROM shops s
                    LEFT JOIN shop_images si ON s.id = si.shop_id
                    WHERE s.id = :shop_id
                ";
        $params = ["shop_id" => $shop_id];
        return $this->query($query, $params);
    }

    public function add_shop($shop)
    {
        // 1. Insert shop into shops table
        $query = "INSERT INTO shops 
        (name, address, city, contact_number, opens_at, closes_at, description)
        VALUES
        (:name, :address, :city, :contact_number, :opens_at, :closes_at, :description)";

        $params = [
            'name' => $shop['name'],
            'address' => $shop['address'],
            'city' => $shop['city'],
            'contact_number' => $shop['contact_number'],
            'opens_at' => $shop['opens_at'],
            'closes_at' => $shop['closes_at'],
            'description' => $shop['description']
        ];

        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);

        $shop_id = $this->connection->lastInsertId();
        $image_url=$shop["image_url"];

        // 2. If image_url is provided, insert into shop_images table
        if ($image_url) {
            $img_query = "INSERT INTO shop_images (shop_id, image_url) VALUES (:shop_id, :image_url)";
            $img_params = [
                'shop_id' => $shop_id,
                'image_url' => $image_url
            ];
            $img_stmt = $this->connection->prepare($img_query);
            $img_stmt->execute($img_params);
        }

        return $shop_id;
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
