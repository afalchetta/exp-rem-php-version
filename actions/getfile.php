<?php
require_once 'conn.php';


class GetFile extends dbconn {

  public function getTheFile(){
      $this->fileId = $_POST['fileId'];
    try {

      $sql = "SELECT * FROM reminders WHERE id=:fileId";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':fileId',$this->fileId);
      $stmt->execute();
      $results = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->fileName = $results['fileNameID'];


      $getFiles = 'SELECT fileName1 FROM filenames WHERE id=:fileName';
      $stmt2 = $this->connect()->prepare($getFiles);
      $stmt2->bindParam(':fileName', $this->fileName);
      $stmt2->execute();
      $filesResult = $stmt2->fetchAll(PDO::FETCH_ASSOC);
      return $filesResult;

    } catch (PDOException $e) {
    }
  }

  public function nameForFiles(){
    $this->id = $_POST['fileId'];
    $sqlName = "SELECT name, location FROM reminders WHERE id=:id";
    $stmt3 = $this->connect()->prepare($sqlName);
    $stmt3->bindParam(':id',$this->id);
    $stmt3->execute();
    $name = $stmt3->fetch(PDO::FETCH_ASSOC);
    return $name;
  }

}
?>
