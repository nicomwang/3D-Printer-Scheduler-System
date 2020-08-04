<?php
include('includes/security.php');
include('includes/header.php');
include('includes/navbar.php');
include('includes/scripts.php');
?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Modal Window for Add -->
  <div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Admin Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form id="accountForm" action="process.php" method="POST">
          <div class="modal-body">
            <div class="form-group">
              <label> Name </label>
              <input type="text" name="adminName" class="form-control" placeholder="Enter Admin Name" required>
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="email" name="adminEmail" id="adminEmail" class="form-control" placeholder="Enter Email" required>
              <span class="invalid-feedback" id="validate_email"></span>
            </div>
            <div class="form-group">
              <label>Password</label>
              <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" required>
            </div>
            <div class="form-group">
              <label>Confirm Password</label>
              <input type="password" name="password_confirmed" id="password_confirmed" class="form-control" placeholder="Confirm Password" required>
              <span class="invalid-feedback" name="validate_password" id="validate_password"></span>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="close_btn_add" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" id="save_btn" name="save_btn" class="btn btn-primary">Save</button>
          </div>
        </form>

      </div>
    </div>
  </div>

  <!-- Admin Account Table -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h4 class="m-0 font-weight-bold text-primary">Admin Profile </br></br>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile">
          Add New Admin Profile
        </button>
        </h6>
    </div>
    <div class="card-body">

      <?php
      if (isset($_SESSION['message'])) : ?>

        <div class="alert alert-<?= $_SESSION['msg_type'] ?>">

          <?php
          echo $_SESSION['message'];
          unset($_SESSION['message']);
          ?>

        </div>
      <?php endif ?>

      <div class="table-responsive">

        <?php
        require_once('database/dbconfig.php');
        $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die(mysqli_error($connection));
        $query = "SELECT * FROM account ";
        $result = mysqli_query($connection, $query);
        ?>

        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>ID </th>
              <th>Admin Name </th>
              <th>Email </th>
              <th>Password</th>
              <th>EDIT </th>
              <th>DELETE </th>
            </tr>
          </thead>
          <tbody>

            <!-- Fetch Data From DB Table 'account'-->
            <?php
            $num_rows = mysqli_num_rows($result);
            if ($num_rows > 0) {
              while ($row = mysqli_fetch_array($result)) {
            ?>
                <tr>
                  <td> <?php echo $row['accountId']; ?> </td>
                  <td> <?php echo $row['adminName']; ?></td>
                  <td> <?php echo $row['adminEmail']; ?></td>
                  <td> ******** </td>
                  <td>
                    <form action="account_edit.php" method="post">
                      <input type="hidden" name="edit_id" value="<?php echo $row['accountId']; ?>">
                      <button type="submit" name="edit_btn" class="btn btn-primary" ata-toggle="modal" data-target="#editadminprofile"> <i class="far fa-edit"></i></button></button>
                    </form>
                  </td>
                  <td>
                    <form action="process.php" method="post">
                      <input type="hidden" name="delete_id" value="<?php echo $row['accountId']; ?>">
                      <button type="submit" name="delete_btn" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this?')"> <i class="far fa-trash-alt"></i></button>
                    </form>
                  </td>
                </tr>
            <?php
              }
            } else {
              echo "No Record Found";
            }
            ?>

          </tbody>
        </table>

      </div>
    </div>
  </div>

</div>
<!-- End of Page Content -->


<!-- Scripts -->
<script src='js/account.js'></script>

<?php
include('includes/footer.php');
?>