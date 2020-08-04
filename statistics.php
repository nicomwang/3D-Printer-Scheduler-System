<?php
include('includes/security.php');
include('includes/header.php');
include('includes/navbar.php');
include('includes/scripts.php');

// Connect to datatbase 
require_once('database/dbconfig.php');
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die(mysqli_error($connection));

?>

<!-- plotly.js -->
<script src="https://cdn.plot.ly/plotly-latest.min.js" charset="utf-8"></script>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Content Row : Top 4 cards-->
    <div class="row">

        <!-- Total Printers -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"> Total Printers</div>
                            <?php
                            $query = " SELECT printerId FROM printer WHERE isDeleted='0' ORDER BY printerId";
                            $result = mysqli_query($connection, $query);
                            $row = mysqli_num_rows($result);
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">' . $row . '</div>'
                            ?>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-print fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Admin Accounts -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1"> Total Admin Accounts</div>
                            <?php
                            $query = " SELECT accountId FROM account ORDER BY accountId";
                            $result = mysqli_query($connection, $query);
                            $row = mysqli_num_rows($result);
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">' . $row . '</div>'
                            ?>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-cog fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Print Tasks -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pending Print Tasks</div>
                            <?php
                            $query = " SELECT jobStatus FROM appointment WHERE jobStatus='Pending'";
                            $result = mysqli_query($connection, $query);
                            $row = mysqli_num_rows($result);
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">' . $row . '</div>'
                            ?>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- In Progress Print Tasks -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">In Progress Print Tasks</div>
                            <?php
                            $query = " SELECT jobStatus FROM appointment WHERE jobStatus='In Progress'";
                            $result = mysqli_query($connection, $query);
                            $row = mysqli_num_rows($result);
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">' . $row . '</div>'
                            ?>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-spinner fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row: filament consumed card and print reason-->
    <div class="row">

        <!-- Bar Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Total Filament Consumed and Print Tasks</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <form class="px-4 py-2">
                                <div class="form-group">
                                    <label class="dropdown-header">SELECT ACADEMIC YEAR</label>
                                    <select id="yearList_filament" name="yearList_filament" class="form-control"></select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div id='filamentChart'></div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Print Reason</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <form class="px-4 py-2">
                                <div class="form-group">
                                    <label class="dropdown-header">SELECT ACADEMIC YEAR</label>
                                    <select id="yearList_reason" name="yearList_reason" class="form-control"></select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div id="reasonPieChart"></div>
                </div>
            </div>
        </div>

    </div>

    <!-- Content Row: total print time and print result-->
    <div class="row">

        <!-- Bar Chart -->
        <div class="col-xl-8 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Total Print Time</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <form class="px-4 py-2">
                                <div class="form-group">
                                    <label class="dropdown-header">SELECT ACADEMIC YEAR</label>
                                    <select id="yearList_printTime" name="yearList_printTime" class="form-control"></select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div id='printTimeChart'></div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Print Result</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <form class="px-4 py-2">
                                <div class="form-group">
                                    <label class="dropdown-header">SELECT ACADEMIC YEAR</label>
                                    <select id="yearList_result" name="yearList_result" class="form-control"></select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div id="resultPieChart"></div>
                </div>
            </div>
        </div>

    </div>

    <!-- Content Row: number of prints -->
    <div class="row">
       
    <!-- Bar Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Number of Prints</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <form class="px-4 py-2">
                                <div class="form-group">
                                    <label class="dropdown-header">SELECT ACADEMIC YEAR</label>
                                    <select id="yearList_printNumber" name="yearList_printNumber" class="form-control"></select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div id="numOfPrintsChart"></div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->


<!--  Scripts -->
<script src="js/plotly.js"> </script>

<?php
include('includes/footer.php');
?>