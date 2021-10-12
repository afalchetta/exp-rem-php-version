<?php

class change extends dbconn{

  public function changeReminder(){
    $this->id = $_POST['markAs'];

    try {
      $sql = "UPDATE reminders SET isCurrent =1 WHERE id=:id";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':id', $this->id);
      $stmt->execute();
      header("location: home.php");
      echo $sql;
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
}
 ?>
