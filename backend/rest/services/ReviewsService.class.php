<?php

use Symfony\Component\Yaml\Yaml;

require_once __DIR__ . '/../dao/ReviewsDao.class.php';
require_once 'BaseService.class.php';

class ReviewsService extends BaseService
{
    private $reviewsDao;

    public function __construct()
    {
        $this->reviewsDao = new ReviewsDao();
        parent::__construct($this->reviewsDao);
    }

    public function add_review($review)
    {
        return $this->reviewsDao->add_review($review);
    }

    public function get_all_reviews()
    {
        return $this->reviewsDao->get_all_reviews();
    }

    public function get_user_reviews($user_id)
    {
        return $this->reviewsDao->get_user_reviews($user_id);
    }

    public function get_shop_reviews($shop_id)
    {
        return $this->reviewsDao->get_shop_reviews($shop_id);
    }

    public function delete_review($id)
    {
        return $this->reviewsDao->delete_review($id);
    }
}
