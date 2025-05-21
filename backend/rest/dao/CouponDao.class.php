<?php

require_once __DIR__ . "/BaseDao.class.php";

class CouponDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct("coupons");
    }

    public function add_coupon($user_id)
    {
        $query = "INSERT INTO coupons (user_id) VALUES (:user_id)";
        $params = [
            "user_id" => $user_id['user_id']
        ];
        return $this->query($query, $params);
    }

    public function get_user_coupons($user_id)
    { 
        return $this->query(
            "SELECT expires_at 
                FROM coupons 
                WHERE user_id = :user_id",
            ["user_id" => $user_id]
        );
    }
}
