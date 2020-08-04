$(document).ready(function () {

	// [PRINTER DATATABLE]
	var dataTable = $('#printerTable').DataTable({
		"processing": true,
		"serverSide": true,
		"ajax": {
			url: "printer_datatable.php",
			type: "post"
		},
		"columnDefs": [{
			//remove order option for column view, edit and delete 
			"targets": [4, 5, 6],
			"orderable": false
		}]
	});


	//Add
	$('#add_button').click(function () {
		$('#printerForm')[0].reset();  // reset modal form
		$('#printerModalLabel').text("Add Printer");  // change modal title to add
		$('#action').val("Add");  // change button text to add
		$('#operation').val("Add");
	});


	// [ADD PRINTER]
	$(document).on('submit', '#printerForm', function (event) {

		// restrict page refreshing
		event.preventDefault();

		// checkbox validation
		if ($('input[ name="filamentType[]"]:checked').length == 0) {
			alert('Please select at least one filament type');
			return false;
		} else if ($('input[ name="filamentSize[]"]:checked').length == 0) {
			alert('Please select at least one filament size');
			return false;
		}
		$.ajax({
			url: "printer_insert.php",
			method: 'POST',
			data: new FormData(this),
			contentType: false,
			processData: false,
			success: function (data) {  // call function if request is success
				alert(data);
				$('#printerForm')[0].reset(); // reset form
				$('#printerModal').modal('hide'); // close modal
				dataTable.ajax.reload(); // reload table 
			}
		});
	});


	// [UPDATE PRINTER]
	$(document).on('click', '.update', function () {
		var printer_id = $(this).attr("id");  // get id of selected printer
		$.ajax({
			url: "printer_fetch.php",
			method: "POST",
			data: { printer_id: printer_id },
			dataType: "json",
			success: function (data) {
				$('#printerModal').modal('show'); 
				$('#printerName').val(data.printerName);
				$('#buildVolume').val(data.buildVolume);
				$('#printSurface').val(data.printSurface);
				$('#printerStatus').val(data.printerStatus);
				$('#extruder').val(data.extruder);
				$('#publicNote').val(data.publicNote);
				$('#adminNote').val(data.adminNote);
				$('#eventColor').val(data.eventColor);

				// set checkboxes as checked if they were previous selected by user
				var filamentSizeString = data.filamentSize;    // data.filamentSize (String): "1.75, 2.85, 3.00, Other"
				var filamentSizeArray = filamentSizeString.split(', ');   // convert String to Array, seperate by comma and remove space ["1.75", "2.85", "3.00" ,"Other"];
				$(':checkbox[name="filamentSize[]"]').each(function () {	// look though each checkbox
					$(this).prop("checked", ($.inArray($(this).val(), filamentSizeArray) != -1));  // check checkbox if in array 
				});

				var filamentTypeString = data.filamentType;
				var filamentTypeArray = filamentTypeString.split(', ');
				$('#printerForm').find(':checkbox[name="filamentType[]"]').each(function () {
					$(this).prop("checked", ($.inArray($(this).val(), filamentTypeArray) != -1));
				});

				$('#printerModalLabel').text("Update Printer");
				$('#printer_id').val(printer_id);
				$('#action').val("Update");
				$('#operation').val("Update");
			}
		})
	});


	// [DELETE PRINTER]
	$(document).on('click', '.delete', function () {
		var printer_id = $(this).attr("id");  // get printer id
		// alert(printer_id);
		if (confirm("Are you sure you want to delete this?")) { // get delete confirmation
			$.ajax({
				url: "printer_delete.php",
				method: "POST",
				data: { printer_id: printer_id },
				success: function (data) {
					alert(data);
					dataTable.ajax.reload();  // reload table
				}
			});
		}
		else {
			return false;  // if click on cancel button - no action
		}
	});


	// [VIEW PRINTER]
	$(document).on('click', '.view_printer', function () {
		var printer_id = $(this).attr("id");
		if (printer_id != '') {
			$.ajax({
				url: "printer_view.php",
				method: "POST",
				data: { printer_id: printer_id },
				success: function (data) {
					$('#printer_detail').html(data);  // replace the whole markup inside printer_detail
					$('#printerDataModal').modal('show');  // show modal that contains printer_detail
				}
			});
		}
	});

});
