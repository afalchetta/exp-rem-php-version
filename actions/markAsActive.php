<?php

class markas extends dbconn{

  public function markAsReminder(){
    $this->id = $_POST['markAsActive'];

    try {
      $sql = "UPDATE reminders SET isCurrent =0 WHERE id=:id";
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
