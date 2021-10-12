<?php
include('auth/config.php');
include('auth/session.php');
$userDetails=$userClass->userDetails($session_uid);

include_once 'conn.php';


  class addReminder extends dbconn {
    public function addNewReminder(){

           $this->exdate = $_POST['exdate'];
           $this->name = $_POST['name'];
           $this->category = $_POST['category'];
           $this->location = $_POST['location'];
           $this->notes = $_POST['notes'];



           try {
                     if(isset($_POST['submit'])){
                        $sqlFile = 'INSERT INTO filenames (id,fileName1) VALUES (:fileID,:fileName);';
                        $stmtFile = $this->connect()->prepare($sqlFile);
                        $this->fileID = md5(uniqid());
                       $total = count($_FILES['fileUpload']['tmp_name']);
                       for($i=0;$i<$total;$i++){
                         $fileName = $_FILES['fileUpload']['name'][$i];
                         $fileDest = 'filesUploaded/'.$fileName;
                             move_uploaded_file($_FILES['fileUpload']['tmp_name'][$i], $fileDest);
                             $stmtFile->bindParam(':fileID', $this->fileID);
                             $stmtFile->bindParam(':fileName', $fileName);
                             $stmtFile->execute();

                       }
                       $sql = "INSERT INTO reminders (exdate, name, category, location, fileNameID, notes) VALUES (:exdate,:name,:category,:location, :fileNameID, :notes)";
                       $stmt = $this->connect()->prepare($sql);
                       $stmt->bindParam(':exdate', $this->exdate);
                       $stmt->bindParam(':name', $this->name);
                       $stmt->bindParam(':category', $this->category);
                       $stmt->bindParam(':location', $this->location);
                       $stmt->bindParam(':fileNameID', $this->fileID);
                       $stmt->bindParam(':notes', $this->notes);
                       $stmt->execute();
                     }

           }catch(PDOException $e){
             echo $e->getMessage();
           }
      }
    }
?>
  <!DOCTYPE html>
  <html lang="en" dir="ltr">
    <head>
      <meta charset="utf-8">
      <title>Insert A Reminder</title>
      <link rel="icon" href="../favicon.png" type="image/png" sizes="16x16">
      <link rel="stylesheet" href="../css/master.css">
      <script src="https://kit.fontawesome.com/7163735c82.js" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
      <nav class="nav bg-light mb-4 justify-content-between">
        <div class="navbar-brand text-danger ml-4"><h4><i class="fas fa-asterisk"></i>  Expiration Reminder</h4></div>
          <h4 class="navbar-brand text-muted">Welcome <?php echo $userDetails->name; ?></h4>
          <a href="<?php echo BASE_URL; ?>actions/auth/logout.php"><button class="btn btn-danger btn-sm mt-2 mr-2"><i class="fas fa-sign-out-alt"></i> Logout</button></a>
        </nav>
      <div class="container form-div">
          <div class="mb-1"><p> Today: <?php date_default_timezone_set("America/New_York"); echo date('M d, Y'); ?></p></div>
          <div class="container">
            <?php
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
              $errMessage = '';
                if(empty($_POST['name']) && $_POST['category'] == 'Pick A Category'){
                  echo $errMessage = '<p class="text-danger">Please Enter a Name and Select a Category.</p>';
                }
                else if(empty($_POST['name'])){
                  echo $errMessage = '<p class="text-danger">Please Enter a Name.</p>';
                }
                else if($_POST['category'] == 'Pick A Category'){
                  echo $errMessage = '<p class="text-danger">Please Select a Category.</p>';
                }else if(!empty($_POST['name']) && $_POST['category'] !== 'Pick A Category'){
                  $addReminder = new addReminder();
                  $addReminder->addNewReminder();
                  echo $errMessage = '<p class="text-danger">Reminder Successfully Added</p>';
                }
              }
             ?>
          </div>
          <form id="mainform" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
            <div class="form-row">
              <div class="col">
            <div class="form-group">
              <label for="date">Date of Expiration</label>
              <input class="form-control form-control-lg" type="date" id="exdate" name="exdate" >
            </div>
          </div>
        </div>

              <div class="form-row">
              <div class="col">
              <label for="name">Name of Contract</label>
              <input class="form-control" type="text" id="name" name="name" placeholder="Enter A Name" >
              <input type="hidden" name="addForm">
            </div>
            <div class="col">
              <label for="category">Pick A Category</label>
            <select class="form-control" id="category" name="category" >
              <option>Pick A Category</option>
              <option>Hardware</option>
              <option>Software</option>
              <option>Telco</option>
              <option>Generic</option>
              <option>Service Contract</option>
              <option>Misc</option>
            </select>
            </div>
          </div><!--End of 1rst main form row -->

            <label for="location">Location</label>
            <div class="form-check pl-2 pt-1">
              <input type="radio" name="location" id="location" value="DOC" checked>
              <label for="location">
                DOC
              </label><br>
              <input  type="radio" name="location" id="location" value="CCHS">
              <label  for="location">
                CCHS
              </label>
            <div class="form-group">
              <label>Upload A File</label>
              <input class="form-control-file" type="file" name="fileUpload[]" multiple>
            </div>
            <div class="form-row">
              <div class="col">
            <div class="form-group">
              <label for="notes">Notes</label><br>
              <textarea class="form-control" name="notes" rows="4" ></textarea>
            </div>
          </div>
          </div>
            <button class="btn btn-danger btn-lg mt-3 mr-4 mb-4" type="submit" name="submit"><i class="fas fa-plus"></i>  Add Reminder</button>
          </form><br>

      </div>
        <a href="<?php echo BASE_URL; ?>home.php"><button class="btn btn-success btn-md mt-3">View Your Reminders</button></a>
      <?php include '../footer.php';?>
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
  </html>
