<?php

require_once 'conn.php';


class inactiveReminders extends dbconn{

  public function getAllInactiveReminders(){
    $status = 1;
    $stmt = $this->connect()->prepare("SELECT * FROM reminders WHERE isCurrent = :status  ORDER BY exdate ASC");
    $stmt->bindParam(':status', $status);
    $stmt->execute();
    return $stmt->fetchAll();
  }
}

?>
