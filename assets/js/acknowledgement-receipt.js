/**
 * Architecture:
 * - Utility functions for date formatting and validation
 * - Data fetching abstraction
 * - Event handlers and UI interactions
 * - PDF generation logic
 */

// ===========================
// UTILITY FUNCTIONS
// ===========================

/**
 * Format utility functions
 */
const DateFormatter = {
    /**
     * Format date and time together
     * @param {string|Date} value - Date value
     * @returns {string} Formatted as mm/dd/yyyy hh:mm:ss
     */
    formatDateTime: function(value) {
        if (!value) return '';
        const date = new Date(value);
        if (isNaN(date.getTime())) return value;
        return (
            ('0' + (date.getMonth() + 1)).slice(-2) + '/' +
            ('0' + date.getDate()).slice(-2) + '/' +
            date.getFullYear() + ' ' +
            ('0' + date.getHours()).slice(-2) + ':' +
            ('0' + date.getMinutes()).slice(-2) + ':' +
            ('0' + date.getSeconds()).slice(-2)
        );
    },

    /**
     * Format date only
     * @param {string|Date} value - Date value
     * @returns {string} Formatted as mm/dd/yyyy
     */
    formatDate: function(value) {
        if (!value) return '';
        const date = new Date(value);
        if (isNaN(date.getTime())) return value;
        return (
            ('0' + (date.getMonth() + 1)).slice(-2) + '/' +
            ('0' + date.getDate()).slice(-2) + '/' +
            date.getFullYear()
        );
    },

    /**
     * Format time only
     * @param {string|Date} value - Date value
     * @returns {string} Formatted as hh:mm:ss
     */
    formatTime: function(value) {
        if (!value) return '';
        const date = new Date(value);
        if (isNaN(date.getTime())) return '';
        return (
            ('0' + date.getHours()).slice(-2) + ':' +
            ('0' + date.getMinutes()).slice(-2) + ':' +
            ('0' + date.getSeconds()).slice(-2)
        );
    }
};

/**
 * Currency formatting utility
 */
const CurrencyFormatter = {
    /**
     * Format number as currency
     * @param {number} value - Numeric value
     * @returns {string} Formatted as ₱ x,xxx.xx
     */
    format: function(value) {
        const num = parseFloat(value);
        if (isNaN(num)) return '₱ 0.00';
        return '₱ ' + num.toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    },

    /**
     * Format number without currency symbol
     * @param {number} value - Numeric value
     * @returns {string} Formatted as x,xxx.xx
     */
    formatPlain: function(value) {
        const num = parseFloat(value);
        if (isNaN(num)) return '0.00';
        return num.toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }
};

/**
 * Date conversion utility for API compatibility
 */
const DateConverter = {
    /**
     * Normalize date string to mm/dd/yyyy format for API
     * Handles multiple input formats:
     * - yyyy-mm-dd (HTML5 date input)
     * - mm-dd-yyyy (datepicker)
     * - mm/dd/yyyy (already correct)
     * 
     * @param {string} dateString - Date string to normalize
     * @returns {string} Date in mm/dd/yyyy format
     */
    normalizeDateForApi: function(dateString) {
        if (!dateString) return '';

        // yyyy-mm-dd -> mm/dd/yyyy
        if (/^\d{4}-\d{2}-\d{2}$/.test(dateString)) {
            const parts = dateString.split('-');
            return `${parts[1]}/${parts[2]}/${parts[0]}`;
        }

        // mm-dd-yyyy -> mm/dd/yyyy
        if (/^\d{2}-\d{2}-\d{4}$/.test(dateString)) {
            return dateString.replace(/-/g, '/');
        }

        // Already mm/dd/yyyy or other format
        return dateString;
    },

    /**
     * Get current date in mm/dd/yyyy format
     * @returns {string} Today's date
     */
    getCurrentDate: function() {
        const today = new Date();
        const year = today.getFullYear();
        const month = (today.getMonth() + 1).toString().padStart(2, '0');
        const day = today.getDate().toString().padStart(2, '0');
        return `${month}/${day}/${year}`;
    }
};

/**
 * Validation utility functions
 */
const ValidationHelper = {
    /**
     * Validate that both dates are selected
     * @param {string} startDate - Start date value
     * @param {string} endDate - End date value
     * @returns {boolean} True if both dates are selected
     */
    areBothDatesSelected: function(startDate, endDate) {
        const startValue = startDate.trim();
        const endValue = endDate.trim();
        return (startValue && endValue) || (!startValue && !endValue);
    }
};

// ===========================
// DATA FETCHING ABSTRACTION
// ===========================

/**
 * API Service for transaction data
 */
const TransactionAPI = {
    /**
     * Fetch transactions by date range
     * @param {string} startDate - Start date (mm/dd/yyyy)
     * @param {string} endDate - End date (mm/dd/yyyy)
     * @returns {Promise} jQuery AJAX promise
     */
    getTransactionsByDateRange: function(startDate, endDate) {
        return $.ajax({
            url: `${window.siteUrl}get-transactions-by-date`,
            type: 'GET',
            dataType: 'json',
            data: {
                startDate: startDate,
                endDate: endDate
            }
        });
    },

    /**
     * Fetch single transaction by ID
     * @param {number} transId - Transaction ID
     * @returns {Promise} jQuery AJAX promise
     */
    getTransactionById: function(transId) {
        return $.ajax({
            url: `${window.siteUrl}get-transaction`,
            type: 'GET',
            dataType: 'json',
            data: { trans_id: transId }
        });
    }
};

// ===========================
// MAIN TABLE INITIALIZATION
// ===========================

/**
 * Initialize main acknowledgement receipt table
 */
function initializeMainTable() {
    const $startDate = $('#startDate');
    const $endDate = $('#endDate');

    // Set default dates if not already populated
    if (!$startDate.val()) {
        $startDate.val(DateConverter.getCurrentDate());
    }
    if (!$endDate.val()) {
        $endDate.val(DateConverter.getCurrentDate());
    }

    // Initialize datepickers
    $startDate.add($endDate).datepicker({
        format: 'mm/dd/yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
        orientation: 'bottom'
    });

    // Initialize DataTable
    let tableInstance = null;

    function loadTableData() {
        const startDate = $startDate.val();
        const endDate = $endDate.val();

        if (!startDate || !endDate) return;

        // Destroy existing table if present
        if (tableInstance && $.fn.dataTable.isDataTable('#myTable')) {
            tableInstance.destroy();
            $('#myTable tbody').empty();
        }

        TransactionAPI.getTransactionsByDateRange(startDate, endDate)
            .done(function(response) {
                const tableData = response.data || [];
                
                tableInstance = $('#myTable').DataTable({
                    dom: 'Bfrtip',
                    scrollX: '100%',
                    scrollCollapse: true,
                    ordering: false,
                    paging: true,
                    info: true,
                    processing: false,
                    serverSide: false,
                    pageLength: 10,
                    lengthChange: false,
                    data: tableData,
                    columns: [
                        { data: 'trans_id' },
                        { data: 'date_created', render: DateFormatter.formatDateTime },
                        { data: 'last_modified', render: DateFormatter.formatDate },
                        { data: 'last_modified', render: DateFormatter.formatTime },
                        { data: 'reference_number' },
                        { data: 'name_of_payor' },
                        { data: 'particulars' },
                        { data: 'status' },
                        { data: 'fees_pcab', className: 'text-right', render: CurrencyFormatter.format },
                        { data: 'legal_research_fund', className: 'text-right', render: CurrencyFormatter.format },
                        { data: 'document_stamp_tax', className: 'text-right', render: CurrencyFormatter.format },
                        { data: 'ngsi_convenience_fee', className: 'text-right', render: CurrencyFormatter.format },
                        {
                            data: null,
                            className: 'text-right',
                            render: function(data, type, row) {
                                const total = (parseFloat(row.fees_pcab) || 0) +
                                    (parseFloat(row.document_stamp_tax) || 0) +
                                    (parseFloat(row.legal_research_fund) || 0) +
                                    (parseFloat(row.ngsi_convenience_fee) || 0);
                                return CurrencyFormatter.format(total);
                            }
                        },
                        {
                            data: 'trans_id',
                            orderable: false,
                            searchable: false,
                            render: function(data) {
                                return `<button type="button" style="width: 80px; height: 25px; background: #555;" 
                                            class="btn-outline-dark border-0 btn-print-receipt" 
                                            onclick="handlePrintReceipt(${data})">Download</button>`;
                            }
                        }
                    ],
                    language: {
                        zeroRecords: 'No data available',
                        infoEmpty: 'Showing 0 to 0 of 0 entries'
                    },
                    drawCallback: function(settings) {
                        const wrapper = $(settings.nTableWrapper);
                        wrapper.find('.dataTables_paginate').css('visibility', 'visible');
                        
                        // Add search icon button beside DataTables search box
                        const filterWrapper = wrapper.find('.dataTables_filter');
                        if (filterWrapper.length && !filterWrapper.find('#tableSearchIconBtn').length) {
                            const searchInput = filterWrapper.find('input');
                            searchInput.off('keyup').on('keyup', function(e) {
                                // Prevent automatic search on typing
                                e.preventDefault();
                            });
                            filterWrapper.append('<button type="button" id="tableSearchIconBtn" class="btn-search-icon" title="Search"><i class="icon-magnifier"></i></button>');
                            
                            // Handle search button click
                            filterWrapper.find('#tableSearchIconBtn').off('click').on('click', function() {
                                const searchValue = searchInput.val();
                                tableInstance.search(searchValue).draw();
                            });
                        }
                    },
                    buttons: [{
                        extend: 'excelHtml5',
                        text: 'Export',
                        filename: 'ACKNOWLEDGEMENT-RECEIPT_Table',
                        autoWidth: false,
                        header: true,
                        footer: true,
                        className: 'export-btn',
                        action: function (e, dt, node, config) {
                            if (dt.rows().count() === 0) {
                                alert("No data found for selected dates.");
                                return;
                            }
                            $.fn.dataTable.ext.buttons.excelHtml5.action.call(this, e, dt, node, config);
                        },
                        exportOptions: {
                            columns: ':not(:last-child)',
                            format: {
                                body: function(data, row, column, node) {
                                    if (column >= 7 && column <= 11) {
                                        return data.replace(/₱/g, '');
                                    }
                                    return data;
                                }
                            }
                        }
                    }]
                });
            })
            .fail(function() {
                console.error('Error loading table data');
                if (tableInstance && $.fn.dataTable.isDataTable('#myTable')) {
                    tableInstance.destroy();
                }
            });
    }

    // Load initial data
    loadTableData();

    // Handle date change - reload table with validation
    $startDate.add($endDate).on('change', function() {
        if (ValidationHelper.areBothDatesSelected($startDate.val(), $endDate.val())) {
            loadTableData();
        }
    });
}

// ===========================
// DAILY COLLECTION MODAL
// ===========================

/**
 * Initialize Daily Collection modal
 */
function initializeDailyCollectionModal() {
    const $modal = $('#Daily_CollectionModal');
    const $startDateInput = $('#modal_start_date');
    const $endDateInput = $('#modal_end_date');
    const $validationMessage = $('#validationMessage');
    const $modalDataTableContainer = $('#modalDataTableContainer');

    // Initialize datepickers
    $startDateInput.add($endDateInput).datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
        orientation: 'bottom'
    });

    // Preview button handler
    $('.preview-btn-modal').on('click', function() {
        handleDailyCollectionPreview($startDateInput, $endDateInput, $validationMessage, $modalDataTableContainer, $modal);
    });

    // Download button handler
    $('.download-btn-modal').on('click', function() {
        handleDailyCollectionDownload($startDateInput, $endDateInput, $validationMessage);
    });

    // Clear modal on close
    $modal.on('hidden.bs.modal', function() {
        $startDateInput.val('');
        $endDateInput.val('');
        $validationMessage.empty();
        $modalDataTableContainer.empty();
        $(this).attr("role", "dialog");
        $(".modal-dialog", this).removeClass("modal-lg").addClass("modal-sm");
        $('#Daily_CollectionModal .form-group').css('flex-wrap', 'wrap').children().removeClass('mr-2');
        $('#Daily_CollectionModal .form-group .form-control').css('max-width', '');
        $('#Daily_CollectionModal .modal-footer').addClass('flex-wrap').children().removeClass('mr-2').addClass('w-100');
    });

    // Clear validation message on date change
    $startDateInput.add($endDateInput).on("change", function() {
        $validationMessage.empty();
    });
}

/**
 * Handle Daily Collection preview
 */
function handleDailyCollectionPreview(startDateInput, endDateInput, validationMessage, tableContainer, modal) {
    const startDate = startDateInput.val();
    const endDate = endDateInput.val();

    if (!startDate || !endDate) {
        validationMessage.html(
            '<span style="font-size:.8rem; color: red; text-align:center;" role="alert">' +
            'Please select both start and end dates.</span>'
        );
        return;
    }

    validationMessage.empty();

    const startDateFormatted = DateConverter.normalizeDateForApi(startDate);
    const endDateFormatted = DateConverter.normalizeDateForApi(endDate);

    TransactionAPI.getTransactionsByDateRange(startDateFormatted, endDateFormatted)
        .done(function(response) {
            const filteredData = response.data || [];
            populateDailyCollectionTable(filteredData, validationMessage, modal);
        })
        .fail(function() {
            validationMessage.html(
                '<span style="font-size:.8rem; color: red; text-align:center;" role="alert">' +
                'Error fetching data. Please try again.</span>'
            );
        });
}

/**
 * Populate Daily Collection table with data
 */
function populateDailyCollectionTable(data, validationMessage, modal) {
    if (!data || data.length === 0) {
        validationMessage.html(
            '<span style="font-size:.8rem; color: red; text-align:center;" role="alert">' +
            'No data found for the selected date range.</span>'
        );
        return;
    }

    validationMessage.empty();

    const tableContainer = $('#modalDataTableContainer');
    
    // Destroy existing DataTable if present
    if ($.fn.dataTable.isDataTable('#modalDataTable')) {
        $('#modalDataTable').DataTable().destroy();
    }
    
    // Clear the container
    tableContainer.empty();

    // Create table structure
    const table = document.createElement('table');
    table.id = 'modalDataTable';
    table.className = 'table table-bordered table-hover table-striped';
    table.style.overflow = 'hidden';

    // Table header
    const thead = document.createElement('thead');
    thead.className = 'thead';
    thead.innerHTML = `
        <tr><th colspan="9" class="text-center">Collection</th></tr>
        <tr>
            <th style="width:${100 / 9}%;" rowspan="2">Date & Time</th>
            <th style="width:${100 / 9}%;" rowspan="2">Date Created & Time</th>
            <th style="width:${100 / 9}%;" rowspan="2">AR Number</th>
            <th style="width:${100 / 9}%;" rowspan="2">Name of Payor</th>
            <th style="width:${100 / 9}%;" rowspan="2">Reference Number</th>
            <th style="width:${100 / 9}%;">CIAP-PCAB</th>
            <th style="width:${100 / 9}%;">LRF</th>
            <th style="width:${100 / 9}%;">DST</th>
            <th style="width:${100 / 9}%;" rowspan="2">Total Collection</th>
        </tr>
        <tr>
            <th>Account No.<br/>(0052-1684-30)</th>
            <th>Account No.<br/>(3402-2866-19)</th>
            <th>Account No.<br/>(3402-2866-00)</th>
        </tr>
    `;

    // Table body
    const tbody = document.createElement('tbody');
    const formatter = new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });

    data.forEach((row) => {
        const ciapPcab = parseFloat(row.fees_pcab || 0);
        const lrf = parseFloat(row.legal_research_fund || 0);
        const dst = parseFloat(row.document_stamp_tax || 0);
        const total = ciapPcab + lrf + dst;

        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="text-left" style="width:${100 / 9}%;padding-left:18px;">${row.last_modified || ''}</td>
            <td class="text-left" style="width:${100 / 9}%;padding-left:18px;">${row.date_created || ''}</td>
            <td class="text-center" style="width:${100 / 9}%;padding-left:18px;">${row.ar_no || ''}</td>
            <td style="width:${100 / 9}%;padding-left:18px; text-wrap: wrap;">${row.name_of_payor || ''}</td>
            <td style="width:${100 / 9}%;padding-left:18px;">${row.reference_number || ''}</td>
            <td class="text-right" style="width:${100 / 9}%;">${formatter.format(ciapPcab)}</td>
            <td class="text-right" style="width:${100 / 9}%;">${formatter.format(lrf)}</td>
            <td class="text-right" style="width:${100 / 9}%;">${formatter.format(dst)}</td>
            <td class="text-right">${formatter.format(total)}</td>
        `;
        tbody.appendChild(tr);
    });

    table.appendChild(thead);
    table.appendChild(tbody);
    tableContainer.append(table);

    // Initialize DataTable
    const modalTableInstance = $('#modalDataTable').DataTable({
        dom: 'frtip',
        scrollX: '100%',
        scrollCollapse: true,
        ordering: false,
        paging: true,
        pageLength: 10,
        drawCallback: function(settings) {
            // Add search icon button beside DataTables search box
            const wrapper = $(settings.nTableWrapper);
            const filterWrapper = wrapper.find('.dataTables_filter');
            if (filterWrapper.length && !filterWrapper.find('#dailyCollectionSearchBtn').length) {
                const searchInput = filterWrapper.find('input');
                searchInput.off('keyup').on('keyup', function(e) {
                    // Prevent automatic search on typing
                    e.preventDefault();
                });
                    filterWrapper.append('<button type="button" id="dailyCollectionSearchBtn" class="btn-search-icon" title="Search"><i class="icon-magnifier"></i></button>');
        }
    }});

    // Adjust modal size
    const modalDialog = $('#Daily_CollectionModal .modal-dialog');
    const modalDateContainer = $('#Daily_CollectionModal .form-group');
    const modalFooterBtnContainer = $('#Daily_CollectionModal .modal-footer');
    if (!modalDialog.hasClass('modal-lg')) {
        modalDialog.removeClass('modal-sm').addClass('modal-lg');
        modalDialog.css('transition', 'width 0.5s ease-in-out');
        // Remove flex-wrap from #DailyCollectModal form-group
        modalDateContainer.css('flex-wrap', 'nowrap').children().not(':last').addClass('mr-2');
        $('#Daily_CollectionModal .form-group .form-control').css('max-width', '200px');
        // Remove flex-wrap from modal-footer
        modalFooterBtnContainer.removeClass('flex-wrap justify-content-center').addClass('justify-content-end').children().removeClass('w-100').not(':last').addClass('mr-2');
    }
}

/**
 * Handle Daily Collection download
 */
function handleDailyCollectionDownload(startDateInput, endDateInput, validationMessage) {
    const startDate = startDateInput.val();
    const endDate = endDateInput.val();

    if (!startDate || !endDate) {
        validationMessage.html(
            '<span style="font-size:.8rem; color: red; text-align:center;" role="alert">' +
            'Please select both start and end dates.</span>'
        );
        return;
    }

    validationMessage.empty();

    const startDateFormatted = DateConverter.normalizeDateForApi(startDate);
    const endDateFormatted = DateConverter.normalizeDateForApi(endDate);

    generatePdfReport(startDateFormatted, endDateFormatted);
}

// ===========================
// E-COLLECTION MODAL
// ===========================

/**
 * Initialize E-Collection modal
 */
function initializeECollectionModal() {
    const $modal = $('#exportModal');
    let ecollectionDataTable = null;

    // Initialize datepickers
    $('#e-collection_start_date, #e-collection_end_date').datepicker({
        format: 'mm-dd-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
        orientation: 'bottom'
    });

    // Initialize DataTable on modal open
    $modal.one('shown.bs.modal', function() {
        if (!$.fn.dataTable.isDataTable('#EcollectTable')) {
            ecollectionDataTable = initializeECollectionDataTable();
        }
    });

    // Handle date changes
    $('#e-collection_start_date, #e-collection_end_date').on('input change changeDate', function() {
        if (!ecollectionDataTable) return;

        const startDate = $('#e-collection_start_date').val();
        const endDate = $('#e-collection_end_date').val();

        ecollectionDataTable.clear().draw();

        if (startDate && endDate) {
            const startDateFormatted = DateConverter.normalizeDateForApi(startDate);
            const endDateFormatted = DateConverter.normalizeDateForApi(endDate);

            TransactionAPI.getTransactionsByDateRange(startDateFormatted, endDateFormatted)
                .done(function(response) {
                    populateECollectionTable(ecollectionDataTable, response.data || []);
                })
                .fail(function() {
                    populateECollectionTable(ecollectionDataTable, []);
                });
        }
    });
}

/**
 * Initialize E-Collection DataTable
 */
function initializeECollectionDataTable() {
    const today = new Date();
    const dateString = today.getFullYear() + '-' +
        (today.getMonth() + 1).toString().padStart(2, '0') + '-' +
        today.getDate().toString().padStart(2, '0');
    const filename = 'NGSI_E-Collection_' + dateString;

    const eCollectionTable = $('#EcollectTable').DataTable({
        dom: 'Bfrtip',
        scrollX: '100%',
        scrollCollapse: true,
        drawCallback: function(settings) {
            // Add search icon button beside DataTables search box
            const wrapper = $(settings.nTableWrapper);
            const filterWrapper = wrapper.find('.dataTables_filter');
            if (filterWrapper.length && !filterWrapper.find('#eCollectionSearchBtn').length) {
                const searchInput = filterWrapper.find('input');
                searchInput.off('keyup').on('keyup', function(e) {
                    // Prevent automatic search on typing
                    e.preventDefault();
                });
                filterWrapper.append('<button type="button" id="eCollectionSearchBtn" class="btn-search-icon" title="Search"><i class="icon-magnifier"></i></button>');
                
                // Handle search button click
                filterWrapper.find('#eCollectionSearchBtn').off('click').on('click', function() {
                    const searchValue = searchInput.val();
                    eCollectionTable.search(searchValue).draw();
                });
            }
        },
        buttons: [{
            extend: 'excelHtml5',
            text: 'Export',
            filename: filename,
            autoWidth: true,
            header: true,
            footer: true,
            title: "Electronic Collection",
            className: 'export-btn',
            action: function (e, dt, node, config) {
                if (dt.rows().count() === 0) {
                    alert("No data found for selected dates.");
                    return;
                }
                $.fn.dataTable.ext.buttons.excelHtml5.action.call(this, e, dt, node, config);
            },
            customize: customizeECollectionExport
        }]
    });
    return eCollectionTable;
}

/**
 * Populate E-Collection table
 */
function populateECollectionTable(dataTable, transactionData) {
    if (!Array.isArray(transactionData) || transactionData.length === 0) {
        dataTable.draw();
        return;
    }

    const rowsToAdd = transactionData.map(function(row) {
        const feesPcab = parseFloat(row.fees_pcab ?? 0);
        const lrf = parseFloat(row.legal_research_fund ?? 0);
        const dst = parseFloat(row.document_stamp_tax ?? 0);
        const total = feesPcab + lrf + dst;

        const createdDate = row.date_created ? new Date(row.date_created) : null;
        const lastModifiedDate = row.last_modified ? new Date(row.last_modified) : null;

        return [
            DateFormatter.formatDateTime(createdDate),
            DateFormatter.formatDate(lastModifiedDate),
            lastModifiedDate && !isNaN(lastModifiedDate.getTime()) ?
                String(lastModifiedDate.toTimeString().split(' ')[0]) : '',
            row.ar_no,
            row.name_of_payor,
            row.particulars,
            CurrencyFormatter.format(total),
            CurrencyFormatter.format(feesPcab),
            CurrencyFormatter.format(dst),
            CurrencyFormatter.format(lrf)
        ];
    });

    dataTable.rows.add(rowsToAdd);
    dataTable.draw();
}

/**
 * Customize E-Collection Excel export
 */
function customizeECollectionExport(xlsx) {
    const sheet = xlsx.xl.worksheets['sheet1.xml'];
    const downrows = 2;
    const clRow = $('row', sheet);

    const cToMerge = [
        { start: "A2", to: "B2" },
        { start: "E2", to: "H2" },
        { start: "F3", to: "H3" }
    ];

    const alignText = {
        right: 52,
        center: 51,
        left: 50
    };

    // Adjust row indices
    clRow.each(function() {
        const attr = $(this).attr('r');
        if (attr === 1) return;
        const ind = parseInt(attr) + downrows;
        $(this).attr("r", ind);
    });

    // Adjust cell indices
    $('row c', sheet).each(function() {
        const attr = $(this).attr('r');
        if (attr === "A1") return;
        const pre = attr.substring(0, 1);
        const ind = parseInt(attr.substring(1, attr.length)) + downrows;
        $(this).attr("r", pre + ind);
    });
}

// ===========================
// PDF GENERATION
// ===========================

/**
 * Generate PDF report for Daily Collection
 */
async function generatePdfReport(startDate, endDate) {
    const { jsPDF } = window.jspdf;

    try {
        const response = await TransactionAPI.getTransactionsByDateRange(startDate, endDate);
        const filteredData = response.data || [];

        if (filteredData.length === 0) {
            alert("No data found for selected dates.");
            return;
        }

        const doc = new jsPDF({ orientation: "p", unit: "pt", format: "a4" });
        const pageWidth = doc.internal.pageSize.getWidth();

        // Add header
        addPdfHeader(doc, pageWidth, filteredData[0]);

        // Prepare table data
        const tableData = preparePdfTableData(filteredData);

        // Generate PDF pages
        generatePdfPages(doc, pageWidth, tableData);

        // Add footer and save
        addPdfFooter(doc, pageWidth);
        const now = new Date();
        doc.save(`list_of_collection_${now.toLocaleDateString()}.pdf`);

    } catch (error) {
        console.error('Error generating PDF:', error);
        alert('Error generating PDF. Please try again.');
    }
}

/**
 * Add PDF header
 */
function addPdfHeader(doc, pageWidth, firstRow) {
    const logo = new Image();
    logo.src = "assets/images/ngsi-letterhead.png";
    doc.addImage(logo, "PNG", 120, 0, 210, 50);

    const textX = 340;
    let textY = 20;

    doc.setFont("helvetica", "bold");
    doc.setFontSize(9);
    doc.text("NET GLOBAL SOLUTIONS INC.", textX, textY);

    doc.setFont("helvetica", "normal");
    doc.setFontSize(8);
    doc.text("Tel. No: (02) - 853 - 50989", textX, textY + 10);
    doc.setTextColor(0, 0, 255);
    doc.text("Support@netglobalsolutions.net", textX, textY + 20);
    doc.setTextColor(0, 0, 0);

    const divider = new Image();
    divider.src = "assets/images/NGSI_header.png";
    doc.addImage(divider, "PNG", 30, 55, pageWidth * 0.9, 4);

    doc.setFont("helvetica", "bold");
    doc.setFontSize(9);
    doc.text("LIST OF DAILY COLLECTION", pageWidth / 2, 80, { align: "center" });

    doc.setFont("helvetica", "normal");
    doc.setFontSize(9);
    doc.text("AGENCY: CONSTRUCTION INDUSTRY AUTHORITY OF THE PHILIPPINES", pageWidth / 2, 90, { align: "center" });
    doc.text("Philippine Contractors Accreditation Board ( PCAB )", pageWidth / 2, 100, { align: "center" });
    
    const pdfDate = firstRow.last_modified ? firstRow.last_modified.split(" ")[0] : '';
    doc.text(`Date : ${pdfDate}`, pageWidth / 2, 110, { align: "center" });

    doc.setFont("helvetica", "normal");
    doc.setFontSize(8);
    doc.text(`Report No : ${firstRow.report_no || ''}`, pageWidth - 30, 125, { align: "right" });
}

/**
 * Prepare table data for PDF
 */
function preparePdfTableData(data) {
    let grandFees = 0, grandLrf = 0, grandDst = 0, grandTotal = 0;

    const tableData = data.map(row => {
        const feesPcab = parseFloat(row.fees_pcab ?? 0);
        const lrf = parseFloat(row.legal_research_fund ?? 0);
        const dst = parseFloat(row.document_stamp_tax ?? 0);
        const total = feesPcab + lrf + dst;

        grandFees += feesPcab;
        grandLrf += lrf;
        grandDst += dst;
        grandTotal += total;

        return [
            row.last_modified ?? "",
            row.reference_number ?? "",
            row.name_of_payor ?? "",
            row.referenceNumber ?? "",
            CurrencyFormatter.formatPlain(feesPcab),
            CurrencyFormatter.formatPlain(lrf),
            CurrencyFormatter.formatPlain(dst),
            CurrencyFormatter.formatPlain(total)
        ];
    });

    return {
        data: tableData,
        totals: {
            fees: grandFees,
            lrf: grandLrf,
            dst: grandDst,
            total: grandTotal
        }
    };
}

/**
 * Generate PDF pages with pagination
 */
function generatePdfPages(doc, pageWidth, tableDataObj) {
    const tableData = tableDataObj.data;
    const totals = tableDataObj.totals;
    const rowsPerPage = 15;

    function chunkArray(array, size) {
        const result = [];
        for (let i = 0; i < array.length; i += size) {
            result.push(array.slice(i, i + size));
        }
        return result;
    }

    const tableChunks = chunkArray(tableData, rowsPerPage);
    let startY = 135;

    tableChunks.forEach((chunk, index) => {
        // Add totals row to last chunk
        if (index === tableChunks.length - 1) {
            chunk.push([
                { content: "TOTAL", colSpan: 4, styles: { halign: "right", fontStyle: "bold" } },
                CurrencyFormatter.formatPlain(totals.fees),
                CurrencyFormatter.formatPlain(totals.lrf),
                CurrencyFormatter.formatPlain(totals.dst),
                CurrencyFormatter.formatPlain(totals.total)
            ]);
        }

        addPdfTable(doc, startY, chunk, pageWidth);

        if (index < tableChunks.length - 1) {
            doc.addPage();
            startY = 60;
        }
    });
}

/**
 * Add table to PDF page
 */
function addPdfTable(doc, startY, chunk, pageWidth) {
    doc.autoTable({
        startY: startY,
        head: [
            [{ content: "Collection", colSpan: 8, styles: { halign: "center", fontStyle: "bold", lineWidth: { bottom: 0, top: 1, left: 1, right: 1 } } }],
            [
                { content: "Date & Time", styles: { cellWidth: 65, halign: "center", valign: "middle", minCellHeight: 15, lineWidth: { bottom: 0, top: 1, left: 1, right: 1 } } },
                { content: "AR Number", styles: { cellWidth: 55, halign: "center", lineWidth: { bottom: 0, top: 1, left: 1, right: 1 } } },
                { content: "Name of Payor", styles: { cellWidth: 115, halign: "center", lineWidth: { bottom: 0, top: 1, left: 1, right: 1 } } },
                { content: "Reference Number", styles: { cellWidth: 85, halign: "center", lineWidth: { bottom: 0, top: 1, left: 1, right: 1 } } },
                { content: "CIAP-PCAB", styles: { cellWidth: 50, halign: "center", lineWidth: { bottom: 1, top: 1, left: 1, right: 1 } } },
                { content: "LRF", styles: { cellWidth: 50, halign: "center", lineWidth: { bottom: 1, top: 1, left: 1, right: 1 } } },
                { content: "DST", styles: { cellWidth: 50, halign: "center", lineWidth: { bottom: 1, top: 1, left: 1, right: 1 } } },
                { content: "Total Collection", styles: { cellWidth: 60, halign: "center", lineWidth: { bottom: 0, top: 1, left: 1, right: 1 } } }
            ],
            [
                { content: "", styles: { cellWidth: 65, lineWidth: { top: 0, bottom: 1, left: 1, right: 1 } } },
                { content: "", styles: { cellWidth: 55, lineWidth: { top: 0, bottom: 1, left: 1, right: 1 } } },
                { content: "", styles: { cellWidth: 115, lineWidth: { top: 0, bottom: 1, left: 1, right: 1 } } },
                { content: "", styles: { cellWidth: 85, lineWidth: { top: 0, bottom: 1, left: 1, right: 1 } } },
                { content: "Account No.\n(0052-1684-30)", styles: { cellWidth: 50, halign: "center", lineWidth: { top: 1, bottom: 1, left: 1, right: 1 } } },
                { content: "Account No.\n(3402-2866-19)", styles: { cellWidth: 50, halign: "center", lineWidth: { top: 1, bottom: 1, left: 1, right: 1 } } },
                { content: "Account No.\n(3402-2866-00)", styles: { cellWidth: 50, halign: "center", lineWidth: { top: 1, bottom: 1, left: 1, right: 1 } } },
                { content: "", styles: { cellWidth: 60, lineWidth: { top: 0, bottom: 1, left: 1, right: 1 } } }
            ]
        ],
        body: chunk,
        theme: "grid",
        tableWidth: 540,
        margin: { left: 40, right: 30 },
        styles: {
            fontSize: 6,
            cellPadding: 3,
            overflow: 'linebreak',
            valign: 'middle',
            lineColor: [0, 0, 0],
            lineWidth: 1,
            minCellHeight: 30
        },
        headStyles: {
            fillColor: [0, 80, 122],
            textColor: [255, 255, 255]
        },
        bodyStyles: {
            textColor: [0, 0, 0]
        },
        alternateRowStyles: {
            fillColor: [189, 232, 255]
        },
        columnStyles: {
            0: { cellWidth: 65 },
            1: { cellWidth: 55 },
            2: { cellWidth: 115 },
            3: { cellWidth: 85 },
            4: { cellWidth: 50, halign: "center" },
            5: { cellWidth: 50, halign: "center" },
            6: { cellWidth: 50, halign: "center" },
            7: { cellWidth: 60, halign: "center" }
        },
        didDrawPage: function() {
            const pageNum = `Page ${doc.internal.getNumberOfPages()}`;
            doc.setFontSize(8);
            doc.text(pageNum, pageWidth - 60, doc.internal.pageSize.getHeight() - 20);
        }
    });
}

/**
 * Add PDF footer with signatures
 */
function addPdfFooter(doc, pageWidth) {
    const footerY = doc.lastAutoTable.finalY + 40;

    doc.addImage("assets/images/ma'am_je.png", "PNG", 110, footerY, 80, 35);
    doc.setFontSize(9);
    doc.text("Prepared By:", 60, footerY + 5);
    doc.setFontSize(10);
    doc.text("Jeremie Soliveres", 150, footerY + 35, { align: "center" });
    doc.setFontSize(7);
    doc.text("Accounting Specialist", 150, footerY + 45, { align: "center" });
    doc.text("Netglobal Solutions, Inc.", 150, footerY + 55, { align: "center" });

    doc.setFontSize(9);
    doc.text("Checked/Verified By:", 290, footerY + 5);
    doc.setFontSize(10);
    doc.text("Mischell A. Fernandez", 450, footerY + 35, { align: "center" });
    doc.setFontSize(7);
    doc.text("Admin Officer III / Cashier II", 450, footerY + 45, { align: "center" });
    doc.text("CIAP - PCAB", 450, footerY + 55, { align: "center" });
}

// ===========================
// RECEIPT PRINTING
// ===========================

/**
 * Handle printing individual receipt
 */
async function handlePrintReceipt(transId) {
    try {
        const response = await TransactionAPI.getTransactionById(transId);

        if (!response.status || !response.data) {
            alert('Unable to load transaction details. Please try again.');
            return;
        }

        await generateReceiptPdf(response.data);

    } catch (error) {
        console.error(error);
        alert('Unable to load transaction details. Please try again.');
    }
}

/**
 * Generate receipt PDF
 */
async function generateReceiptPdf(rowData) {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({ orientation: 'p', unit: 'px' });

    const agencyName = "CIAP - PCAB";
    const totalAmount = parseFloat(rowData.fees_pcab) +
        parseFloat(rowData.legal_research_fund) +
        parseFloat(rowData.document_stamp_tax) +
        parseFloat(rowData.ngsi_convenience_fee);

    const amount = parseFloat(rowData.fees_pcab) +
        parseFloat(rowData.legal_research_fund) +
        parseFloat(rowData.document_stamp_tax);

    const content = buildReceiptContent(rowData, agencyName, totalAmount, amount);

    await new Promise((resolve) => {
        doc.html(content, {
            html2canvas: { scale: 0.5 },
            callback: function(pdf) {
                const date = new Date();
                pdf.save(`acknowledge-receipt-${date.toLocaleDateString()}.pdf`);
                resolve();
            },
            x: 25,
            y: 10
        });
    });
}

/**
 * Build receipt HTML content
 */
function buildReceiptContent(rowData, agencyName, totalAmount, amount) {
    return `
        <div class="mx-auto my-5" style="width: 50rem;">
            <div class="container mt-3 justify-content-center mb-4">
                <div class="row justify-content-center mb-2">
                    <div class="col-md-3">
                        <img height="100px" style="margin-left:-1rem;" src="assets/images/ngsi-letterhead.png" alt="logo" />
                    </div>
                    <div class="col-md-4 mt-3" style="margin-left:11rem;">
                        <p class="font-weight-bold" style="font-family: Century Gothic; font-size:16px;">NET GLOBAL SOLUTIONS&nbsp;&nbsp; INC.</p>
                        <p style="margin-top: -20px;margin-bottom: -5px; font-family: Century Gothic;">Tel. No: (02) - 853 - 50989</p>
                        <p style="line-height: 80%; color:blue;margin-top: 10px;">Support@netglobalsolutions.net</p>
                    </div>
                </div>
                <img width="100%" height="100%" style="margin-top: -10px;" src="assets/images/NGSI_header.png" alt="logo" />
            </div>
            <div class="border border-dark">
                <div class="text-center text-uppercase py-3">
                    <u>Acknowledgement&nbsp;&nbsp;Receipt</u>
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
                <div class="row pt-4 pb-3">
                    <div class="col">
                        <div class="row d-flex pl-5">
                            <div class="col text-capitalize">Agency Name<div class="float-right">:</div></div>
                            <div class="col">${agencyName}</div>
                        </div>
                        <div class="row d-flex pl-5">
                            <div class="col text-capitalize">Name of Payor<div class="float-right">:</div></div>
                            <div class="col col text-wrap text-break" style="letter-spacing: 2px; word-spacing: 10px; word-break: break-word;">
                                ${rowData.name_of_payor}
                            </div>
                        </div>
                        <div class="row d-flex pl-5">
                            <div class="col text-capitalize">Particular<div class="float-right">:</div></div>
                            <div class="col">PCAB&nbsp;&nbsp;Fee</div>
                        </div>
                        <div class="row d-flex pl-5">
                            <div class="col text-capitalize">Amount<div class="float-right">:</div></div>
                            <div class="col">${parseFloat(rowData.amount).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</div>
                        </div>
                        <div class="row d-flex pl-5">
                            <div class="col text-capitalize pl-4">PCAB&nbsp;&nbsp;Fee<div class="float-right pr-2">:</div></div>
                            <div class="col">(${parseFloat(rowData.fees_pcab).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })})</div>
                        </div>
                        <div class="row d-flex pl-5">
                            <div class="col text-capitalize pl-4">Legal Research Fee<div class="float-right pr-2">:</div></div>
                            <div class="col">(${parseFloat(rowData.legal_research_fund).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })})</div>
                        </div>
                        <div class="row d-flex pl-5">
                            <div class="col text-capitalize pl-4">Documentary Stamp<div class="float-right pr-2">:</div></div>
                            <div class="col">(${parseFloat(rowData.document_stamp_tax).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })})</div>
                        </div>
                        <div class="row d-flex pl-5">
                            <div class="col text-capitalize">NGSI Convenience fee<div class="float-right">:</div></div>
                            <div class="col">${parseFloat(rowData.ngsi_convenience_fee).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</div>
                        </div>
                        <div class="row d-flex pl-5">
                            <div class="col text-capitalize">Total Amount<div class="float-right">:</div></div>
                            <div class="col">${totalAmount.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</div>
                        </div>
                        <div class="row d-flex pl-5">
                            <div class="col text-capitalize">Reference Number<div class="float-right">:</div></div>
                            <div class="col">${rowData.reference_number}</div>
                        </div>
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
}

// ===========================
// PAGE INITIALIZATION
// ===========================

/**
 * Initialize all modules on document ready
 */
$(document).ready(function() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Initialize main table
    initializeMainTable();

    // Initialize modals
    initializeDailyCollectionModal();
    initializeECollectionModal();
})
