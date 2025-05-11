<?php

require_once __DIR__ . '/BaseDao.class.php';

class ReservationsDao extends BaseDao 
{
    public function __construct() 
    {
        parent::__construct("reservations");
    }

    public function get_all_reservations()
    {
        return $this->get_all();
    }

    public function get_reservation_by_id($id)
    {
        return $this->get_by_id($id);
    }

    public function add_reservation($reservations)
    {
        $query = 'INSERT INTO reservations (user_id, shop_id, number_of_guests, reservation_time) 
              VALUES (:user_id, :shop_id, :number_of_guests, :reservation_time)';
        $params = [
            "user_id" => $reservations['user_id'],
            "shop_id" => $reservations['shop_id'],
            "number_of_guests" => $reservations['number_of_guests'],
            "reservation_time" => $reservations['reservation_time']
        ];
        return $this->query($query, $params);
    }

    public function get_user_reservations($user_id)
    {
        $query = 'SELECT * FROM reservations WHERE user_id = :user_id';
        $params = ["user_id" => $user_id];
        return $this->query($query, $params);
    }

    public function get_shop_reservations($shop_id)
    {
        $query = 'SELECT * FROM reservations WHERE shop_id = :shop_id';
        $params = ["shop_id" => $shop_id];
        return $this->query($query, $params);
    }

    public function delete_reservation($id)
    {
        return $this->delete($id);
    }

    public function update_reservation($id, $reservations)
    {
        return $this->update($reservations, $id, "id");
    }
}