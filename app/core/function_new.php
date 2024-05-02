public function findAll($query){
return $this->query($query);
}

public function insert($){
        $this->query($query);
        return false;
    }

public function update($id, $data, $id_column = 'id'){
    $this->query($query);
    return false;   
}

public function delete($id, $id_column = 'id'){
$this->query($query);
return false;
}




