<?php
class coach_update_slots{
    use Model;
    public function insert_slots($date,$slot_id){

        
        
        $sql = "INSERT INTO bookings (booking_id, name, id_number, contact_number, slot_id, net_id, coach_id, date, member_ID) VALUES (NULL, 'coach', '201', '11', '5', '2', '5', '2024-04-09', NULL)";
        $this->insert($sql);

    }
}