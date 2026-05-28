<?php
/**
 * Acknowledgement Receipt Module - V2 (Refactored)
 * 
 * Architecture:
 * - Clean separation of concerns
 * - External CSS and JavaScript imports
 * - Improved HTML structure and semantics
 * - API-driven data fetching
 * - Modular component design
 * 
 * Last Updated: 2026-05-18
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acknowledgement Receipt</title>
    
    <!-- External CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/acknowledgement-receipt.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/main.css'); ?>">
</head>
<body>
    <!-- Main Content Container -->
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card m-0" id="toPrint">
            <div class="card py-2 px-1">
                
                <!-- Button Section: Filters and Actions -->
                <div class="row btn-generate-container">
                    <div class="col row py-2 d-flex">
                        
                        <!-- Date Filter Form -->
                        <form class="row form-group" id="acknowledgementReceiptFilter" method="get" action="" style="margin-left: 1.5rem;">
                            <label for="startDate" class="date-label">Start Date:</label>
                            <div class="input-group date date-input-group" id="startDatePicker">
                                <input type="text" 
                                       class="form-control" 
                                       name="startDate" 
                                       id="startDate"
                                       readonly
                                       placeholder="mm/dd/yyyy"
                                       value="<?php echo isset($selectedStartDate) ? htmlspecialchars($selectedStartDate) : ''; ?>">
                            </div>

                            <label for="endDate" class="date-label">End Date:</label>
                            <div class="input-group date date-input-group" id="endDatePicker">
                                <input type="text" 
                                       class="form-control" 
                                       name="endDate" 
                                       id="endDate"
                                       readonly
                                       placeholder="mm/dd/yyyy"
                                       value="<?php echo isset($selectedEndDate) ? htmlspecialchars($selectedEndDate) : ''; ?>">
                            </div>
                        </form>

                        <div class="collection-button-container">
                            <!-- Daily Collection Button -->
                            <div class="">
                            <button class="btn-lg btn-outline-dark rounded border-0"
                                    id="dailyCollectionBtn" 
                                    data-toggle="modal"
                                    data-target="#Daily_CollectionModal"
                                    aria-label="Open Daily Collection modal">
                                Daily Collection
                            </button>
                            
                            <!-- Daily Collection Modal -->
                            <div class="modal fade" id="Daily_CollectionModal" tabindex="-1" role="dialog" aria-labelledby="Daily_CollectionModalLabel">
                                <div class="modal-dialog modal-sm" role="document">
                                    <div id="DailyCollectModal" class="modal-content bg-white">
                                        <div class="modal-header py-2">
                                            <h5 class="modal-title" id="Daily_CollectionModalLabel">Daily Collection Report</h5>
                                            <button type="button" class="close text-right pr-4 text-dark" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body bg-white py-3">
                                            <form class="form-group" style="display: flex !important; flex-wrap: wrap !important; margin-bottom: 0 !important;">
                                                <label for="modal_start_date" class="pb-2 pt-3">Start Date:</label>
                                                <input type="text" 
                                                       class="form-control" 
                                                       name="modal_start_date" 
                                                       id="modal_start_date"
                                                       placeholder="yyyy-mm-dd"
                                                       readonly>
                                                
                                                <label for="modal_end_date" class="pb-2 pt-3">End Date:</label>
                                                <input type="text" 
                                                       class="form-control" 
                                                       name="modal_end_date" 
                                                       id="modal_end_date"
                                                       placeholder="yyyy-mm-dd"
                                                       readonly>
                                            </form>
                                            <div id="validationMessage" role="alert"></div>
                                        </div>
                                        <div id="modalDataTableContainer" class="scrollable-container mx-3" style="background-color: #fff;"></div>
                                        <div class="modal-footer bg-white border-top py-2 px-4 d-flex flex-wrap justify-content-center">
                                            <button type="button" 
                                                    class="btn-sm border-0 m-0 rounded btn-generate-container preview-btn-modal mb-2 w-100">
                                                Preview
                                            </button>
                                            <button type="button" 
                                                    class="btn-sm border-0 m-0 rounded btn-generate-container download-btn-modal mb-2 w-100">
                                                Download
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>

                            <!-- E-Collection Button -->
                            <div class="">
                            <button class="btn-lg btn-outline-dark rounded border-0"
                                    id="eCollectionBtn" 
                                    data-toggle="modal"
                                    data-target="#exportModal"
                                    aria-label="Open E-Collection modal">
                                E-Collection
                            </button>
                            
                            <!-- E-Collection Modal -->
                            <div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content bg-white">
                                        <div class="modal-header py-2">
                                            <h5 class="modal-title" id="exportModalLabel">E-Collection Report</h5>
                                            <button type="button" class="close text-right pr-4 text-dark" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body bg-white py-3">
                                            <form class="form-group">
                                                <label for="e-collection_start_date" class="pb-2 pt-3 mr-2">Start Date:</label>
                                                <input type="text" 
                                                       class="form-control mr-2"
                                                       style="max-width: 12rem;" 
                                                       name="e-collection_start_date" 
                                                       id="e-collection_start_date"
                                                       placeholder="mm-dd-yyyy"
                                                       readonly>
                                                
                                                <label for="e-collection_end_date" class="pb-2 pt-3 mr-2">End Date:</label>
                                                <input type="text" 
                                                       class="form-control mr-2"
                                                       style="max-width: 12rem;"
                                                       name="e-collection_end_date" 
                                                       id="e-collection_end_date"
                                                       placeholder="mm-dd-yyyy"
                                                       readonly>
                                            </form>
                                        </div>
                                        <div class="scrollable-container mx-3 bg-white">
                                            <table id="EcollectTable" class="table table-striped text-center" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>Date Created</th>
                                                        <th>Date</th>
                                                        <th>Time</th>
                                                        <th>AR Number</th>
                                                        <th>Name of Payor</th>
                                                        <th>Particular</th>
                                                        <th>Total Amount</th>
                                                        <th>PCAB Fee</th>
                                                        <th>DST</th>
                                                        <th>LRF</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Data Table -->
                <div class="scrollable-container" style="padding-right: 1.5rem;">
                    <table id="myTable" class="table table-striped text-center" width="100%">
                        <thead>
                            <tr>
                                <th class="font-weight-bold">Txn. ID</th>
                                <th class="text-center">Date Created<i class="m-0">(mm/dd/yyyy)</i></th>
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
                        <tbody></tbody>
                    </table>
                </div>

                <!-- Divider -->
                <div class='row divider'>
                    <div class='col-12 my-5 py-2 border'></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts: External Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <!-- Scripts: Configuration -->
    <script>
        /**
         * Global configuration for the acknowledgement receipt module
         * These values are injected from the backend
         */
        window.config = {
            siteUrl: '<?= site_url() ?>',
            baseUrl: '<?= base_url() ?>',
            lastDepositDate: '<?= isset($last_deposit_date) ? $last_deposit_date : "N/A" ?>',
            lastDepositBalance: <?= isset($last_deposit) ? json_encode($last_deposit) : '{}' ?>
        };

        // Set site URL for API calls (for backwards compatibility with JS module)
        window.siteUrl = window.config.siteUrl;
    </script>

    <!-- Scripts: Module -->
    <script src="<?= base_url('assets/js/acknowledgement-receipt.js'); ?>"></script>
</body>
</html>
