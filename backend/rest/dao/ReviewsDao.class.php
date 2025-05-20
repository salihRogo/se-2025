<?php

require_once __DIR__ . '/BaseDao.class.php';

class ReviewsDao extends BaseDao
{

    public function __construct()
    {
        parent::__construct("reviews");
    }

    public function add_review($reviews)
    {
        $query = "INSERT INTO reviews (shop_id, user_id, comment) 
              VALUES (:shop_id, :user_id, :comment)";

        $params = [
            "shop_id" => $reviews["shop_id"],
            "user_id" => $reviews["user_id"],
            "comment" => $reviews["comment"]
        ];

        return $this->query($query, $params);
    }

    public function get_all_reviews()
    {
        return $this->get_all();
    }


    public function get_user_reviews($user_id)
    {
        $params = ["user_id" => $user_id];
        $query = "SELECT * FROM reviews where user_id= :user_id";
        return $this->query($query, $params);
    }

    public function get_shop_reviews($shop_id)
    {
        $params = ["shop_id" => $shop_id];
        $query = "SELECT r.comment, u.full_name, r.id, r.shop_id
              FROM reviews r
              JOIN users u ON r.user_id = u.id
              WHERE r.shop_id = :shop_id";

        return $this->query($query, $params);
    }

    public function delete_review($id)
    {
        return $this->delete($id);
    }
}
