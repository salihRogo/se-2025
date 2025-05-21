<?php
require_once __DIR__ . '/../dao/CouponDao.class.php';
require_once 'BaseService.class.php';

class CouponService extends BaseService
{
    private $couponDao;

    public function __construct()
    {
        $this->couponDao = new CouponDao();
        parent::__construct($this->couponDao);
    }

    public function add_coupon($user_id)
    {
        return $this->couponDao->add_coupon($user_id);
    } 

    public function get_user_coupons($user_id)
    {
        return $this->couponDao->get_user_coupons($user_id);
    }
}
