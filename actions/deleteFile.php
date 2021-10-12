<?php
require_once 'conn.php';


class DeleteSingleFile extends dbconn{
  public function deleteFile(){

    $this->deleteSingleFileID = $_POST['deleteFileFormID'];
    $this->deleteSingleFileName = $_POST['deleteFileFormName'];

    try {
        $sqlDeleteFile = 'SELECT * FROM filenames WHERE id=:id AND fileName1=:filename';
        $stmt = $this->connect()->prepare($sqlDeleteFile);
        $stmt->bindParam(':id', $this->deleteSingleFileID);
        $stmt->bindParam(':filename', $this->deleteSingleFileName);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($results as $row){
          $fileToDelete = 'actions/filesUploaded/'.$row['fileName1'];
          unlink($fileToDelete);
        }
        $sqlDeleteFileName = 'DELETE FROM filenames WHERE  fileName1=:fileID';
        $stmtFileName = $this->connect()->prepare($sqlDeleteFileName);
        $stmtFileName->bindParam('fileID', $this->deleteSingleFileName);
        $stmtFileName->execute();

        }
    catch(PDOException $e)
        {
        echo $sqlDeleteFile . "<br>" . $e->getMessage();
        }
  }
}

 ?>
