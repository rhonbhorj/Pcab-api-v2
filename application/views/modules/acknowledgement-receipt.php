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
                    <div class="form-group" style="margin: inherit; margin-left:20px;">
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
                    <div class="card-body">
                        <div class="d-sm-flex align-items-center mb-4">

                        </div>
                    </div>



                    <div class=" col-mb-3 mr-3 mt-3">
                        <button class="btn-lg btn-outline-dark rounded border-0" data-toggle="modal"
                            data-target="#Daily_CollectionModal">Daily Collection</button>
                        <div class="modal fade" id="Daily_CollectionModal" tabindex="-1" role="dialog"
                            aria-labelledby="Daily_CollectionModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-sm" role="document">
                                <div id="DailyCollectModal" class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="Daily_CollectionModalLabel">Daily Collection</h5>
                                        <button type="button" class="close text-right pr-4" data-dismiss="modal"
                                            aria-hidden="true">&times;</button>
                                    </div>
                                    <div class="modal-body bg-white pb-3">
                                        <div class="row mb-2">
                                            <div class="col-12 d-flex flex-row flex-wrap">
                                                <div class="custom-date-input">
                                                    <label for="modal_start_date"
                                                        class="mr-2 d-flex align-items-center">Start Date:</label>
                                                    <input type="date" id="modal_start_date" class="form-control"
                                                        style="width: 16rem;">
                                                </div>
                                                <div class="custom-date-input">
                                                    <label for="modal_end_date"
                                                        class="mr-2  d-flex align-items-center">End Date:</label>
                                                    <input type="date" id="modal_end_date" class="form-control"
                                                        style="width: 16rem;">
                                                </div>
                                                <div id="validationMessage"></div>
                                            </div>
                                        </div>

                                        <div id="modalDataTableContainer" class="overflow-auto"></div>
                                    </div>
                                    <div class="modal-footer bg-white border-top-0 d-flex ">
                                        <button type="button"
                                            class="btn-sm btn-outline-dark mr-3 mb-2 rounded preview-btn-modal">Preview</button>
                                        <button type="button" onclick="printDailyReport()"
                                            class="btn-sm btn-outline-dark mr-3 mb-2 rounded">Download</button>
                                        <?php if ($_SESSION['usertype'] == "SUPERADMIN")
                                            echo '<button type="button" class="btn-sm btn-outline-dark mr-3 mb-2 rounded " data-toggle="modal" data-target="#Submit_deposit" id="submit-deposit" data-backdrop="static" data-keyboard="false">Submit Deposit</button>' ?>


                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class=" col-mb-3 mr-3 mt-3">
                            <button class="btn-lg btn-outline-dark rounded border-0 w-50" data-toggle="modal"
                                data-target="#exportModal">E-Collection</button>
                            <div class="modal fade" id="exportModal" tabindex="-1" role="dialog"
                                aria-labelledby="exportModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exportModalLabel">E-Collection </h5>
                                            <button type="button" class="close text-right pr-3" data-dismiss="modal"
                                                aria-hidden="true">&times;</button>
                                        </div>
                                        <div class="modal-body  bg-white pb-3">
                                            <div class="form-group">
                                                <label for="e-collection_start_date" class="date-label">Start Date:</label>
                                                <div class="input-group date date-input-group" id="startDatePicker">
                                                    <input type="text" class="form-control" name="e-collection_start_date"
                                                        id="e-collection_start_date"
                                                        style="z-index: 2; background:#fff;border:1px solid black; cursor:pointer;"
                                                        readonly placeholder="mm /dd /yyyy">
                                                    <span class="input-group-addon" id="startDateIcon">
                                                        <i class="glyphicon glyphicon-calendar"></i>
                                                    </span>
                                                </div>

                                                <label for="e-collection_end_date" class="date-label">End Date:</label>
                                                <div class="input-group date date-input-group" id="endDatePicker">
                                                    <input type="text" class="form-control" name="e-collection_end_date"
                                                        id="e-collection_end_date"
                                                        style="background:#fff;border:1px solid black;cursor:pointer;"
                                                        readonly placeholder="mm /dd / yyyy">
                                                    <span class="input-group-addon" id="endDateIcon">
                                                        <i class="glyphicon glyphicon-calendar"></i>
                                                    </span>
                                                </div>
                                            </div>

                                            <table id="EcollectTable" class="table table-striped text-center" width="100%">
                                                <thead>
                                                    <tr>

                                                        <th colspan="3" class="text-center">Electronic Acknowledgement
                                                            Receipt</th>

                                                        <th rowspan="3" class="text-center">Payor</th>
                                                        <th rowspan="3" class="text-center">Particulars</th>

                                                        <th colspan="4" class="text-center">Amount</th>
                                                    </tr>
                                                    <tr>
                                                        <th rowspan="2" class="text-center">Date<i
                                                                class="m-0">(mm/dd/yyyy)</i></th>
                                                        <th rowspan="2" class="text-center">Time</th>
                                                        <th rowspan="2" class="text-center">AR Number</th>
                                                        <th rowspan="2" class="text-center">Total per AR</th>
                                                        <th colspan="3" class="text-center">Breakdown Collection</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-center">CIAP-PCAB</th>
                                                        <th colspan="1" class="text-center">DST</th>
                                                        <th colspan="1" class="text-center">LRF</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="border-bottom-1">

                                                    <?php
                                        $fmt = new NumberFormatter('en-US', NumberFormatter::CURRENCY);
                                        $fmt->setPattern(str_replace('¤#', "", $fmt->getPattern()));
                                        if (empty($data)) {
                                            // echo "<tr><td colspan='11'>No data available</td></tr>";
                                        } else {
                                            $total = ["totalAR" => 0, "totalFee" => 0, "totalDST" => 0, "totalLRF" => 0];
                                            foreach ($data as $row) {
                                                echo "<tr>";
                                                echo "<td>" . date_format(date_create($row['last_modified']), "m/d/Y") . "</td>";
                                                echo "<td>" . date("H:i:s", strtotime($row["last_modified"])) . "</td>";
                                                echo "<td>" . $row["ar_no"] . "</td>";
                                                echo "<td>" . $row["name_of_payor"] . "</td>";
                                                echo "<td>" . $row["particulars"] . "</td>";
                                                $total_per_AR = $row["fees_pcab"] + $row["document_stamp_tax"] + $row["legal_research_fund"];
                                                $total["totalAR"] += $total_per_AR;
                                                $total["totalFee"] += $row["fees_pcab"];
                                                $total["totalDST"] += $row["document_stamp_tax"];
                                                $total["totalLRF"] += $row["legal_research_fund"];
                                                echo "<td class='text-right'>" . $fmt->formatCurrency(floatval($total_per_AR), "PHP") . "</td>";
                                                echo "<td class='text-right'>" . $fmt->formatCurrency(floatval($row["fees_pcab"]), "PHP") . "</td>";
                                                echo "<td class='text-right'>" . $fmt->formatCurrency(floatval($row["document_stamp_tax"]), "PHP") . "</td>";
                                                echo "<td class='text-right'>" . $fmt->formatCurrency(floatval($row["legal_research_fund"]), "PHP") . "</td>";
                                                echo "</tr>";
                                            }
                                        }
                                        ?>


                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer bg-white border-top-0">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Button 2 Trigger -->
            </div>



            <div class="scrollable-container" style="padding: 0.5rem;">

                <table id="myTable" class="table table-striped text-center" width="100%">
                    <!-- Your table headers go here -->
                    <thead>
                        <tr>


                            <th class="font-weight-bold">Txn. ID</th>
                            <th class="text-center">Date<i class="m-0">(mm/dd/yyyy)</i></th>
                            <th class="font-weight-bold">Time</th>
                            <th class="font-weight-bold">Reference No.</th>
                            <th class="font-weight-bold">Name of Payor</th>
                            <th class="font-weight-bold">Particular</th>
                            <th class="font-weight-bold">Status</th>
                            <th class="font-weight-bold">PCAB Fee</th>
                            <th class="font-weight-bold">Legal Research Fund</th>
                            <th class="font-weight-bold">Documentary Stamp</th>
                            <th class="font-weight-bold">NGSI Convenience Fee</th>
                            <th class="font-weight-bold">Total Amount</th>
                            <th class="font-weight-bold">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Assuming $data is your array of data
                        if (empty($data)) {
                            echo "<tr py-5><td colspan='10'>No data available</td></tr>";
                        } else {
                            foreach ($data as $row) {
                                $date = date_create($row['date']);
                                echo "<tr>";


                                echo "<td>" . $row["trans_id"] . "</td>";
                                echo "<td>" . date_format(date_create($row['last_modified']), "m/d/Y") . "</td>";
                                echo "<td>" . date("H:i:s", strtotime($row["last_modified"])) . "</td>";
                                echo "<td>" . $row["reference_number"] . "</td>";
                                echo "<td>" . $row["name_of_payor"] . "</td>";
                                echo "<td>" . $row["particulars"] . "</td>";
                                echo "<td>" . $row["status"] . "</td>";
                                echo "<td class='text-right'>&#8369; " . $fmt->formatCurrency(floatval($row["fees_pcab"]), "") . "</td>";
                                echo "<td class='text-right'>&#8369; " . $fmt->formatCurrency(floatval($row["legal_research_fund"]), "") . "</td>";
                                echo "<td class='text-right'>&#8369; " . $fmt->formatCurrency(floatval($row["document_stamp_tax"]), "") . "</td>";
                                echo "<td class='text-right'>&#8369; " . $fmt->formatCurrency(floatval($row["ngsi_convenience_fee"]), "") . "</td>";
                                $total_AR = $row["fees_pcab"] + $row["document_stamp_tax"] + $row["legal_research_fund"] + $row["ngsi_convenience_fee"];
                                echo "<td class='text-right'>&#8369; " . $fmt->formatCurrency(floatval($total_AR), "") . "</td>";
                                $total_per_AR_formatted = number_format($total_per_AR, 2);
                                echo "<td><button type='button'style='width: 80px; height: 25px; background: #555;' class=' btn-outline-dark border-0 btn-print-receipt' data-receipt-id='" . $row['trans_id'] . "'  onclick='printRow(" . $row['trans_id'] . ")'>Download</button></td>";
                                echo "</tr>";
                            }
                        }
                        ?>

                    </tbody>

                </table>
            </div>
            <div class='row divider'>
                <div class='col-12 my-5 py-2 border'></div>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="Submit_deposit" tabindex="-1" role="dialog" aria-labelledby="Submit_depositnModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg d-flex justify-content-center mt-3" role="document">
        <div id="Submit_depositModal" class="modal-content" style="width: 24rem;">
            <div class="modal-header py-2">
                <h5 class="modal-title" id="Submit_depositModalLabel">Collection(s) Settlement</h5>
                <button type="button" class="close text-right pr-4 text-dark" data-dismiss="modal"
                    aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body bg-white py-3">
                <!-- awdawd -->
                <div class="d-flex flex-column input-form">
                    <span class="message" style="position:relative; bottom: .5rem"></span>
                    <div>
                        <label class="pb-1">Day(s) of Collection</label>
                        <span class="m-0 p-0 ml-1 total-collection" style="margin-top:3px!important;">Total: &#8369;
                            0.00</span>
                    </div>
                    <div class="d-flex flex-row justify-content-between mt-3 mb-4 border-bottom-1">
                        <div id="dateRange">
                            <input type="date" name="collection_date_from" class="p-2 border rounded" value="">

                        </div>
                        <div id="dateRange">
                            <input type="date" name="collection_date_to" class="p-2 border border-black rounded"
                                value="">
                        </div>
                    </div>
                    <!-- <div id="referenceNo">
                        <span>Reference No. *</span>
                        <input type="text" name="deposit_reference_no" class="p-2 pl-3 border border-black mt-3 rounded w-100">
                    </div> -->
                    <div id="settlements">
                        <div id="dateOfDeposit">
                            <input type="date" name="deposited_date" class="p-2 pl-3 mb-2 rounded w-100 border">
                        </div>
                        <label class="">CIAP-PCAB <span class="d-inline p-0 m-0 pl-2"
                                style="pointer-events:auto;margin-top:3px!important;" tabindex="0" data-toggle="tooltip"
                                title="Undeposited Fee of <?= $last_deposit_date ? date_format(date_create($last_deposit_date), "m/d/Y") : "N/A" ?>">(&#8369;
                                <?= $fmt->formatCurrency(floatval($last_deposit ? $last_deposit["balance_fees_pcab"] : 0), "PHP") ?>
                                <i class="icon-info bg-dark text-white rounded-circle"></i>)
                            </span>
                            <span class="m-0 p-0 pl-3 d-block pcab-fee" style="margin-top:3px!important;">Total Amount:
                                &#8369; 0.00</span></label>
                        <div id="fees_pcab" class="d-flex flex-row justify-content-between">
                            <div id="referenceNo">
                                <span>Reference No. *</span>
                                <input type="text" name="reference_no"
                                    class="p-2 pl-3 border border-black mb-2 w-100 rounded">
                            </div>
                            <div style="width:10px;"></div>
                            <div id="amount">
                                <span>Amount ( &#8369; ) *</span>
                                <input type="text" name="amount"
                                    class="p-2 pl-3 border border-black mb-2 w-100 rounded text-right">
                            </div>
                        </div>
                        <label class="">Documentary Stamp Tax <span class="d-inline p-0 m-0 pl-2"
                                style="pointer-events:auto;margin-top:3px!important;" tabindex="0" data-toggle="tooltip"
                                title="Undeposited DST of <?= $last_deposit_date ? date_format(date_create($last_deposit_date), "m/d/Y") : "N/A" ?>">(&#8369;
                                <?= $fmt->formatCurrency(floatval($last_deposit ? $last_deposit["balance_document_stamp_tax"] : 0), "PHP") ?>
                                <i class="icon-info bg-dark text-white rounded-circle"></i>)
                            </span>
                            <span class="m-0 p-0 pl-3 d-block dst" style="margin-top:3px!important;">Total Amount:
                                &#8369; 0.00</span></label>
                        <div id="document_stamp_tax" class="d-flex flex-row justify-content-between">
                            <div id="referenceNo">
                                <span>Reference No. *</span>
                                <input type="text" name="reference_no"
                                    class="p-2 pl-3 border border-black mb-2 w-100 rounded">
                            </div>
                            <div style="width:10px;"></div>
                            <div id="amount">
                                <span>Amount ( &#8369; ) *</span>
                                <input type="text" name="amount" class="p-2 pl-3 mb-2 w-100  border rounded text-right">
                            </div>
                        </div>
                        <label class="">Legal Research Fund <span class="d-inline p-0 m-0 pl-2"
                                style="pointer-events:auto;margin-top:3px!important;" tabindex="0" data-toggle="tooltip"
                                title="Undeposited LRF of <?= $last_deposit_date ? date_format(date_create($last_deposit_date), "m/d/Y") : "N/A" ?>">(&#8369;
                                <?= $fmt->formatCurrency(floatval($last_deposit ? $last_deposit["balance_legal_research_fund"] : 0), "PHP") ?>
                                <i class="icon-info bg-dark text-white rounded-circle"></i>)
                            </span>
                            <span class="m-0 p-0 pl-3 d-block lrf" style="margin-top:3px!important;">Total Amount:
                                &#8369; 0.00</span></label>
                        <div id="legal_research_fund" class="d-flex flex-row justify-content-between">
                            <div id="referenceNo">
                                <span>Reference No. *</span>
                                <input type="text" name="reference_no" class="p-2 pl-3 mb-2 w-100 border rounded">
                            </div>
                            <div style="width:10px;"></div>
                            <div id="amount">
                                <span>Amount ( &#8369; ) *</span>
                                <input type="text" name="amount" class="p-2 pl-3 mb-2 w-100 border rounded text-right">
                            </div>
                        </div>
                        <div class="text-right sum-of-deposit">Total Deposit <br /> &#8369; <p
                                class="p-0 m-0 px-2 d-inline border-bottom border-dark">0.00</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-white border-top py-2 px-3">

                <button type="button" class="btn-sm border-0 m-0 ml-2 rounded close-modal bg-secondary"
                    id="cancelDeposit" data-dismiss="modal" aria-hidden="true">Cancel</button>
                <!-- <button type="button" class="btn-sm border-0 m-0 ml-2 rounded close-modal bg-secondary" id="confirmDeposit" data-toggle="modal" data-target="#DepositConfirmationModal" data-backdrop="static" data-keyboard="false">confirm</button> -->
                <button type="button" class="btn-sm border-0 m-0 ml-2 rounded submit-deposit-btn-modal"
                    id="submitDeposit" data-toggle="modal" data-target="#DepositConfirmationModal" id="submit-deposit"
                    data-backdrop="static" data-keyboard="false" onmouseover="this.style.opacity=1"
                    onmouseleave="this.style.opacity=.8" style="background-color:#00507a;opacity:.8;">
                    <i class="icon-settings spin" hidden></i> <span>Submit</span><span hidden>Submitting</span>
                </button>

            </div>
        </div>
    </div>
</div>
<div class="modal fade show" id="DepositConfirmationModal" tabindex="-1" role="dialog"
    aria-labelledby="Confirmation_depositnModal" aria-hidden="true">
    <div class="modal-dialog modal-lg d-flex justify-content-center" role="document">
        <div class="modal-content" style="width: auto;">
            <div class="modal-header">
                <h5 class="modal-title">Deposit Confirmation</h5>
            </div>
            <div class="modal-body bg-white pb-3 " style="width: auto; padding: 1rem 2rem;">
                You are about to submit a deposit, are you sure you to proceed?
            </div>
            <div class="modal-footer bg-white border-top py-2 px-3">

                <button type="button" class="btn-sm border-0 m-0 ml-2 rounded close-modal bg-secondary"
                    data-dismiss="modal" aria-hidden="true">Cancel</button>
                <!-- <button type="button" class="btn-sm border-0 m-0 ml-2 rounded close-modal bg-secondary" id="confirmDeposit" data-toggle="modal" data-target="#DepositConfirmationModal" data-backdrop="static" data-keyboard="false">confirm</button> -->
                <button type="button" class="btn-sm border-0 m-0 ml-2 rounded proceed-confirmation-btn"
                    data-dismiss="modal" aria-hidden="true" onmouseover="this.style.opacity=1"
                    onmouseleave="this.style.opacity=.8" style="background-color:#00507a;opacity:.8;">
                    Proceed
                </button>

            </div>
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script>
    $(document).ready(function () {
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })

        function getCurrentDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = (today.getMonth() + 1).toString().padStart(2, '0');
            const day = today.getDate().toString().padStart(2, '0');
            return `${month}/${day}/${year}`;
        }

        // Set default values for start and end date
        $('#startDate').val(getCurrentDate());
        $('#endDate').val(getCurrentDate());

        // Initialize datepicker for the first DataTable
        $('#startDate, #endDate').datepicker({
            format: 'mm-dd-yyyy',
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
                filename: 'ACKNOWLEDGEMENT-RECEIPT_Table',
                autoWidth: false,
                header: true,
                footer: true,
                className: 'export-btn',
                exportOptions: {
                    columns: ':not(:last-child)', // Exclude the last column (Action)
                    format: {
                        body: function (data, row, column, node) {
                            // Exclude peso sign from currency cells (assuming columns 8 to 11 are currency columns)
                            if (column >= 7 && column <= 11) {
                                return data.replace(/₱/g, ''); // Replace peso sign
                            }
                            return data;
                        }
                    }
                }
            }]
        });

        $('.search-btn').on('click', function () {
            table.draw();
        });

        // Modify the start and end date filtering to only apply to the specific DataTable
        $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
            if (settings.nTable.id !== 'myTable') {
                return true;
            }
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();
            var currentDate = new Date(data[1]);

            var formattedStartDate = new Date(startDate);
            var formattedEndDate = new Date(endDate);

            if (
                (isNaN(formattedStartDate) || isNaN(formattedEndDate)) ||
                (startDate === '' && endDate === '') ||
                (startDate === '' && currentDate <= formattedEndDate) ||
                (formattedStartDate <= currentDate && endDate === '') ||
                (formattedStartDate <= currentDate && currentDate <= formattedEndDate)
            ) {
                return true;
            }
        });

        // Trigger initial table draw
        table.draw();

        // Update table on date change
        $('#startDate, #endDate').on('change', function () {
            table.draw();
        });
    });

    $(document).ready(function () {
        // Tooltip initialization
        $('[data-toggle="tooltip"]').tooltip();

        // Datepicker initialization
        $('#e-collection_start_date, #e-collection_end_date').datepicker({
            format: 'mm-dd-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
            orientation: 'bottom',
        });

        var today = new Date();
        var dateString = today.getFullYear() + '-' + (today.getMonth() + 1).toString().padStart(2, '0') + '-' + today.getDate().toString().padStart(2, '0');
        var filename = 'NGSI_E-Collection_' + dateString;

        var dataTable = $('#EcollectTable').DataTable({
            dom: 'Bfrtip',
            // scrollX: '100%',
            scrollCollapse: true,
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export',
                filename: filename,
                autoWidth: true,
                header: true,
                footer: true,
                title: "Electronic Collection",
                className: 'export-btn',
                exportOptions: {
                    format: {

                    }
                },
                customize: function (xlsx) {
                    let sheet = xlsx.xl.worksheets['sheet1.xml'];
                    let downrows = 2;
                    let clRow = $('row', sheet);
                    let total = {
                        ar_total: 0,
                        pcab: 0,
                        dst: 0,
                        lrf: 0
                    }
                    const cToMerge = [{
                        start: "A2",
                        to: "B2"
                    }, {
                        start: "E2",
                        to: "H2"
                    }, {
                        start: "F3",
                        to: "H3"
                    }];

                    clRow.each(function () {
                        let attr = $(this).attr('r');
                        if (attr == 1) return;
                        let ind = parseInt(attr);
                        ind = ind + downrows;
                        $(this).attr("r", ind);
                    });


                    $('row c ', sheet).each(function () {
                        let attr = $(this).attr('r');
                        if (attr == "A1") return;
                        let pre = attr.substring(0, 1);
                        let ind = parseInt(attr.substring(1, attr.length));
                        ind = ind + downrows;
                        $(this).attr("r", pre + ind);
                    });

                    function collectTotal(total_prop) {
                        const props = Object.keys(total);
                        const rows = $("row", sheet.childNodes[0].childNodes[1])
                        for (let i = 0; i < rows.length; i++) {
                            const data = $("c v", rows[i])
                            if (!data.length) continue;
                            total[total_prop] += parseFloat(data[props.indexOf(total_prop)].textContent)
                        }
                        return total[total_prop]
                    }

                    function Addrow(index, data) {
                        msg = '<row r="' + index + '">'
                        for (i = 0; i < data.length; i++) {
                            let {
                                k,
                                v
                            } = data[i]

                            if (data[i].currency) {
                                msg += `<c r="${k + index}" s="62"><v>${v}</v></c>`
                                continue;
                            }


                            msg += `<c t="inlineStr" r="` + (k + index) + `" s='${data[i]['text-right'] ? "52" : "2"}'>`;
                            msg += '<is>';
                            msg += '<t>' + v + '</t>';
                            msg += '</is>';
                            msg += '</c>';
                        }
                        return msg;
                    }

                    function mergeCells(data) {
                        let i = 0
                        for (; i < data.length; i++) {
                            let mc = sheet.createElement("mergeCell")
                            mc.setAttribute("ref", `${data[i].start}:${data[i].to}`)
                            sheet.childNodes[0].childNodes[2].appendChild(mc)
                        }
                        sheet.childNodes[0].childNodes[2].setAttribute("count", ++data.length)

                    }

                    mergeCells(cToMerge)

                    let r1 = Addrow(2, [{
                        k: 'A',
                        v: 'Electronic Acknowledgement Receipt'
                    }, {
                        k: 'E',
                        v: 'Amount'
                    }]);
                    let r2 = Addrow(3, [{
                        k: 'F',
                        v: 'Collection Breakdown'
                    }]);
                    const footer = Addrow(sheet.childNodes[0].childNodes[1].childElementCount + 3, [{
                        k: 'E',
                        v: 'Total:',
                        'text-right': true
                    }, {
                        k: 'F',
                        v: collectTotal("ar_total"),
                        currency: true
                    }, {
                        k: 'G',
                        v: collectTotal("pcab"),
                        currency: true
                    }, {
                        k: 'H',
                        v: collectTotal("dst"),
                        currency: true
                    }, {
                        k: 'I',
                        v: collectTotal("lrf"),
                        currency: true
                    }]);

                    let nodeArray = sheet.childNodes[0].childNodes[1].innerHTML.split("</row>")
                    nodeArray.splice(1, 0, r1, r2)
                    let strNode = nodeArray.join("</row>\n")
                    sheet.childNodes[0].childNodes[1].innerHTML = strNode + footer.concat("</row>");
                    $("row:last-child c[s=2], row c[s=66], row c[s=64]", sheet.childNodes[0].childNodes[1]).attr("s", "62");
                }
            }]
        });

        // Add search functionality
        $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
            if (settings.nTable.id !== 'EcollectTable') {
                return true;
            }
            var e_start_Date = $('#e-collection_start_date').datepicker('getDate');
            var e_ende_date = $('#e-collection_end_date').datepicker('getDate');
            var E_CurrentDate = new Date(data[0]);

            if (
                (e_start_Date === null || e_ende_date === null) ||
                (isNaN(e_start_Date) || isNaN(e_ende_date)) ||
                (e_start_Date <= E_CurrentDate && e_ende_date >= E_CurrentDate)
            ) {
                return true;
            }

        });

        // Update table on date change
        $('#e-collection_start_date, #e-collection_end_date').on('change', function () {
            dataTable.draw();
        });
    });




    const _jsonData = <?php echo json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;

    const toLocalCurrency = (val) => parseFloat(val).toLocaleString('en-US', {
        maximumFractionDigits: 2,
        minimumFractionDigits: 2
    })

    function applyDateFilter() {
        var start_date = $('#startDate').val();
        var end_date = $('#endDate').val();

        table.draw();
    }


    $('#modal_start_date, #modal_end_date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
        orientation: 'bottom',
    });
    // Modal date filter
    $('.preview-btn-modal').on('click', function () {
        var modalStartDate = $('#modal_start_date').val();
        var modalEndDate = $('#modal_end_date').val();


        // Validation for start and end date
        if (!modalStartDate || !modalEndDate) {
            $('#validationMessage').html('<span style="font-size:.8rem; color: red; text-align:center;" role="alert">Please select both start and end dates.</span>');
            return;
        }

        // Your existing code for data filtering and display goes here
        const filteredData = _jsonData.filter(item => {
            let itemDate = new Date(item.date);
            let modalStartDateObj = new Date(modalStartDate);
            let modalEndDateObj = new Date(modalEndDate);

            return itemDate >= modalStartDateObj && itemDate <= modalEndDateObj;
        });

        if (!filteredData.length) {
            $('#validationMessage').html('<span style="font-size:.8rem; color: red; text-align:center;" role="alert">No data found for the selected date range.</span>');
            return;
        }

        // Clear existing content in the modal
        $('#validationMessage').empty();
        $('#modalDataTableContainer').empty();

        // Create a new div to wrap the table and add additional elements if needed     
        var modalContent = document.createElement('div');
        modalContent.classList.add('modal-content', 'table-responsive'); // Add classes for styling and responsiveness
        modalContent.style.overflow = 'hidden';

        var modalBody = document.createElement('div');
        modalBody.classList.add('modal-body-content');


        // Create a new table with the matching rows and an id
        var modalTable = document.createElement('table');
        modalTable.id = 'modalDataTable'; // Add id to the table
        modalTable.classList.add('table', 'table-bordered', 'table-hover', 'table-striped'); // Add DataTable styling classes

        var modalTableHead = document.createElement('thead');
        modalTableHead.classList.add('thead'); // Added light background for the table head
        modalTableHead.innerHTML = ` <tr><th colspan="8" class="text-center">Collection</th></tr><tr><th style="width:${100 / 9}%;" rowspan="2">Date & Time</th><th style="width:${100 / 9}%;" rowspan="2">AR Number</th><th style="width:${100 / 9}%;" rowspan="2">Name of Payor</th><th style="width:${100 / 9}%;" rowspan="2">Reference Number</th><th style="width:${100 / 9}%;">CIAP-PCAB</th><th style="width:${100 / 9}%;">LRF</th><th style="width:${100 / 9}%;">DST</th><th style="width:${100 / 9}%;" rowspan="2">Total Collection</th></tr><tr><th>Account No.<br/>(0052-1684-30)</th><th>Account No.<br/>(3402-2866-00)</th><th>Account No.<br/>(3402-2866-19)</th></tr>`;

        var modalTableBody = document.createElement('tbody');



        // Iterate through filtered data to calculate totals
        filteredData.forEach((row) => {
            // Parse amounts to numbers
            const CIAPPCAB = parseFloat(row.fees_pcab);
            const LRF = parseFloat(row.legal_research_fund);
            const DST = parseFloat(row.document_stamp_tax);

            // Sum of fees_pcab, legal_research_fund, and document_stamp_tax
            const collection = CIAPPCAB + LRF + DST;

            // Append row to modal table body
            // Create number formatter instance
            const formatter = new Intl.NumberFormat('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            });

            modalTableBody.innerHTML += `<tr>
            <td class="text-left" style='width:${100 / 9}%;padding-left:18px;'>${row.last_modified}</td>
            <td class="text-center" style='width:${100 / 9}%;padding-left:18px;'>${row.ar_no}</td>
            <td style='width:${100 / 9}%;padding-left:18px; white-space: pre-wrap; word-wrap: break-word;'>${row.name_of_payor}</td>
            <td style='width:${100 / 9}%;padding-left:18px;'>${row.reference_number}</td>
            <td class="text-right" style='width:${100 / 9}%;'>${formatter.format(CIAPPCAB)}</td>
            <td class="text-right" style='width:${100 / 9}%;'>${formatter.format(LRF)}</td>
            <td class="text-right" style='width:${100 / 9}%;'>${formatter.format(DST)}</td>
            <td class="text-right">${formatter.format(collection)}</td>
        </tr>`;

            function formatDate(dateString) {
                const date = new Date(dateString);
                const formattedDate = `${padZero(date.getMonth() + 1)}/${padZero(date.getDate())}/${date.getFullYear()} ${padZero(date.getHours())}:${padZero(date.getMinutes())}:${padZero(date.getSeconds())}`;
                return formattedDate;
            }

            function padZero(num) {
                return (num < 10 ? '0' : '') + num;
            }

        });

        // Append the new table to the modal body
        modalTable.appendChild(modalTableHead);
        modalTable.appendChild(modalTableBody);
        modalBody.appendChild(modalTable);

        // Append totals row to modal table body
        // if ("<?= $_SESSION['usertype'] ?>" == "SUPERADMIN")
        const totalFormatter = new Intl.NumberFormat('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        });

        // Append totals row to modal table body with formatted totals
        // modalTableBody.innerHTML += `<tr><td class="text-right" colspan="4">Total:</td><td class="text-right">${totalFormatter.format(totalCIAPPCAB)}</td><td class="text-right">${totalFormatter.format(totalLRF)}</td><td class="text-right">${totalFormatter.format(totalDST)}</td><td class="text-right">${totalFormatter.format(totalCollection)}</td></tr>`;
        // Append the modal body to the modal content
        modalContent.appendChild(modalBody);

        // Append the modal content to the modal container
        document.getElementById('modalDataTableContainer').appendChild(modalContent);

        // Change the modal dialog size with a transition
        var modalDialog = $('#Daily_CollectionModal .modal-dialog');

        // Remove table content when modal is closed
        $('#Daily_CollectionModal').on('hidden.bs.modal', function (e) {
            // Reset form fields
            $('#modal_start_date').val('');
            $('#modal_end_date').val('');
            // Clear any validation messages
            $('#validationMessage').empty();
            // Clear table content
            $('#modalDataTableContainer').empty();
            // Reset modal size to small
            $(this).attr("role", "dialog");
            $(".modal-dialog", this).removeClass("modal-lg").addClass("modal-sm");
        });

        $('#modal_start_date, #modal_end_date').on("change", function () {
            $('#validationMessage').empty();
        });

        // Ensure that it stays in modal-lg size
        if (!modalDialog.hasClass('modal-lg')) {
            modalDialog.removeClass('modal-sm');
            modalDialog.addClass('modal-lg');
            modalDialog.css('transition', 'width 0.5s ease-in-out'); // Adjust the duration and easing as needed
        }

        // Initialize DataTable for the modal table with sorting enabled
        var table = $('#modalDataTable').DataTable({
            dom: '<"pull-left"b><"pull-right"f>rt<"row"<"col-sm-4"l><"col-sm-4"i><"col-sm-4"p>>',

        });
    });

    // Remove table content when modal is closed
    $('#Daily_CollectionModal').on('hidden.bs.modal', function (e) {
        // Reset form fields
        $('#modal_start_date').val('');
        $('#modal_end_date').val('');
        // Clear any validation messages
        $('#validationMessage').empty();
        // Clear table content
        $('#modalDataTableContainer').empty();
        $(this).attr("role", "dialog")
        $(".modal-dialog", this).removeClass("modal-lg").addClass("modal-sm")
    });

    $('#modal_start_date, #modal_end_date').on("change", function () {
        $('#validationMessage').empty();
    });

    $('.download-btn-modal').on('click', function () {
        var modalStartDate = $('#modal_start_date').val();
        var modalEndDate = $('#modal_end_date').val();

        if (!modalStartDate || !modalEndDate) {
            $('#validationMessage').html('<span style="font-size:.8rem; color: red; margin-left:1.5rem;" role="alert">Please select both start and end dates.</span>');
            return;
        }

        // Clear existing content in the modal
        $('#validationMessage').empty();

        printDailyReport(modalStartDate, modalEndDate);
    });

    // Remove table content when modal is closed
    $('#Daily_CollectionModal').on('hidden.bs.modal', function (e) {
        $('#modalDataTableContainer').empty();

    });

    async function printDailyReport(startDate, endDate) {
        const filteredData = _jsonData.filter(object => {
            const modalStartDate = new Date($("#Daily_CollectionModal #modal_start_date").val());
            const modalEndDate = new Date($("#Daily_CollectionModal #modal_end_date").val());
            const objectDate = new Date(object.date);
            return objectDate >= modalStartDate && objectDate <= modalEndDate;
        });

        let doc = new jspdf.jsPDF({
            orientation: 'p',
            unit: 'px'
        });

        let report_number = filteredData[0].report_no;
        let pdf_date = filteredData[0].date;

        let i = 0;
        let totalCIAPPCAB = 0;
        let totalLRF = 0;
        let totalDST = 0;
        let totalCollection = 0;
        let currentPage = 1; // Track the current page number

        let rowsPerPageHtml = '';


        while (filteredData.length - (i * 21) > 0) {
            let rows = filteredData.slice(i * 21, i * 21 + 21);

            // Generate HTML for the current page
            rowsPerPageHtml += `<div class="page-container" style="margin-top: 9rem; margin-left:2rem; width: 100%; text-align: center; margin-bottom;10rem;">
                <div class="table-wrapper" style="display: inline-block; width: 66rem; margin-bottom:14rem;">
                <table class="report-table " style="width: 100%; border-collapse: collapse; border: 1px solid black;">
                <thead>
        <tr>
            <th colspan="8" class="text-center">Collection</th>
        </tr>
        <tr>
            <th style="text-wrap:nowrap; border-bottom: none; ">Date & Time</th>
            <th style="text-wrap:nowrap; border-bottom: none; ">AR Number</th>
            <th style="text-wrap:nowrap; border-bottom: none;">Name of Payor</th>
            <th style="text-wrap:nowrap; border-bottom: none;  ">Reference Number</th>
            <th style="text-wrap:nowrap;">CIAP-PCAB</th>
            <th style="text-wrap:nowrap;">LRF</th>
            <th style="text-wrap:nowrap;">DST</th>
            <th style="text-wrap:nowrap; border-bottom: none;">Total Collection</th>
        </tr>
        <tr>
            <th style="text-wrap:nowrap; border-top: none;"></th>
            <th style="text-wrap:nowrap; border-top: none;"></th>
            <th style="text-wrap:nowrap; border-top: none;"></th>
            <th style="text-wrap:nowrap; border-top: none;"></th>
            <th>Account No.<br/>(0052-1684-30)</th>
            <th>Account No.<br/>(3402-2866-00)</th>
            <th>Account No.<br/>(3402-2866-19)</th>
            <th style="text-wrap:nowrap; border-top: none;"></th>
        </tr>
        </thead>
                    <tbody>`;

            rows.forEach(data => {
                // Function to manually wrap text
                const wrapText = (text, maxLength) => {
                    const words = text.split(' ');
                    let lines = [];
                    let currentLine = '';

                    words.forEach(word => {
                        if ((currentLine.length + word.length) <= maxLength) {
                            currentLine += (currentLine.length > 3 ? ' ' : '') + word;
                        } else {
                            lines.push(currentLine);
                            currentLine = word;
                        }
                    });

                    if (currentLine.length > 3) {
                        lines.push(currentLine);
                    }

                    return lines.join('\n');
                };
                // Calculate totals
                const feesPCAB = parseFloat(data.fees_pcab ?? 0);
                const legalResearchFund = parseFloat(data.legal_research_fund ?? 0);
                const documentStampTax = parseFloat(data.document_stamp_tax ?? 0);
                const totalForRow = feesPCAB + legalResearchFund + documentStampTax;

                // Update totals
                totalCIAPPCAB += feesPCAB;
                totalLRF += legalResearchFund;
                totalDST += documentStampTax;
                totalCollection += totalForRow;
                rowsPerPageHtml += `
                    <tr>
                        <td class="cell" style="border: 1px solid black; width: 12px;">${wrapText(data.last_modified ?? "", 13)}</td>
                        <td class="cell" style="border: 1px solid black; width: 12px;">${wrapText(data.reference_number ?? "", 10)}</td>
                        <td class="cell" style="border: 1px solid black; text-wrap:wrap;">${data.name_of_payor ?? ""}</td>
                        <td class="cell" style="border: 1px solid black; width: 12px;">${wrapText(data.referenceNumber ?? "", 10)}</td>
                        <td class="cell" style="border: 1px solid black; width: 12px;">${parseFloat(parseFloat(data.fees_pcab ?? 0)).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                        <td class="cell" style="border: 1px solid black; width: 12px;">${parseFloat(parseFloat(data.legal_research_fund ?? 0)).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                        <td class="cell" style="border: 1px solid black; width: 12px;">${parseFloat(parseFloat(data.document_stamp_tax ?? 0)).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                        <td class="cell" style="border: 1px solid black; width: 10px; height: 50px;vertical-align: bottom;">${parseFloat(parseFloat(data.fees_pcab ?? 0) + parseFloat(data.legal_research_fund ?? 0) + parseFloat(data.document_stamp_tax ?? 0)).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                    </tr>`;
            });

            rowsPerPageHtml += `</tbody>`;

            // Add the footer only on the last page
            if (i === Math.ceil(filteredData.length / 21) - 1) {
                rowsPerPageHtml += `
                        <tfoot>
                            <tr>
                                <td style="border: 1px solid black;"></td>
                                <td style="border: 1px solid black;"></td>
                                <td style="border: 1px solid black;"></td>
                                <td style="border: 1px solid black;">Total :</td>
                                <td style="border: 1px solid black;">${totalCIAPPCAB.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                                <td style="border: 1px solid black;">${totalLRF.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                                <td style="border: 1px solid black;">${totalDST.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                                <td style="border: 1px solid black;">${totalCollection.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                            </tr>
                        </tfoot>`;
            }

            rowsPerPageHtml += `</table>
            </div>
            </div>`;

            // Add a page break if there are more rows to be processed
            if (filteredData.length - ((i + 1) * 38) > 0) {
                rowsPerPageHtml += `<div style="page-break-before: always; word-wrap: break-word; overflow-wrap: break-word;"></div>`;
            }

            i++;
        }

        // Generate header and footer content
        const header = `<div class="mx-auto d-flex flex-column border-dark" style="width:70rem;height:5rem;">
            <div class="d-flex align-items-center justify-content-center" style="height: 250px;">
                <div class="row justify-content-center mb-2">
                    <div class="col-md-3">
                        <img  height="100px" style="margin-left:-1rem;" src="assets/images/ngsi-letterhead.png" alt="logo" class="logo-dark" />
                    </div>
                    <div class="col-md-4 mt-3"  style="margin-left:11rem;">
                        <p class="font-weight-bold" style="font-family: Century Gothic; font-size:16px;">NET GLOBAL SOLUTIONS&nbsp;&nbsp; INC.</p>
                        <p style="margin-top: -20px;margin-bottom: -5px; font-family: Century Gothic;">Tel. No. 632 82877374</p>
                        <p style=" line-height: 80%; color:blue;margin-top: 10px;">Support@netglobalsolutions.net</p>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-center" style="height: 250px;">
                <img width="100%" height="6px" style="margin-top: -10px; margin-left:30px; margin-right:30px;" src="assets/images/NGSI_header.png" alt="logo" class="logo-dark" />
            </div>
            <div class="d-flex align-items-center justify-content-center" style="height: 250px;">
                <div class="text-center text-uppercase py-3">
                    <p class="font-weight-bold" style="color:black;">LIST &nbsp;OF &nbsp;DAILY &nbsp;COLLECTION<p>
                    <p style="color:black;margin-top:-20px;">Agency : &nbsp;CONSTRUCTION &nbsp INDUSTRY &nbsp; OF &nbsp; THE &nbsp;PHILIPPINES<p>
                    <p class="text-justify" style="color:black;margin-top:-20px;">Philippine &nbsp; Contractors &nbsp;&nbsp; Accreditation &nbsp; Board &nbsp;( PCAB )<p>
                    <p class="text-capitalize" style="color:black;margin-top:-20px;">Date : ${pdf_date}<p>
                </div>
            </div>
            <p class="text-right" style="color:black;margin-top:-20px;margin-right:50px;">Report No :${report_number}<p>
            <br>
            </div>`;

        const footer = `<div class="mx-auto d-flex flex-column border-dark" style="width:70rem;height:5rem;margin-top:20px;">
            <div class="d-flex align-items-center justify-content-center" style="height: 250px;">
                <div class="row mt-4" style="margin:50px">
                    <div class="col-sm">
                        <img style="margin-left:25%; background-position:center; margin-bottom:-15px;z-index:0;position:relative;transform:scale(1.1)"width="35%" height="35%" src="assets/images/ma'am_je.png" alt="logo" class="logo-dark" />
                        <p style="position:relative;left:11px;margin:0;margin-top:-80px;">Prepared By: </p>
                        <p style="margin-top:60px;margin-left:155px;font-size: 18px; font-family: Arial, Helvetica, sans-serif;z-index:1;position:relative;">Jeremie Soliveres </p>
                        <p style=" margin-top:-20px; margin-left: 170px; font-family: Arial, Helvetica, sans-serif; font-size: 12px;">Accounting Specialist</p>
                        <p style=" margin-top:-20px; margin-left: 165px; font-family: Arial, Helvetica, sans-serif; font-size: 12px;">Netglobal Solutions, Inc.</p>
                    </div>
                    <div class="col-sm">
                        <img style="margin-left:13rem; margin-bottom:-15px;" width="35%" height="35%" src="assets/images/sir_peter1.png" alt="logo" class="logo-dark" />
                        <p style="position:relative;left:5.7rem;margin:0;margin-top:-80px;">Approved By: </p>
                        <p style="margin-top:60px;margin-left: 13.5rem;font-size: 18px; font-family: Arial, Helvetica, sans-serif;">Mischell A. Fernandez</p>
                        <p style=" margin-top:-20px; margin-left: 233px; font-family: Arial, Helvetica, sans-serif; font-size: 12px;">Admin Officer III /Cashier II</p>
                        <p style=" margin-top:-20px; margin-left: 260px; font-family: Arial, Helvetica, sans-serif; font-size: 12px;">CIAP - PCAB</p>
                    </div>
                </div>
            </div>
            </div>`;

        doc.html(header + rowsPerPageHtml + footer, {
            html2canvas: {
                scale: .40
            },
            async callback(pdf) {
                const totalPages = pdf.internal.getNumberOfPages();

                for (let i = 1; i <= totalPages; i++) {
                    pdf.setPage(i);
                    pdf.setFontSize(10);
                    pdf.text(520, 800, `Page ${i} of ${totalPages}`);
                }

                const date = new Date();
                await pdf.save(`list_of_colletion-${date.toLocaleDateString()}.pdf`);
            },
        });
    }

    async function printRow(trans_id) {
        const rowData = _jsonData.find(obj => obj.trans_id == trans_id);
        let doc = new jspdf.jsPDF({
            orientation: 'p',
            unit: 'px'
        });

        // Set agency name directly to "CIAP - PCAB"
        let agencyName = "CIAP - PCAB";
        const totalAmount = parseFloat(rowData.fees_pcab) +
            parseFloat(rowData.legal_research_fund) +
            parseFloat(rowData.document_stamp_tax) +
            parseFloat(rowData.ngsi_convenience_fee);

        const Amount = parseFloat(rowData.fees_pcab) +
            parseFloat(rowData.legal_research_fund) +
            parseFloat(rowData.document_stamp_tax);


        let content = `
  
    <div class="mx-auto my-5" style="width: 50rem; ">
                <div class="container mt-3 justify-content-center mb-4">
                        <div class="row justify-content-center mb-2">
                            <div class="col-md-3">
                                <img  height="100px" style="margin-left:-1rem;" src="assets/images/ngsi-letterhead.png" alt="logo" class="logo-dark" />
                            </div>
                            <div class="col-md-4 mt-3"  style="margin-left:11rem;">
                                <p class="font-weight-bold" style="font-family: Century Gothic; font-size:16px;" ;>NET GLOBAL SOLUTIONS&nbsp;&nbsp; INC.</p>
                                <p style="margin-top: -20px;margin-bottom: -5px; font-family: Century Gothic;">Tel. No. 632 82877374</p>
                                <p style=" line-height: 80%; color:blue;margin-top: 10px;">Support@netglobalsolutions.net</p>
                            </div>
                        </div>
                         <img width="100%" height="100%" style="margin-top: -10px;" src="assets/images/NGSI_header.png" alt="logo" class="logo-dark" />
                    </div>
            <div class="border border-dark">    
                <div class="text-center text-uppercase py-3">
                    <u>Acknowledgement &nbsp; Receipt</u>  
                </div>
                <div class="row d-flex">
                    <div class="col"></div>
                    <div class="col">
                        <div class="row d-flex">
                            <div class="col">AR Number: </div>
                            <div class="col">${rowData.ar_no}</div>
                        </div>
                        <div class="row d-flex">
                            <div class="col">Date and Time: </div>
                            <div class="col">${rowData.date_created}</div>
                        </div>
                    </div>
                </div>
                <div class='row pt-4 pb-3'>
                    <div class="col">
                        <div class="row d-flex pl-5">
                            <div class="col text-capitalize ">Agency Name<div class="float-right">  :</div></div>
                            <div class="col">${agencyName}</div>
                        </div>`;


        content += `
    <div class="row d-flex pl-5">
            <div class="col text-capitalize ">Name of Payor<div class="float-right">  :</div></div>
            <div class="col"> ${rowData.name_of_payor}</div>
        </div>
        <div class="row d-flex pl-5">
            <div class="col text-capitalize ">Particular<div class="float-right">  :</div></div>
            <div class="col">PCAB fee</div>
        </div>
        <div class="row d-flex pl-5">
    <div class="col text-capitalize ">Amount<div class="float-right ">:</div></div>
    <div class="col"> ${Amount.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })} </div>
</div>
<div class="row d-flex pl-5">
    <div class="col text-capitalize pl-4">PCAB Fee<div class="float-right pr-2">:</div></div>
    <div class="col"> (${parseFloat(rowData.fees_pcab).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })})</div>
</div>
<div class="row d-flex pl-5">
    <div class="col text-capitalize pl-4">Legal Research Fee<div class="float-right pr-2">:</div></div>
    <div class="col"> (${parseFloat(rowData.legal_research_fund).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })})</div>
</div>
<div class="row d-flex pl-5">
    <div class="col text-capitalize pl-4">Documentary Stamp<div class="float-right pr-2">:</div></div>
    <div class="col"> (${parseFloat(rowData.document_stamp_tax).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })})</div>
</div>
<div class="row d-flex pl-5">
    <div class="col text-capitalize ">NGSI Conveniece fee<div class="float-right">:</div></div>
    <div class="col"> ${parseFloat(rowData.ngsi_convenience_fee).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</div>
</div>
<div class="row d-flex pl-5">
    <div class="col text-capitalize ">Total Amount<div class="float-right ">:</div></div>
    <div class="col"> ${totalAmount.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })} </div>
</div>

        <div class="row d-flex pl-5">
            <div class="col text-capitalize ">Reference Number<div class="float-right">:</div></div>
            <div class="col"> ${rowData.reference_number}</div>
        </div>
    `;

        content += ` 
                    </div>
                </div>
                <div class="row mb-4">
                    <span class="col font-italic font-weight-light">This is a system generated receipt. Signature is not required.</span>
                </div>
            </div>
            <div class="row">
                <div class="col-1">Note:</div>
                <div class="col">
                    <div>This proforma represents minimum data.</div>
                    <div>Moreover, the format may vary depending on the system being used</div>
                </div>
            </div>
        </div>
    `;

        doc.html(content, {
            html2canvas: {
                scale: .5
            },
            callback: async function (doc) {
                const date = new Date();
                await doc.save(`acknowledge-reciept-${date.toLocaleDateString()}.pdf`);


            },
            x: 25,
            y: 10,
        });
    }

    const updateToDepositAmount = ({
        total_pcab_fee,
        total_lrf,
        total_dst,
        total_collection
    }, resetToZero = false) => {
        const fee = latest_deposit_data ? parseFloat(latest_deposit_data.balance_fees_pcab ?? 0) : 0
        const dst = latest_deposit_data ? parseFloat(latest_deposit_data.balance_document_stamp_tax ?? 0) : 0
        const lrf = latest_deposit_data ? parseFloat(latest_deposit_data.balance_legal_research_fund ?? 0) : 0
        const total_collection_bal = fee + dst + lrf
        $("#Submit_deposit span.total-collection").text(`Total: ₱ ${toLocalCurrency((resetToZero ? 0 : parseFloat(total_collection) + total_collection_bal))}`)
        $("#Submit_deposit span.pcab-fee").text(`Total: ₱ ${toLocalCurrency((resetToZero ? 0 : parseFloat(total_pcab_fee)) + fee)}`)
        $("#Submit_deposit span.dst").text(`Total: ₱ ${toLocalCurrency((resetToZero ? 0 : parseFloat(total_dst)) + dst)}`)
        $("#Submit_deposit span.lrf").text(`Total: ₱ ${toLocalCurrency((resetToZero ? 0 : parseFloat(total_lrf)) + lrf)}`)
    }

    const depositTotal = () => {
        let total = 0
        $("#Submit_deposit #amount input").each(function () {
            total += parseFloat(this.value ? this.value.replace(",", "") : 0)
        })
        $("#Submit_deposit .sum-of-deposit p").text(toLocalCurrency(total))
    }

    const shortDateFormat = (date) => {
        if (!date) return "<i>N/A<i>";
        return new Intl.DateTimeFormat('en-US', {
            year: "numeric",
            month: "2-digit",
            day: "2-digit"
        }).format(new Date(date))
    }

    const updateUndepositedTooltip = (data) => {
        const list = {
            "balance_fees_pcab": "Fee",
            "balance_document_stamp_tax": "DST",
            "balance_legal_research_fund": "LRF"
        }
        $("#Submit_deposit label").each(function (key) {
            if (!key) return;
            const prop = Object.keys(list)[key - 1]
            this.children[0].dataset.mdbOriginalTitle = `Undeposited ${list[prop]} of ${shortDateFormat(data.last_deposit_date)}`;
            this.children[0].innerHTML = `(&#8369; ${toLocalCurrency(data[prop])} <i class="icon-info bg-dark text-white rounded-circle"></i>)`;


        })
    }
    let latest_deposit_data = JSON.parse('<?= json_encode($last_deposit) ?>')
    let dbTotalCollection = 0;
    let data;

    $('#Submit_deposit').on("show.bs.modal", function () {
        $('#Daily_CollectionModal .close[data-dismiss=modal').click()
    })

    $("#dateOfDeposit input, #dateRange input").on("click", function () {
        this.showPicker();
    })

    $("#dateRange input").on("input", async function () {
        $("#Submit_deposit .message").text("").removeClass("error", "success");
        const body = {
            collection_date_to: $("input[name='collection_date_to'").val(),
            collection_date_from: $("input[name='collection_date_from'").val()
        }
        updateToDepositAmount({}, true)
        if (new Date(this.value) > new Date((new Date()).getTime() - 86400000)) {
            const _this = this;
            $("#Submit_deposit .message").text(`Date '${this.name.split("_")[2].toUpperCase()}' should not today or further.`).addClass("error");
            setTimeout(function () {
                return _this.parentElement.classList.add("error")
            }, 10);
            updateToDepositAmount({}, true)
            return
        }
        if (new Date(body.collection_date_from) > new Date(body.collection_date_to)) {
            $("#Submit_deposit .message").text("Date 'From' must not greater than 'To'").addClass("error");
            updateToDepositAmount({}, true)
            return;
        }

        // if ((new Date()).getDay() != 1) {
        //     if (this.name == "collection_date_to")
        //         $("input[name='collection_date_from'").val(this.val())
        //     if (this.name == "collection_date_from")
        //         $("input[name='collection_date_to'").val(this.val())
        // } else {
        //     if (new Date(this.value) > new Date((new Date()).getTime() - (86400000 * 3)))
        // }

        let toPopulate = false;
        data = null;
        if (body.collection_date_from && body.collection_date_to)
            try {
                const res = await fetch("/total-txn-amount", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(body)
                }).then(res => res.json())

                if (!res.status)
                    throw res;

                data = res.data;

                if (data && Object.values(data).every(val => val)) {
                    updateToDepositAmount(data)
                    return;
                }
                throw false
            } catch (e) {
                updateToDepositAmount({}, true)
                $("#Submit_deposit .message").text(e ? "Error occured, please try it again by changing date." : "Range has no collection to calculate.").addClass("error");
            }

    })

    $("#dateRange input, #referenceNo input, #dateOfDeposit input, #amount input").on("input", function () {
        if (this.value != "") {
            this.parentElement.classList.add("filled")
            this.parentElement.classList.remove("error")
        } else
            this.parentElement.classList.remove("filled", "error")
    })

    $("#amount input").on("blur", function () {
        const regex = /(?:^[1-9]([0-9]+)?(?:\.[0-9]{1,2})?$)|(?:^(?:0)$)|(\.\d)/
        if (this.value != "") {
            if (!regex.test(this.value))
                this.parentElement.classList.add("error")
            else {
                this.value = toLocalCurrency(this.value.replace(",", ""))
                depositTotal()
            }
        } else {
            this.parentElement.classList.remove("error")
        }
    })
    $("#amount input").on("focus", function () {
        this.value = this.value.replace(',', '')
    })

    $("#cancelDeposit").on("click", async () => {
        $("#Submit_deposit .message").text("").removeClass("success");
        $("#Submit_deposit .filled").removeClass("filled");
        $("#Submit_deposit .error").removeClass("error");
        $("#Submit_deposit input").val("")
        $("#Submit_deposit #dateRange input").val("")
        $("#Submit_deposit").removeClass('loading')
        updateToDepositAmount({}, true)
    })


    let payload = {
        document_stamp_tax: {},
        fees_pcab: {},
        legal_research_fund: {}
    }

    $("#submitDeposit").on("click", (e) => {
        let isInvalid = false
        $("#Submit_deposit input").each(function () {
            let value = this.value

            if (this.name == "deposited_date") {
                value = new Date(this.value) <= new Date() ? this.value : ""
            }

            if (value == "") {
                this.parentElement.classList.add("error")
                isInvalid = true;
                e.preventDefault();
                e.stopPropagation()
                return;
            }
            if (this.name == "amount" || this.name == "reference_no") {
                const mainParent = this.parentElement.parentElement;
                payload[mainParent.id][this.name] = this.name == "amount" ? this.value.replaceAll(",", "") : this.value;
                return;
            }
            payload[this.name] = this.value;
        })
        if (isInvalid) {
            e.preventDefault();
            e.stopPropagation()
            return;
        }

        if (new Date(payload.collection_date_from) > new Date(payload.collection_date_to)) {
            $("[name=collection_date_from]").parent().addClass("error");
            e.preventDefault();
            e.stopPropagation()
            return;
        }

        if ($("#Submit_deposit .settlements .error").length) {
            e.preventDefault();
            e.stopPropagation()
            return;
        }
    })

    $(".proceed-confirmation-btn").on("click", async () => {
        $("#Submit_deposit").addClass('loading')

        try {
            const res = await fetch("/submit-deposit", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(payload)
            }).then(res => res.json())

            if (res.status) {
                $("#Submit_deposit .message").text("Deposit settlement submitted succesfully.").addClass("success");
                setTimeout(() => {
                    $(".modal button[data-dismiss=modal").each(function () {
                        if (this.classList.contains("proceed-confirmation-btn")) return;
                        this.click()
                    })
                    $("#Submit_deposit .message").text("").removeClass("success");
                    $("#Submit_deposit .filled").removeClass("filled");
                    $("#Submit_deposit input").val("")
                    $("#Submit_deposit #dateRange input").val("")
                    $("#Submit_deposit").removeClass('loading')
                    updateToDepositAmount({}, true)
                    updateUndepositedTooltip({
                        ...res.data,
                        last_deposit_date: payload["deposited_date"]
                    })
                }, 1500)
                latest_deposit_data = res.data;
                return;
            }
            throw (res)

        } catch (e) {
            $("#Submit_deposit .message").text(e.message).addClass("error");
            $("#Submit_deposit").removeClass('loading')
        }
    })
</script>