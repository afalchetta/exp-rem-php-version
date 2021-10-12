<?php

require_once 'conn.php';


class Reminders extends dbconn{

  public function getAllReminders(){
    $status = 0;
    $stmt = $this->connect()->prepare("SELECT * FROM reminders WHERE isCurrent = :status  ORDER BY exdate ASC");
    $stmt->bindParam(':status', $status);
    $stmt->execute();
    return $stmt->fetchAll();
  }
  public function getRemindersByCategory(){
    $this->category = $_POST['categorySelected'];
    $status = 0;
    $sql = 'SELECT * FROM reminders WHERE category=:categorySelected AND isCurrent=:status ORDER BY exdate ASC';
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':categorySelected', $this->category);
    $stmt->bindParam(':status', $status);
    $stmt->execute();
    return $stmt->fetchAll();
  }
  public function getRemindersByLocation(){
    $this->location = $_POST['location'];
    $status = 0;
    $sql = 'SELECT * FROM reminders WHERE location=:locationSelected AND isCurrent=:status ORDER BY exdate ASC';
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':locationSelected', $this->location);
    $stmt->bindParam(':status', $status);
    $stmt->execute();
    return $stmt->fetchAll();
  }
  public function getRemindersByName(){
    $this->name = $_POST['nameSearch'];
    $this->searchTerm = '%'.$this->name.'%';
    $status = 0;
    $sql = 'SELECT * FROM reminders WHERE name LIKE :nameSearch AND isCurrent=:status ORDER BY exdate ASC';
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':nameSearch', $this->searchTerm);
    $stmt->bindParam(':status', $status);
    $stmt->execute();
    return $stmt->fetchAll();
  }
}

?>
