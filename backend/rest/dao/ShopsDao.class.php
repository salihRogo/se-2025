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
        $query = "SELECT *
                    FROM shops s";
        $params = [];
        return $this->query($query, $params);
    }

    public function get_shops_for_home()
    {
        $query = "SELECT s.id, s.name, s.address, s.city, s.image_url
                FROM shops s
                JOIN (
                    SELECT city, MIN(id) AS min_id
                    FROM shops
                    WHERE city IN ('Sarajevo', 'Mostar', 'Banja Luka')
                    GROUP BY city
                ) sub ON s.id = sub.min_id";
        $params = [];
        return $this->query($query, $params);
    }

    public function get_shop_by_id($shop_id)
    {
        $query = "SELECT * FROM shops WHERE id = :shop_id";
        $params = ["shop_id" => $shop_id];
        return $this->query($query, $params);
    }

    public function add_shop($shop)
    {
        // Insert shop into shops table, now including image_url directly
        $query = "INSERT INTO shops 
        (name, address, city, contact_number, opens_at, closes_at, description, image_url)
        VALUES
        (:name, :address, :city, :contact_number, :opens_at, :closes_at, :description, :image_url)";

        $params = [
            'name' => $shop['name'],
            'address' => $shop['address'],
            'city' => $shop['city'],
            'contact_number' => $shop['contact_number'],
            'opens_at' => $shop['opens_at'],
            'closes_at' => $shop['closes_at'],
            'description' => $shop['description'],
            'image_url' => isset($shop['image_url']) ? $shop['image_url'] : null
        ];

        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);

        return $this->connection->lastInsertId();
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
