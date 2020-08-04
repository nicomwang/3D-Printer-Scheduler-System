<?php
include('includes/security.php');
include('includes/header.php');
include('includes/navbar.php');
include('includes/scripts.php');
?>

<!-- Scheduler Page Scripts -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-duration-format/2.3.2/moment-duration-format.min.js"></script>

<!-- Fullcalendar CSS -->
<link href='packages/core/main.css' rel='stylesheet' />
<link href='packages/daygrid/main.css' rel='stylesheet' />
<link href='packages/timegrid/main.css' rel='stylesheet' />
<link href='packages-premium/timeline/main.css' rel='stylesheet' />
<link href='packages-premium/resource-timeline/main.css' rel='stylesheet' />

<!-- DateTimePicker CSS -->
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css'>
<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>

<!-- Begin Page Content -->
<div class="container-fluid">

    <div id='calendar'></div>

    <!-- Modal Window: Create Event-->
    <div id="eventModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Create Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" id="eventForm" autocomplete="on">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Event Title</label>
                                <input type="text" name="title" id="title" class="form-control" placeholder="Event Title" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label> Start Time</label>
                                <input type="text" class="form-control datetimepicker-input" id="datetimepicker1" data-toggle="datetimepicker" data-target="#datetimepicker1" name="startTime" />
                            </div>
                            <div class="form-group col-md-4">
                                <label> Duration (hour : minute)</label>
                                <input type="text" class="form-control datetimepicker-input" id="datetimepicker3" data-toggle="datetimepicker" data-target="#datetimepicker3" name="printDuration" />
                                <span class="invalid-feedback" name="validate_duration" id="validate_duration"></span>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Student Email </label>
                                <input type="email" name="studentEmail" id="studentEmail" list="studentEmailList" class="form-control" placeholder="Student Email" required>
                                <datalist id="studentEmailList">
                                    <?php
                                    // Fetch student email from the database 
                                    require_once('database/dbconfig.php');
                                    $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die(mysqli_error($connection));
                                    $query = "SELECT * FROM student";
                                    $result = mysqli_query($connection, $query);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $studentEmail = $row['studentEmail'];
                                        // Show datalist option
                                        echo "<option value='" . $studentEmail . "' ></option>";
                                    }
                                    ?>
                                </datalist>
                            </div>
                            <div class="form-group col-md-4">
                                <label>First Name </label>
                                <input type="text" name="studentFirstName" id="studentFirstName" class="form-control" placeholder="Student First Name" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Last Name </label>
                                <input type="text" name="studentLastName" id="studentLastName" class="form-control" placeholder="Student Last Name" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Object Name </label>
                                <input type="text" name="objectName" id="objectName" class="form-control" placeholder="3D Object Name" list="objectList" required>
                                <datalist id="objectList"></datalist>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Filament Consumed (meter)</label>
                                <input type="text" name="filamentConsumed" id="filamentConsumed" class="form-control" placeholder="Filament Consumed" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Print Reason</label>
                                <select name="printReason" id="printReason" class="form-control" required>
                                    <option value="School Project" selected="selected">School Project</option>
                                    <option value="Personal">Personal </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label> Comment </label>
                            <textarea class="form-control" name="comment" id="comment" placeholder="Comment (Optional)"></textarea>
                        </div>
                        <hr />
                        <div class="form-group">
                            <label> Job Status </label>
                            <select name="jobStatus" id="jobStatus" class="form-control">
                                <option value="Pending" selected="selected">Pending</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Success">Success </option>
                                <option value="Failed">Failed</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label> Status Note </label>
                            <textarea class="form-control" name="statusNote" id="statusNote" placeholder="Success or Failure Note (Optional)"></textarea>
                        </div>
                        <input type="hidden" name="printerId" id="printerId" value="" class="form-control">
                        <input type="hidden" name="appointmentId" id="appointmentId" value="" class="form-control" readonly>
                        <input type="hidden" name="objectId" id="objectId" value="" class="form-control" readonly>
                        <input type="hidden" name="endTime" id="endTime" class="form-control">

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <input type="hidden" name="operation" id="operation" value="">
                            <input type="submit" name="action" id="action" class="btn btn-primary" value="">
                            <button type="button" name="delete_btn_event" id="delete_btn_event" class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<!-- DateTimePicker Plugins -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
<script src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js'></script>

<!-- Fullcalendar plugins -->
<script src='packages/core/main.js'></script>
<script src='packages/interaction/main.js'></script>
<script src='packages/daygrid/main.js'></script>
<script src='packages/timegrid/main.js'></script>
<script src='packages-premium/timeline/main.js'></script>
<script src='packages-premium/resource-common/main.js'></script>
<script src='packages-premium/resource-timeline/main.js'></script>
<script src='packages/bootstrap/main.js'></script>

<!-- Scripts -->
<script src='js/fullcalendar.js'></script>

<?php
include('includes/footer.php');
?>