<?php
include('includes/security.php');
include('includes/header.php');
include('includes/navbar.php');
include('includes/scripts.php');
?>


<div class="container-fluid">

  <!-- Admin Account Table -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h4 class="m-0 font-weight-bold text-primary">Edit Admin Profile </br>
    </div>
    <div class="card-body">

      <?php

      require_once('database/dbconfig.php');
      $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die(mysqli_error($connection));

      $key = "TechnologySandbox";
      if (isset($_POST['edit_btn'])) {
        $id = $_POST['edit_id'];
        $query = "SELECT accountId, adminName, adminEmail, AES_DECRYPT(password, UNHEX(SHA2('$key',512))) as password
                  FROM account WHERE accountId = $id ";
        $result = mysqli_query($connection, $query);
        foreach ($result as $row) {
      ?>

          <form action="process.php" method="POST">
            <div class="modal-body">

              <input type="hidden" name="edit_id" value="<?php echo $row['accountId']; ?>">
              <div class="form-group">
                <label> Name </label>
                <input type="text" name="edit_adminName" class="form-control" value="<?php echo $row['adminName']; ?>" placeholder="Enter Admin Name">
              </div>
              <div class="form-group">
                <label>Email</label>
                <input type="email" name="edit_adminEmail" class="form-control" value="<?php echo $row['adminEmail']; ?>" placeholder="Enter Email">
              </div>
              <div class="form-group">
                <label for="edit_password">Password</label>
                <input type="password" id="edit_password" name="edit_password" class="form-control" value="<?php echo $row['password']; ?>" placeholder="Enter Password" required>
                <span class="invalid-feedback" name="validate_password_old" id="validate_password_old"></span>
              </div>
              <div id="changePassword">
                <div class="form-group">
                  <label>New Password</label>
                  <input type="password" name="password_new" id="password_new" class="form-control" placeholder="Enter Password">
                  <span class="invalid-feedback" name="validate_password_new" id="validate_password_new"></span>
                </div>
                <div class="form-group">
                  <label>Confirm New Password</label>
                  <input type="password" name="password_confirmed_new" id="password_confirmed_new" class="form-control" placeholder="Confirm Password">
                  <span class="invalid-feedback" name="validate_password_confirmed_new" id="validate_password_confirmed_new"></span>
                </div>
              </div>
            </div>
            
            <div class="modal-footer">
              <a href="account.php" class=" btn btn-secondary">Cancel </a>
              <button type="submit" id="submit" name="update_btn" class="btn btn-primary">Update</button>
            </div>
          </form>

      <?php
        }
      }
      ?>

    </div>
  </div>

</div>
<!-- /.container-fluid -->


<!-- Scripts -->
<script src='js/account.js'></script>

<?php
include('includes/footer.php');
?>