<?php

class PettyCash{

    use Model;

    public function find()
    {
        $query="select payment_id,DATE_FORMAT(timestamp, '%Y-%m-%d') AS dateOnly, category, description, amount from pettycash ORDER BY timestamp DESC";
        $result=$this->findAll($query);

        if ($result->num_rows > 0) {
            return $result;
        } else {
            echo "0 results";
        }   
    }

    public function addRecord($category, $description, $amount)
    {        
        $author='payment_clark';
        $timestamp = date('Y-m-d H:i:s');
        $sql="INSERT INTO pettycash (payment_id, author, timestamp, category, description, amount) VALUES (NULL, '$author', '$timestamp', '$category', '$description', '$amount')";

        return $this->insert($sql);
    }

    public function deleteRecord($payment_id)
    {
        $query = "DELETE FROM pettycash WHERE payment_id = $payment_id";

        return $this->delete($query);
    }

    public function updateRecord($payment_id,$timestamp, $category, $description, $amount)
    {
        $timestamp = date('Y-m-d H:i:s'); 
        $sql = "UPDATE pettycash SET timestamp = '$timestamp' , category = '$category', description='$description', amount = '$amount' WHERE pettycash.payment_id = '$payment_id'";
        return $this->delete($sql);
    }

   

  






}