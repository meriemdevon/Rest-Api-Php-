<?php
class ToDo{

    private $conn;
    private $table_name = "todo";
    public $idTodo;
    public $task;
    public $dateTask;
    public $idUser;
    public $userName;



    public function __construct($db){
        $this->conn = $db;
    }
    public function create(){
    $query = "INSERT INTO " . $this->table_name . "
         SET
        task = :task,
        dateTask = :dateTask,
        idUser = :idUser";

    $stmt = $this->conn->prepare($query);


    $this->task=htmlspecialchars(strip_tags($this->task));
    $this->dateTask=htmlspecialchars(strip_tags($this->dateTask));
    $this->idUser=htmlspecialchars(strip_tags($this->idUser));


    $stmt->bindParam(':task', $this->task);
    $stmt->bindParam(':dateTask', $this->dateTask);
    $stmt->bindParam(':idUser', $this->idUser);



    if($stmt->execute()){
        return true;
    }
 
    return false;
}

public function update(){


    $query = "UPDATE " . $this->table_name . "
            SET
              
                task = :task,
                dateTask = :dateTask,
                idUser = :idUser
            WHERE idTodo = :idTodo";


    $stmt = $this->conn->prepare($query);
 
    $this->task=htmlspecialchars(strip_tags($this->task));
    $this->dateTask=htmlspecialchars(strip_tags($this->dateTask));
    $this->idUser=htmlspecialchars(strip_tags($this->idUser));
    $this->idTodo=htmlspecialchars(strip_tags($this->idTodo));

 
    $stmt->bindParam(':task', $this->task);
    $stmt->bindParam(':dateTask', $this->dateTask);
  
   $stmt->bindParam(':idUser', $this->idUser);
   $stmt->bindParam(':idTodo', $this->idTodo);

   if($stmt->execute()){
       return true;
   }

   return false;
}


// read products
function read(){
 
    // select all query
    $query = "SELECT
                u.firstname as userName, t.idTodo, t.task, t.dateTask, t.idUser, t.created
            FROM
                " . $this->table_name . " t
                LEFT JOIN
                    users u
                        ON t.idUser = u.idUser
            ORDER BY
                t.created DESC";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}
 

function delete(){
 

    $query = "DELETE FROM " . $this->table_name . " WHERE idTodo = ?";
 

    $stmt = $this->conn->prepare($query);
 
    
    $this->idTodo=htmlspecialchars(strip_tags($this->idTodo));
 

    $stmt->bindParam(1, $this->idTodo);
 

    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}




 
}


?>