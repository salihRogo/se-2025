<?php
require_once __DIR__ . '/../dao/FavouritesDao.class.php';
require_once 'BaseService.class.php';

class FavouritesService extends BaseService
{
    private $favouritesDao;

    public function __construct()
    {
        $this->favouritesDao = new FavouritesDao();
        parent::__construct($this->favouritesDao);
    }

    public function add_favourites($favourites)
    {
        return $this->favouritesDao->add_favourites($favourites);
    }

    public function get_user_favourites($user_id)
    {
        return $this->favouritesDao->get_user_favourites($user_id);
    }

    public function delete_favourite($id)
    {
        return $this->favouritesDao->delete_favourite($id);
    }
}
