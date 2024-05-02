<?php

require_once 'ConnectDB.php';

class Contact extends ConnectDB {

	/*public function getAllContacts() {
		return $this->conn->query("SELECT * FROM contacts")->fetchAll();
	}*/

	public function search($id) {
		$q = $this->conn->prepare("SELECT * FROM player_details WHERE player_id=?");
		$q->execute( array($id) );
		return $q->fetch();
		
	}
	
	public function add($post)
	{
		$q = $this->conn->prepare("INSERT INTO player_details (player_id, pname, address, batting, bowling, fielding, fitness, date) VALUES (?,?,?,?,?,?,?,?)");
		$q->execute( array($post['id'],$post['pname'],$post['address'],$post['batting'],$post['bowling'],$post['fielding'],$post['fitness'],$post['date']) );
		return $q->rowCount();
	}

	public function edit($post)
	{
		$q = $this->conn->prepare("UPDATE player_details SET pname=?, address=?, batting=?, bowling=?, fielding=?, fitness=?, date=? WHERE player_id=?");
		$q->execute( array( $post['pname'],$post['address'],$post['batting'],$post['bowling'],$post['fielding'],$post['fitness'],$post['date'] ,$post['id']));
		return $q->rowCount();
	}

	public function delete($id)
	{
		$q = $this->conn->prepare("DELETE FROM player_details WHERE player_id = ?");
		$q->execute( array($id) );
		return $q->rowCount();
	}
}