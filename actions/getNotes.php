<?php

require_once 'conn.php';


class GetNotes extends dbconn{

  public function getNotes(){
    $this->id = $_POST['getNotes'];
      try {
        $noteSql = "SELECT notes FROM reminders WHERE id=:id";
        $stmt = $this->connect()->prepare($noteSql);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        $note =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $note;
      } catch (PDOException $e) {
      }
  }
  public function nameForNotes(){
    $this->idN = $_POST['getNotes'];
    $sqlNotes = "SELECT name, location FROM reminders WHERE id=:id";
    $stmt3 = $this->connect()->prepare($sqlNotes);
    $stmt3->bindParam(':id',$this->idN);
    $stmt3->execute();
    $name = $stmt3->fetch(PDO::FETCH_ASSOC);
    return $name;
  }
}
?>
