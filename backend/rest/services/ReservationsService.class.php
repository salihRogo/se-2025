<?php

require_once __DIR__ . '/../dao/ReservationsDao.class.php';
require_once 'BaseService.class.php';

class ReservationsService extends BaseService
{
    private $reservationsDao;

    public function __construct()
    {
        $this->reservationsDao = new ReservationsDao();
        parent::__construct($this->reservationsDao);
    }

    public function get_all_reservations()
    {
        return $this->reservationsDao->get_all_reservations();
    }

    public function get_reservation_by_id($id)
    {
        return $this->reservationsDao->get_reservation_by_id($id);
    }

    public function add_reservation($reservations)
    {
        return $this->reservationsDao->add_reservation($reservations);
    }

    public function get_user_reservations($user_id)
    {
        return $this->reservationsDao->get_user_reservations($user_id);
    }

    public function get_shop_reservations($shop_id)
    {
        return $this->reservationsDao->get_shop_reservations($shop_id);
    }

    public function update_reservation_status($id, $status)
    {
        return $this->reservationsDao->update_reservation_status($id, $status);
    }

    public function delete_reservation($id)
    {
        return $this->reservationsDao->delete_reservation($id);
    }

    public function update_reservation($id, $fields)
    {
        return $this->reservationsDao->update_reservation($id, $fields);
    }
}
