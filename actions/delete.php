<?php
require_once 'conn.php';


class delete extends dbconn{
  public function deleteReminder(){
    $this->id = isset($_POST['deleteForm']) ? $_POST['deleteForm'] : '';
    $this->fileNameToDelete = $_POST['fileNameToDelete'];

    try {
        $sql = "DELETE FROM reminders WHERE id =:id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        $selectSql = 'SELECT fileName1 FROM filenames WHERE id=:fileNameID';
        $stmtGetFileId = $this->connect()->prepare($selectSql);
        $stmtGetFileId->bindParam('fileNameID', $this->fileNameToDelete);
        $stmtGetFileId->execute();
        $results = $stmtGetFileId->fetchAll(PDO::FETCH_ASSOC);
        foreach($results as $row){
          $fileToDelete = 'actions/filesUploaded/'.$row['fileName1'];
          unlink($fileToDelete);
        }

        $sqlDeleteFileName = 'DELETE FROM filenames WHERE id =:fileID';
        $stmtFileName = $this->connect()->prepare($sqlDeleteFileName);
        $stmtFileName->bindParam('fileID', $this->fileNameToDelete);
        $stmtFileName->execute();



        }
    catch(PDOException $e)
        {
        echo $sql . "<br>" . $e->getMessage();
        }
  }
}


 ?>
