<?php

require_once __DIR__ . "/BaseDao.class.php";

class FavouritesDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct("favourite_shops");
    }

    public function add_favourites($favourites)
    {
        $query = "SELECT COUNT(*) as cnt FROM favourite_shops WHERE user_id = :user_id AND shop_id = :shop_id";
        $params = [
            "user_id" => $favourites["user_id"],
            "shop_id" => $favourites["shop_id"]
        ];
        $result = $this->query_unique($query, $params);

        if ($result && $result['cnt'] > 0) {
            throw new Exception("Shop is already in your favourites.");
        }

        $query = "INSERT INTO favourite_shops (user_id, shop_id) VALUES (:user_id, :shop_id)";
        return $this->query($query, $params);
    }

    public function get_user_favourites($user_id)
    {
        $query = "SELECT 
                s.name AS shop_name, 
                s.address AS shop_address, 
                s.city AS shop_city, 
                s.image_url AS shop_image, 
                fs.id AS favourite_id
            FROM 
                favourite_shops fs
            JOIN shops s ON fs.shop_id = s.id
            WHERE fs.user_id = :user_id";
        $params = ["user_id" => $user_id];
        return $this->query($query, $params);
    }

    public function delete_favourite($id)
    {
        $query = "DELETE FROM favourite_shops WHERE id = :id";
        $params = ["id" => $id];
        return $this->query($query, $params);
    }
}
