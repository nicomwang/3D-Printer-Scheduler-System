<?php
include('includes/security.php');
include('includes/header.php');
include('includes/navbar.php');
include('includes/scripts.php');
?>


<!-- Custom styles - DataTable -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" />

<!-- Datatable plugins -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- 3D Printer Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">3D Printer </br></br>
                <button type="button" class="btn btn-primary" name="add_button" id="add_button" data-toggle="modal" data-target="#printerModal">
                    Add New 3D Printer
                </button>
            </h4>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <div id="printer_table">
                    <table id="printerTable" class="table table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Printer</th>
                                <th>Status</th>
                                <th>Admin Note</th>
                                <th>View</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Printer</th>
                                <th>Status</th>
                                <th>Admin Note</th>
                                <th>View</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Window: Add/Edit Printer-->
    <div id="printerModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="printerModalLabel">Add Printer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="printerForm">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label> 3D Printer Name </label>
                                <input type="text" name="printerName" id="printerName" class="form-control" placeholder="Enter Printer Name" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Printer Status</label>
                                <select name="printerStatus" id="printerStatus" class="form-control" required>
                                    <option selected value="Available">Available</option>
                                    <option value="Unavailable">Unavailable</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Event Color</label>
                                <select name="eventColor" id="eventColor" class="form-control" required>
                                    <option value="">Please Select</option>
                                    <option value="#FFC0CB">Red</option>
                                    <option value="#FFD699">Orange</option>
                                    <option value="#FFF2CC">Yellow</option>
                                    <option value="#C2F0C2">Green</option>
                                    <option value="#CCE6FF">Blue</option>
                                    <option value="#CCCCFF">Purple</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                        <div class="form-group col-md-4">
                                <label> Build Volume (mm)</label>
                                <input type="text" name="buildVolume" id="buildVolume" class="form-control" placeholder="e.g. '305 x 305 x 605' " required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Extruder</label>
                                <select name="extruder" id="extruder" class="form-control" required>
                                    <option value="">Please Select</option>
                                    <option value="Single">Single</option>
                                    <option value="Double">Double</option>
                                    <option value="Triple">Triple</option>
                                    <option value="Quad">Quad</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Print Surface</label>
                                <select name="printSurface" id="printSurface" class="form-control" required>
                                    <option value="">Please Select</option>
                                    <option value="Heated">Heated</option>
                                    <option value="Unheated">Unheated</option>
                                </select>
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Public Note (optional)</label>
                                <textarea class="form-control" name="publicNote" id="publicNote"></textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Admin Note (optional)</label>
                                <textarea class="form-control" name="adminNote" id="adminNote"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Filament Material</label></br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="filamentType[]" value="ABS">
                                <label class="form-check-label" for="inlineCheckbox1">ABS</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="filamentType[]" value="PLA">
                                <label class="form-check-label" for="inlineCheckbox2">PLA</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="filamentType[]" value="HIPS">
                                <label class="form-check-label" for="inlineCheckbox1">HIPS</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="filamentType[]" value="PVA">
                                <label class="form-check-label" for="inlineCheckbox2">PVA</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="filamentType[]" value="Wood Filled">
                                <label class="form-check-label" for="inlineCheckbox1">Wood Filled</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="filamentType[]" value="Polyester (Tritan)">
                                <label class="form-check-label" for="inlineCheckbox2">Polyester (Tritan)</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="filamentType[]" value="PETT">
                                <label class="form-check-label" for="inlineCheckbox1">PETT</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="filamentType[]" value="Polycarbonate">
                                <label class="form-check-label" for="inlineCheckbox1">Polycarbonate</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="filamentType[]" value="Bronze/Copper Filled">
                                <label class="form-check-label" for="inlineCheckbox2">Bronze/Copper Filled</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="filamentType[]" value="Nylon">
                                <label class="form-check-label" for="inlineCheckbox2">Nylon</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="filamentType[]" value="PETG">
                                <label class="form-check-label" for="inlineCheckbox1">PETG</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="filamentType[]" value="Other">
                                <label class="form-check-label" for="inlineCheckbox2">Other</label>
                            </div>
                        </div>
                        <div class="form-group" id="filamentSizeList">
                            <label>Filament Size</label></br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="filamentSize[]" value="1.75">
                                <label class="form-check-label" for="inlineCheckbox1">1.75</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="filamentSize[]" value="2.85">
                                <label class="form-check-label" for="inlineCheckbox2">2.85</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="filamentSize[]" value="3.00">
                                <label class="form-check-label" for="inlineCheckbox1">3.00</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="filamentSize[]" value="Other">
                                <label class="form-check-label" for="inlineCheckbox2">Other</label>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <input type="hidden" name="printer_id" id="printer_id" />
                            <input type="hidden" name="operation" id="operation" />
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <input type="submit" name="action" id="action" class="btn btn-primary" value="Add" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Window: View Printer -->
    <div id="printerDataModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">3D Printer Details <h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                </div>
                <div class="modal-body" id="printer_detail">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- End of Page Content -->

<!-- Printer Page Script -->
<script src="js/datatable.js"></script>

<?php
include('includes/footer.php');
?>