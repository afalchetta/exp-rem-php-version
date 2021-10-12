<?php

include_once 'conn.php';

  class Update extends dbconn {
   function updateReminder(){
     $this->id = $_POST["updateId"];
     $this->fileNameId = $_POST["fileNameId"];
     $this->newDate = $_POST['newDate'];
     $newNotes = $_POST['addNotes'];

     $currentNotes = $_POST['currNotes'];
     $today = date('M d, Y');
     $this->totalNotes = $currentNotes . ' <strong>Added: ' . $today . '</strong>' . $newNotes;

     try {
               if(isset($_POST['submit'])){
                  $sqlFile = 'INSERT INTO filenames (id,fileName1) VALUES (:fileID,:fileName);';
                  $stmtFile = $this->connect()->prepare($sqlFile);
                 $total = count($_FILES['addFile']['tmp_name']);
                 for($i=0;$i<$total;$i++){
                   $fileName = $_FILES['addFile']['name'][$i];
                   $fileDest = 'actions/filesUploaded/'.$fileName;
                      if(!empty($fileName)){
                        move_uploaded_file($_FILES['addFile']['tmp_name'][$i], $fileDest);
                        $stmtFile->bindParam(':fileID', $this->fileNameId);
                        $stmtFile->bindParam(':fileName', $fileName);
                        $stmtFile->execute();
                      }

                 }
                 $sql = "UPDATE reminders SET exdate=:newDate,notes=:newNotes WHERE id=:id";
                 $stmt = $this->connect()->prepare($sql);
                 $stmt->bindParam(':id', $this->id);
                 $stmt->bindParam(':newDate', $this->newDate);
                 $stmt->bindParam(':newNotes', $this->totalNotes);
                 $stmt->execute();
               }

     }catch(PDOException $e){
       echo $e->getMessage();
     }
      }
    }
?>
