<style>
    .custom-button {
        background-color: #4CAF50;
        border: none;
        color: black;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 11px;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 4px;

    }

    a:focus,
    input:focus {
        border: 2px solid #000 !important;
    }

    td.day:hover {
        background: #ffffa2;

    }

    td.today.active.day {
        background: #ff7373;
        color: #fff;
    }

    th.clear {
        text-align: center;
        background: #00507A;
        color: #fff;
    }

    th.clear:hover {
        text-align: center;
        background: #909090;
        color: #fff;

    }

    .datepicker td,
    .datepicker th {
        cursor: pointer;
    }


    span.month:hover {
        background: #ffffa2;

    }

    .custom-button:hover {
        background-color: #45a049;
        /* Darker Green */
    }

    table {
        border-top: 1px black solid;
    }

    .export-btn {
        color: #000 !important;
        background: #bde8ff !important;
        border: 1px solid black !important;

    }

    .dataTables_empty {
        display: table-cell !important;
    }

    .modal-header .close {
        margin: -43px -26px -25px auto !important;
        color: #555 !important;
    }

    .modal .modal-dialog .modal-content .modal-header {
        display: inline-block !important;
    }

    .modal .modal-dialog .modal-content .modal-header .close span {
        font-size: 20px;
        font-weight: 900 !important;
        color: #6a6a6a;
    }


    th {
        border: 1px black solid;
        border-width: 1px 0 1px 1px;
        border-collapse: collapse;
    }

    th:last-child {
        border-right: 1px black solid;
    }

    #EcollectTable table {
        border: 0;
    }

    .btn-generate-container button {
        min-width: 13rem;
        background: #00507a;
    }

    .btn-generate-container button:hover {
        min-width: 13rem;
        background: #909090;
    }

    .close {
        background: none !important;
    }

    .close:hover {
        background: none !important;
    }



    #EcollectTable tr th {
        border-width: 1px 0 1px 1px;
    }

    #EcollectTable tr th:last-child {
        border-right-width: 1px !important;
    }

    .search-btn {
        height: 2.9rem !important;
        width: 7rem;
        border: 0 !important;
    }


    .form-group {
        display: flex;
        align-items: center;
    }

    .date-label {
        margin-top: 5px;
        margin-right: 10px;
    }

    .date-input-group {
        max-width: 170px;
        margin-right: 20px;
    }

    .custom-date-input input[type="date"] {
        appearance: none;
        -webkit-appearance: none;
        padding: 0.375rem 0.75rem;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        margin-right: 0.5rem;
        /* Adjust margin as needed */
    }

    /* Additional styling to hide the calendar icon */
    .custom-date-input input[type="date"]::-webkit-calendar-picker-indicator {
        display: none;
    }
</style>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card m-0" id="toPrint">
        <div class="card py-2 px-1">
            <div class="btn-generate-container row">
                <div class="col row d-flex justify-content-end py-2">
                    <div class="card-body">
                        <div class="d-sm-flex align-items-center mb-4">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="startDate" class="date-label">Start Date:</label>
                        <div class="input-group date date-input-group" id="startDatePicker">
                            <input type="text" class="form-control" name="startDate" id="startDate"
                                style="z-index: 2; background:#fff;border:1px solid black; cursor:pointer;" readonly
                                placeholder="mm /dd /yyyy">
                            <span class="input-group-addon" id="startDateIcon">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
                        </div>

                        <label for="endDate" class="date-label">End Date:</label>
                        <div class="input-group date date-input-group" id="endDatePicker">
                            <input type="text" class="form-control" name="endDate" id="endDate"
                                style="background:#fff;border:1px solid black;cursor:pointer;" readonly
                                placeholder="mm /dd / yyyy">
                            <span class="input-group-addon" id="endDateIcon">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
                        </div>
                    </div>

                </div>
            </div>

            <table id="myTable" class="table table-striped text-center" width="100%">
                <thead>
                    <tr>
                        <th class="font-weight-bold">ID</th>
                        <th class="text-center">Date<i class="m-0">(mm/dd/yyyy)</i></th>
                        <th class="font-weight-bold">Time</th>
                        <th class="font-weight-bold">Status</th>
                        <th class="font-weight-bold">Reference No.</th>
                        <th class="font-weight-bold">PCAB Fee</th>
                        <th class="font-weight-bold">Legal Research Fund</th>
                        <th class="font-weight-bold">Documentary Stamp</th>
                        <th class="font-weight-bold">NGSI Convenience Fee</th>
                        <th class="font-weight-bold">Total Amount</th>
                        <th class="font-weight-bold">Name of Payor</th>
                        <th class="font-weight-bold">Particular</th>
                        <th class="font-weight-bold">Transaction Ref</th>
                        <th class="font-weight-bold">Txn. ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $fmt = new NumberFormatter('en-US', NumberFormatter::CURRENCY);
                    $fmt->setPattern(str_replace('¤#', "", $fmt->getPattern()));
                    if (empty($data)) {
                        // echo "<tr><td colspan='11'>No data available</td></tr>";
                    } else {
                        foreach ($data as $row) {
                            $date = date_create($row['date']);
                            echo "<tr>";
                            echo "<td>" . $row["trans_id"] . "</td>";
                            echo "<td>" . date_format(date_create($row['date']), "m/d/Y") . "</td>";
                            echo "<td>" . date("H:i:s", strtotime($row["date_created"])) . "</td>";
                            echo "<td>" . $row["status"] . "</td>";
                            echo "<td>" . $row["reference_number"] . "</td>";
                            echo "<td class='text-right'>&#8369; " . $fmt->formatCurrency(floatval($row["fees_pcab"]), "") . "</td>";
                            echo "<td class='text-right'>&#8369; " . $fmt->formatCurrency(floatval($row["legal_research_fund"]), "") . "</td>";
                            echo "<td class='text-right'>&#8369; " . $fmt->formatCurrency(floatval($row["document_stamp_tax"]), "") . "</td>";
                            echo "<td class='text-right'>&#8369; " . $fmt->formatCurrency(floatval($row["ngsi_convenience_fee"]), "") . "</td>";
                            $total_AR = $row["fees_pcab"] + $row["document_stamp_tax"] + $row["legal_research_fund"] + $row["ngsi_convenience_fee"];
                            echo "<td class='text-right'>&#8369; " . $fmt->formatCurrency(floatval($total_AR), "") . "</td>";
                            echo "<td>" . $row["name_of_payor"] . "</td>";
                            echo "<td>" . $row["particulars"] . "</td>";
                            echo "<td>" . $row["referenceNumber"] . "</td>";
                            echo "<td>" . $row["TxId"] . "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script>
    $(document).ready(function () {
        function getCurrentDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = (today.getMonth() + 1).toString().padStart(2, '0');
            const day = today.getDate().toString().padStart(2, '0');
            return `${year}-${month}-${day}`; // Adjusted date format
        }

        $('#startDate').val(getCurrentDate());
        $('#endDate').val(getCurrentDate());

        $('#startDate, #endDate').datepicker({
            format: 'yyyy-mm-dd', // Adjusted date format
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
            orientation: 'bottom',
        });
        var table = $('#myTable').DataTable({
            dom: 'Bfrtip',
            scrollX: '100%',
            scrollCollapse: true,
            ordering: false,
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export',
                filename: 'Transaction_Table', // Provide a valid filename here
                autoWidth: false, // Set to true or false based on your requirement
                header: true, // Set to true or false based on your requirement
                footer: true, // Set to true or false based on your requirement
                title: "Electronic Collection",
                className: 'export-btn',
                customizeData: function (data) {
                    for (var i = 0; i < data.body.length; i++) {
                        for (var j = 0; j < data.body[i].length; j++) {
                            // Exclude peso sign from currency cells
                            if (j >= 5 && j <= 9) {
                                data.body[i][j] = data.body[i][j].replace(/₱/g, ''); // Replace peso sign
                            }
                        }
                    }
                }
            }],
        });



        $('#startDate, #endDate').on('change', function () {
            table.draw();
        });

        $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();
            var currentDate = new Date(data[1]);

            var formattedStartDate = new Date(startDate);
            var formattedEndDate = new Date(endDate);

            if (
                (isNaN(formattedStartDate) && isNaN(formattedEndDate)) ||
                (startDate === '' && endDate === '') ||
                (startDate === '' && currentDate <= formattedEndDate) ||
                (formattedStartDate <= currentDate && endDate === '') ||
                (formattedStartDate <= currentDate && currentDate <= formattedEndDate)
            ) {
                return true;
            }

            return false;
        });

        $('.search-btn').on('click', function () {
            table.draw();
        });
    });
</script>