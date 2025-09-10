<style>
    table,
    th {
        border: 0.5px black solid !important;
        border-width: 0.5px 0 0.5px 0.5px;
        border-collapse: collapse;
    }

    .ecollection-table-container tr th:last-child {
        margin-right: 0.5px;
        border-right: 0.5px black solid;
    }

    button {
        background-color: #00507a;
    }

    /* th:last-child {
        border-right: 1px black solid;
    } */
</style>

<div class="row w-100 mb-5">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body p-1 pt-3">
                <div class="d-sm-flex align-items-center my-4 pl-2">
                    <!-- <h4 class="card-title mb-sm-0">Deposit</h4> -->

                    <!-- <button style="margin-top: -20px;" type="button"
                    class="btn-sm btn-outline-dark border-0 mr-3 mb-2 rounded download-btn-modal">Deposit</button> -->
                </div>


                <table id="myTable" class="text-center ecollection-table-container" width="100%">
                    <thead class="w-100">
                        <tr>
                            <th colspan="2">Undeposited Collection (per last Report)</th>
                            <th colspan="7">Collections</th>
                            <th colspan="3">Deposit / Fund Transfer</th>
                            <th rowspan="2">Undeposited Collection (this Report)</th>
                            <th rowspan="2" style="width: 10rem!important;" class="text-center">Action</th>
                        </tr>
                        <tr>
                            <th>Date & Time</th>
                            <th>Undeposited Amount</th>
                            <th>Date From <i class="m-0">(mm/dd/yyyy)</i></th>
                            <th>Date To <i class="m-0">(mm/dd/yyyy)</i></th>
                            <th>Total No. of Transaction</th>
                            <th>LRF</th>
                            <th>DSF</th>
                            <th>PCAB Fee</th>
                            <th>Total Amt. of Collection</th>
                            <th>Date <i class="m-0">(mm/dd/yyyy)</i></th>
                            <th>Transactions</th>
                            <th>Deposited Amount</th>
                        </tr>
                    </thead>
                    <tbody class="w-100">

                        <?php
                        // $fmt = new NumberFormatter('en-US', NumberFormatter::CURRENCY);
                        // $fmt->setPattern(str_replace('¤#', "\xC2\xA0#", $fmt->getPattern()));

                        if ($data != false)
                            foreach ($data as $key => $row) {
                                $undeposited = (float) $row["legal_research_fund"] +
                                    (float) $row["document_stamp_tax"] +
                                    (float) $row["fees_pcab"];
                                echo "<tr>";
                                echo "<td>" .  date_format(date_create($row["date"]), "m/d/Y H:i:s") . "</td>";
                                echo "<td class='text-right'>&#8369; " . ($row["last_txn_amont"] != "" ? number_format($row["last_txn_amont"], 2, '.', ',')  : "0.00") . "</td>";
                                echo "<td>" .  date_format(date_create($row["date_from"]), "m/d/Y") . "</td>";
                                echo "<td>" .  date_format(date_create($row["date_to"]), "m/d/Y") . "</td>";
                                echo "<td>" . $row["ttl_trnsact"] . "</td>";
                                echo "<td class='text-right'>&#8369; " .    number_format($row["legal_research_fund"], 2, '.', ',') . "</td>";
                                echo "<td class='text-right'>&#8369; " . number_format($row["document_stamp_tax"], 2, '.', ',')  . "</td>";
                                echo "<td class='text-right'>&#8369; " . number_format($row["fees_pcab"], 2, '.', ',') . "</td>";
                                echo "<td class='text-right'>&#8369; " .  number_format($row["no_ngsi_fee"], 2, '.', ',') . "</td>";
                                echo "<td>" .  date_format(date_create($row["deposited_date"]), "m/d/Y") . "</td>";
                                echo "<td>
                                    <a tabindex='0' class='btn-sm' role='button' data-toggle='popover' data-placement='bottom' data-trigger='focus' title='Deposit of " . date_format(date_create($row["deposited_date"]), "m/d/Y") . "' data-content='" . json_encode($row) . "'>View</a>
                                </td>";
                                echo "<td class='text-right'>&#8369; " . number_format($row["deposited_amount"], 2, '.', ',')  . "</td>";
                                echo "<td class='text-right'>&#8369; " .  number_format($row["undeposit_collection"], 2, '.', ',')  . "</td>";
                                echo "<td><button class='btn-sm btn-outline-dark border-0 px-3 py-1 rounded download-btn-modal' onclick='downloadDeposit($key)'>Download</button></td>";
                                echo "</tr>";
                            }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="Submit_deposit" tabindex="-1" role="dialog" aria-labelledby="Submit_depositnModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg d-flex justify-content-center mt-3" role="document">
        <div id="Submit_depositModal" class="modal-content" style="width: 24rem;">
            <div class="modal-header py-2">
                <h5 class="modal-title" id="Submit_depositModalLabel">Collection(s) Settlement</h5>
                <button type="button" class="close text-right pr-4 text-dark" data-dismiss="modal" aria-hidden="true">&times;</button>
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
                            <input type="date" name="collection_date_to" class="p-2 border border-black rounded" value="">
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
                        <label class="">CIAP-PCAB <span class="d-inline p-0 m-0 pl-2" style="pointer-events:auto;margin-top:3px!important;" tabindex="0" data-toggle="tooltip" title="Undeposited Fee of <?= $last_deposit_date ? date_format(date_create($last_deposit_date), "m/d/Y") : "N/A" ?>">(&#8369;
                                <?= number_format($last_deposit ? $last_deposit["balance_fees_pcab"] : 0, 2, '.', ',')  ?>
                                <i class="icon-info bg-dark text-white rounded-circle"></i>)
                            </span>
                            <span class="m-0 p-0 pl-3 d-block pcab-fee" style="margin-top:3px!important;">Total Amount:
                                &#8369; 0.00</span></label>
                        <div id="fees_pcab" class="d-flex flex-row justify-content-between">
                            <div id="referenceNo">
                                <span>Reference No. *</span>
                                <input type="text" name="reference_no" class="p-2 pl-3 border border-black mb-2 w-100 rounded">
                            </div>
                            <div style="width:10px;"></div>
                            <div id="amount">
                                <span>Amount ( &#8369; ) *</span>
                                <input type="text" name="amount" class="p-2 pl-3 border border-black mb-2 w-100 rounded text-right">
                            </div>
                        </div>
                        <label class="">Documentary Stamp Tax <span class="d-inline p-0 m-0 pl-2" style="pointer-events:auto;margin-top:3px!important;" tabindex="0" data-toggle="tooltip" title="Undeposited DST of <?= $last_deposit_date ? date_format(date_create($last_deposit_date), "m/d/Y") : "N/A" ?>">(&#8369;
                                <?= number_format($last_deposit ? $last_deposit["balance_document_stamp_tax"] : 0, 2, '.', ',')   ?>
                                <i class="icon-info bg-dark text-white rounded-circle"></i>)
                            </span>
                            <span class="m-0 p-0 pl-3 d-block dst" style="margin-top:3px!important;">Total Amount:
                                &#8369; 0.00</span></label>
                        <div id="document_stamp_tax" class="d-flex flex-row justify-content-between">
                            <div id="referenceNo">
                                <span>Reference No. *</span>
                                <input type="text" name="reference_no" class="p-2 pl-3 border border-black mb-2 w-100 rounded">
                            </div>
                            <div style="width:10px;"></div>
                            <div id="amount">
                                <span>Amount ( &#8369; ) *</span>
                                <input type="text" name="amount" class="p-2 pl-3 mb-2 w-100  border rounded text-right">
                            </div>
                        </div>
                        <label class="">Legal Research Fund <span class="d-inline p-0 m-0 pl-2" style="pointer-events:auto;margin-top:3px!important;" tabindex="0" data-toggle="tooltip" title="Undeposited LRF of <?= $last_deposit_date ? date_format(date_create($last_deposit_date), "m/d/Y") : "N/A" ?>">(&#8369;
                                <?=number_format($last_deposit ? $last_deposit["balance_legal_research_fund"] : 0, 2, '.', ',')  ?>
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
                        <div class="text-right sum-of-deposit">Total Deposit <br /> &#8369; <p class="p-0 m-0 px-2 d-inline border-bottom border-dark">0.00</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-white border-top py-2 px-3">

                <button type="button" class="btn-sm border-0 m-0 ml-2 rounded close-modal bg-secondary" id="cancelDeposit" data-dismiss="modal" aria-hidden="true">Cancel</button>
                <!-- <button type="button" class="btn-sm border-0 m-0 ml-2 rounded close-modal bg-secondary" id="confirmDeposit" data-toggle="modal" data-target="#DepositConfirmationModal" data-backdrop="static" data-keyboard="false">confirm</button> -->
                <button type="button" class="btn-sm border-0 m-0 ml-2 rounded submit-deposit-btn-modal" id="submitDeposit" data-toggle="modal" data-target="#DepositConfirmationModal" id="submit-deposit" data-backdrop="static" data-keyboard="false" onmouseover="this.style.opacity=1" onmouseleave="this.style.opacity=.8" style="background-color:#00507a;opacity:.8;">
                    <i class="icon-settings spin" hidden></i> <span>Submit</span><span hidden>Submitting</span>
                </button>

            </div>
        </div>
    </div>
</div>
<div class="modal fade show" id="DepositConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="Confirmation_depositnModal" aria-hidden="true">
    <div class="modal-dialog modal-lg d-flex justify-content-center" role="document">
        <div class="modal-content" style="width: auto;">
            <div class="modal-header">
                <h5 class="modal-title">Deposit Confirmation</h5>
            </div>
            <div class="modal-body bg-white pb-3 " style="width: auto; padding: 1rem 2rem;">
                You are about to submit a deposit, are you sure you to proceed?
            </div>
            <div class="modal-footer bg-white border-top py-2 px-3">

                <button type="button" class="btn-sm border-0 m-0 ml-2 rounded close-modal bg-secondary" data-dismiss="modal" aria-hidden="true">Cancel</button>
                <!-- <button type="button" class="btn-sm border-0 m-0 ml-2 rounded close-modal bg-secondary" id="confirmDeposit" data-toggle="modal" data-target="#DepositConfirmationModal" data-backdrop="static" data-keyboard="false">confirm</button> -->
                <button type="button" class="btn-sm border-0 m-0 ml-2 rounded proceed-confirmation-btn" data-dismiss="modal" aria-hidden="true" onmouseover="this.style.opacity=1" onmouseleave="this.style.opacity=.8" style="background-color:#00507a;opacity:.8;">
                    Proceed
                </button>

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="dateInput" class="text-dark">Date:</label>
                                <input type="date" class="form-control" id="dateInput">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="refNumberInput" class="text-dark">Reference Number:</label>
                                <input type="text" class="form-control" id="refNumberInput">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="amountInput" class="text-dark">Total Amount:</label>
                                <input type="text" class="form-control" id="amountInput">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn-md btn-success border-0 px-3 py-1 rounded">Submit</button>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    const sMonths = Array.from({
        length: 12
    }, (item, i) => {
        return new Date(0, i).toLocaleString('en-US', {
            month: 'short'
        })
    });
    const shortDateFormat = (date) => {
        if (!date) return "<i>N/A<i>";
        return new Intl.DateTimeFormat('en-US', {
            year: "numeric",
            month: "numeric",
            day: "numeric"
        }).format(new Date(date))
    }

    const data_collection = JSON.parse('<?= json_encode($data) ?>')
    $(document).ready(function() {


        var table = $('#myTable').DataTable({
            dom: 'Bfrtip',
            scrollX: '80%',
            scrollCollapse: true,
            ordering: false,
            buttons: [],
            layout: {
                topStart: {
                    buttons: [{
                        text: 'Submit Deposit',
                        action: function(e, dt, node, config) {
                            alert('Button activated');
                        }
                    }]
                }
            }
        });

        $('#myTable_wrapper .dt-buttons').html(`
                    <button type="button" class="btn-sm btn-outline-dark border-0 mr-3 mb-2 rounded " data-toggle="modal" data-target="#Submit_deposit" id="submit-deposit" data-backdrop="static" data-keyboard="false">Submit Deposit</button>
                `)

        $('[data-toggle="tooltip"]').tooltip({
            boundary: 'window'
        })
        $('[data-toggle="popover"]').popover({
            content: function() {
                const data = JSON.parse($(this).attr('data-content'))
                const totalUndeposited = Math.abs(parseFloat(data.transactions?.balance_fees_pcab ?? 0)) + Math.abs(parseFloat(data.transactions?.balance_document_stamp_tax ?? 0)) + Math.abs(parseFloat(data.transactions?.balance_legal_research_fund ?? 0))
                const totalDeposited = Math.abs(parseFloat(data.transactions.fees_pcab)) + Math.abs(parseFloat(data.transactions.document_stamp_tax)) + Math.abs(parseFloat(data.transactions.legal_research_fund))
                const totalCollection = Math.abs(
                    parseFloat(data.fees_pcab) +
                    parseFloat(data.document_stamp_tax) +
                    parseFloat(data.legal_research_fund) +
                    parseFloat(data.last_deposit_transactions?.balance_fees_pcab ?? 0) +
                    parseFloat(data.last_deposit_transactions?.balance_document_stamp_tax ?? 0) +
                    parseFloat(data.last_deposit_transactions?.balance_legal_research_fund ?? 0)
                )
                console.log(data)

                return `
                        <div class="mb-2 d-flex flex-row po-content"><span class="col-4 p-0 text-nowrap po-content"></span><span class="pr-0 font-weight-bold col po-content">(&#8369;) Collections</span></div>
                        <div class="mb-0 d-flex flex-row po-content"><span class="col-4 p-0 text-nowrap po-content"><p class="d-inline text-center po-content"><b class="px-auto">PCAB Fees</b><br/><span>Ref. No.: ${data.transactions.pcab_ref_no}12312412323</span></p></span><span class="p-0 col">${parseToCurrency(data.transactions.fees_pcab)}</span></div>
                        <div class="mb-0 d-flex flex-row po-content"><span class="col-4 p-0 text-nowrap po-content"><p class="d-inline text-center po-content"><b class="px-auto">DST</b><br/><span>Ref. No.: ${data.transactions.dst_ref_no}12312412323</span></p></span><span class="p-0 col">${parseToCurrency(data.transactions.document_stamp_tax)}</span></div>
                        <div class="mb-0 d-flex flex-row po-content"><span class="col-4 p-0 text-nowrap po-content"><p class="d-inline text-center po-content"><b class="px-auto">LRF</b><br/><span>Ref. No.: ${data.transactions.lrf_ref_no}12312412323</span></p></span></span><span class="p-0 col">${parseToCurrency(data.transactions.legal_research_fund)}</span></div>
                        `
                // <div class="mb-2 d-flex flex-row po-content"><span class="col-2 p-0 text-nowrap po-content"></span><span class="pr-0 font-weight-bold col po-content">(&#8369;) Collections<span class="collection-label">(+ Balance from last report)</span></span><span class="pr-0 font-weight-bold col">(&#8369;) Deposited</span><span class="pr-0 font-weight-bold col po-content">(&#8369;) Undeposited<span class="collection-label">(This Report)</span></span></div>
                // <div class="mb-0 d-flex flex-row po-content"><span class="col-2 p-0 text-nowrap po-content"><p class="d-inline text-center po-content"><b class="px-auto">PCAB Fees</b><br/><span>(0052-1684-30)</span></p></span><span class="p-0 col po-content ">${parseToCurrency(Math.abs(parseFloat(data.last_deposit_transactions?.balance_fees_pcab ?? 0)) + parseFloat(data.fees_pcab))}<br><span class="collection-label">(+ ${parseToCurrency(Math.abs(parseFloat(data.last_deposit_transactions?.balance_fees_pcab ?? 0)))})</span></span><span class="p-0 col">${parseToCurrency(data.transactions.fees_pcab)}</span><span class="p-0 col">${parseToCurrency(Math.abs(parseFloat(data.transactions?.balance_fees_pcab ?? 0)))}</span></div>
                // <div class="mb-0 d-flex flex-row po-content"><span class="col-2 p-0 text-nowrap po-content"><p class="d-inline text-center po-content"><b class="px-auto">DST</b><br/><span>(3402-2866-00)</span></p></span><span class="p-0 col po-content ">${parseToCurrency(Math.abs(parseFloat(data.last_deposit_transactions?.balance_document_stamp_tax ?? 0)) + parseFloat(data.document_stamp_tax))}<br><span class="collection-label">(+ ${parseToCurrency(Math.abs(parseFloat(data.last_deposit_transactions?.balance_document_stamp_tax ?? 0)))})</span></span><span class="p-0 col">${parseToCurrency(data.transactions.document_stamp_tax)}</span><span class="p-0 col">${parseToCurrency(Math.abs(parseFloat(data.transactions?.balance_document_stamp_tax ?? 0)))}</span></div>
                // <div class="mb-0 d-flex flex-row po-content"><span class="col-2 p-0 text-nowrap po-content"><p class="d-inline text-center po-content"><b class="px-auto">LRF</b><br/><span>(3402-2866-00)</span></p></span></span><span class="p-0 col po-content ">${parseToCurrency(Math.abs(parseFloat(data.last_deposit_transactions?.balance_legal_research_fund ?? 0)) + parseFloat(data.legal_research_fund))}<br><span class="collection-label">(+ ${parseToCurrency(Math.abs(parseFloat(data.last_deposit_transactions?.balance_legal_research_fund ?? 0)))})</span></span><span class="p-0 col">${parseToCurrency(data.transactions.legal_research_fund)}</span><span class="p-0 col">${parseToCurrency(Math.abs(parseFloat(data.transactions?.balance_legal_research_fund ?? 0)))}</span></div>
                // <div class="mb-0 d-flex flex-row po-content"><span class="col-2 p-0 text-nowrap po-content"><p class="d-inline text-center po-content"><b class="px-auto">Total</b></p></span><span class="p-0 col">${parseToCurrency(totalCollection)}</span><span class="p-0 col">${parseToCurrency(totalDeposited)}</span><span class="p-0 col">${parseToCurrency(totalUndeposited)}</span></div>
            },
            container: 'body',
            fallbackPlacement: ["top", "bottom"],
            html: true,
            boundary: 'viewport',
        });
        $(document).on("click", ({
            target
        }) => {
            // console.log(target.parentElement)
            if (target.parentElement.classList.contains("popover") || target.parentElement.classList.contains("popover-body") || target.parentElement.classList.contains("po-content") || target.parentElement.type == "span")
                return

            $('.popover').removeClass("show")
            $('.popover').remove()


        })
    });

    const parseToCurrency = val => {
        if (!val) return "0.00"
        return parseFloat(val).toLocaleString('en-US', {
            maximumFractionDigits: 2,
            minimumFractionDigits: 2
        })
    }

    const content = (data) => `
        <div class="mx-auto" style="[mb];width: 50rem;">
                    <div class="container justify-content-center mb-1">
                        <div class="row d-flex flex-row justify-content-center">
                            <div class="col-md-3">
                                <img height="100px" style="margin-left:-1rem;"
                                    src="assets/images/ngsi-letterhead.png" alt="logo" class="logo-dark" />
                            </div>
                            <div class="col-md-4 mt-3" style="margin-left:11rem;">
                                <p class="font-weight-bold" style="font-family: Century Gothic; font-size:16px;" ;>
                                    NET GLOBAL SOLUTIONS&nbsp;&nbsp; INC.</p>
                                <p style="margin-top: -20px;margin-bottom: -5px; font-family: Century Gothic;">Tel. No: (02) - 853 - 50989</p>
                                <p style=" line-height: 80%; color:blue;margin-top: 10px;">
                                    Support@netglobalsolutions.net</p>
                            </div>
                        </div>
                        <img width="100%" height="5px" style="margin-top: -10px;"
                            src="assets/images/NGSI_header.png" alt="logo" class="logo-dark" />
                    </div>
                    <div class="mt-3">
                        <div class="text-center text-uppercase py-3">
                            <b><u>Certification&nbsp; of Deposit</u></b>
                        </div>
                        <div class="text-center m-3">
                            <b>Summary</b>
                        </div>
                        <table class="border-0">
                            <tbody>
                                <tr>
                                    <td colspan="2">Undeposited Collections per last Report,<br>(Date: ${data.last_date ? shortDateFormat(data.last_date): "N/A"})<br>
                                        <p class="m-0" style="font-size: 12px;padding-left:4rem;">CIAP&nbsp;-&nbsp;PCAB</p>
                                        <p class="m-0" style="font-size: 12px;padding-left:4rem;">DST&nbsp;&nbsp;&nbsp</p>
                                        <p class="m-0" style="font-size: 12px;padding-left:4rem;">LRF&nbsp;&nbsp;</p>
                                    </td>
                                    <td style="vertical-align:bottom;">
                                        <span class="m-0 mb-1 text-right d-block" style="font-size: 12px;">P ${parseToCurrency(data.last_deposit_transactions?.balance_fees_pcab ?? "0.00")}</span>
                                        <span class="m-0 mb-1 text-right d-block" style="font-size: 12px;">P ${parseToCurrency(data.last_deposit_transactions?.balance_document_stamp_tax ?? "0.00")}</span>
                                        <span class="m-0 mb-0 text-right d-block" style="font-size: 12px;">P ${parseToCurrency(data.last_deposit_transactions?.balance_legal_research_fund ?? "0.00")}</span>
                                    </td>
                                    <td class="text-right" style="vertical-align:top;"><div class="w-100 d-inline-block text-right" style="padding-right: .7rem;">P ${parseToCurrency(data.last_txn_amont ?? "0.00")}</div></td>
                              </tr>
                              <tr>
                                    <td colspan="3">Collections, ${data.date_from != data.date_to ? shortDateFormat(data.date_from) + " to " + shortDateFormat(data.date_to) : shortDateFormat(data.date_from)}</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="pl-3 pb-3">Total Number of Transaction</td>
                                    <td > <p style="font-size: 12px;text-align:right;padding-right: .25rem;margin: 0;vertical-align: middle;"> <span class="pb-1 border-dark border-bottom">${(data.ttl_trnsact ?? "0")}</span></p></td>
                                   <td></td>
                                </tr>
                              <tr>
                                    <td class="pl-3" colspan="2">Total Amount of Collection<br>
                                        <p class="mb-0" style="font-size: 12px;padding-left:3.5rem;">CIAP&nbsp;-&nbsp;PCAB</p>
                                        <p class="mb-0" style="font-size: 12px;padding-left:3.5rem;">DST&nbsp;&nbsp;&nbsp</p>
                                        <p class="mb-0" style="font-size: 12px;padding-left:3.5rem;">LRF&nbsp;&nbsp;</p>
                                    </td>
                                    <td style="vertical-align:bottom;">
                                        <span class="m-0 mb-1 text-right d-block" style="font-size: 12px;padding-left:3.5rem;">P ${parseToCurrency(data.fees_pcab ?? "0.00")}</span>
                                        <span class="m-0 mb-1 text-right d-block" style="font-size: 12px;padding-left:3.5rem;">P ${parseToCurrency(data.document_stamp_tax ?? "0.00")}</span>
                                        <span class="m-0 mb-0 text-right d-block" style="font-size: 12px;padding-left:3.5rem;">P ${parseToCurrency(data.legal_research_fund ?? "0.00")}</span>
                                    </td>
                                    <td class="text-right" style="vertical-align:top;"><div class="w-100 d-inline-block text-right" style="padding-right: .7rem;">P ${parseToCurrency(data.no_ngsi_fee ?? "0.00")}</div></td>
                                </tr>
                                <tr >
                                    <td colspan="4" class="">Deposit / Fund Transfers </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="">
                                
                                            <span>
                                                (Date: ${shortDateFormat(data.deposited_date)})
                                            </span>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3" class="pl-3">Total Amount of Collection </td>
                                    <td><p style="text-align:right;font-size: 12px;padding-right: .7rem;">P ${parseToCurrency(data.deposited_amount)}</p></td>
                                </tr>
                                <tr>
                               
                               <td colspan="2" style="padding: 0; padding-left:4.5rem;">CIAP - PCAB &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ref No.:  ${data.transactions?.pcab_ref_no ?? "N/A"}</td>
                               <td class="text-right" style="padding: 0;"> P ${parseToCurrency(data.transactions?.fees_pcab)}</td>
                               <td class="text-right"></td>
                           </tr>
                           <tr>
                               <td colspan="2" style="padding: 0; padding-left:4.5rem;">DST &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ref No.:  ${data.transactions?.dst_ref_no ?? "N/A"}</td>
                               <td class="text-right" style="padding: 0;">P ${parseToCurrency(data.transactions?.document_stamp_tax)}</td>
                               <td class="text-right"></td>
                           </tr>
                           <tr>
                               <td colspan="2" style="padding: 0; padding-left:4.5rem;">LRF &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ref No.:  ${data.transactions?.lrf_ref_no ?? "N/A"}</td>
                               <td class="text-right" style="padding: 0;">P ${parseToCurrency(data.transactions?.legal_research_fund)}</td>
                               <td class="text-right"></td>
                           </tr>

                               
                                <tr style="vertical-align:middle;">
                                    <td colspan="3">Undeposited Collections, this Report</td>
                                    <td>&nbsp;<div class="text-right" style="padding-right: .7rem;"> P ${parseToCurrency(data.undeposit_collection)}</div></td>
                                </tr>

                                <tr>
                               
                                    <td colspan="2" style="padding:0; padding-left:4.5rem;">CIAP - PCAB</td>
                                    <td class="text-right" style="padding:0;">P ${parseToCurrency(data.transactions?.balance_fees_pcab)}</td>
                                    <td class="text-right"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding:0; padding-left:4.5rem;">DST</td>
                                    <td class="text-right" style="padding:0;">P  ${parseToCurrency(data.transactions?.balance_document_stamp_tax)}</td>
                                    <td class="text-right"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding:0; padding-left:4.5rem;">LRF</td>
                                    <td class="text-right" style="padding:0;">P ${parseToCurrency(data.transactions?.balance_legal_research_fund)}</td>
                                    <td class="text-right"></td>
                                </tr>

                            </tbody>
                        </table>

                        <div
                            style="text-align: justify;text-justify: inter-word;margin-top: 2rem; font-size: .9rem; line-height:32px;">
                            This is to certify the above is true and correct statement. That the amount collected is
                            to deposited intact
                            to the Landbank of the Philippines (LANDBANK) bank accounts with account number
                            <b>CIAP - PCAB</b> (0052-1684-30), <b>BTr-CIAP-NGSI-DST</b> (3402-2866-00) ,<b>BTr-CIAP-NGSI-
                            LRF</b> (3402-2866-19) and dully supported by attached proof of deposit. Details of collections can be generated from our online
                            reporting facility or
                            in the attached electronic file of the List if Daily Collection.
                        </div>

    

                        <div class="w-100" style="margin-top: 6rem;">
                                <div class="">
                                    <div class="row" style="height:6rem;">
                                        <div class="col" style="position:relative;left:0px">
                                            <img style="margin-left: 20%;background-position:center;margin-bottom:-15px;z-index:0;transform: scale(1.4);display:block;position:relative;top:-7px;height:3rem;" width="35%" height="35%" src="assets/images/ma'am_je.png" alt="logo" class="logo-dark">
                                            <p style="position:relative;left: 1.7rem;margin:0;width: 100px;bottom: 61px;">Prepared By: </p>
                                            <p style="margin-top:-25px;margin-left:87px;font-size: 15px;font-family:Arial,Helvetica,sans-serif;z-index:1;position:relative;text-transform: uppercase;font-weight: 700;margin-bottom: 20px;">
                                                   Jeremie Soliveres </p>
                                            <p style="margin-top:-24px;margin-left:106px;font-family:Arial,Helvetica,sans-serif;font-size:12px;z-index:1;position:relative;margin-bottom: 20px;">
                                                Accounting Specialist</p>
                                        <p style="margin-top:-24px;margin-left: 100px;font-family:Arial,Helvetica,sans-serif;font-size:12px;z-index:1;position:relative;">Netglobal Solutions, Inc.</p></div>
                                        <div class="col" style="position:relative;left:0;">
                                            <img style="margin-left: 14rem;margin-bottom:-15px;background-position:center;margin-bottom:-15px;z-index:0;transform: scale(1.1);display:block;position:relative;top:-7px;height:3rem;left: -26px;" width="35%" height="35%" src="assets/images/sir_peter.png" alt="logo" class="logo-dark">
                                            <p style="position:relative;left: 7.7rem;margin:0;width: 100px;bottom: 61px;">Approved By: </p>
                                            <p style="margin-top:-25px;margin-left:12rem;font-size: 15px;z-index: 1;position: relative;text-transform: uppercase;font-weight: 700;">
                                                Peter &nbsp; Lingatong</p>
                                            <p style="margin-top: -20px;margin-left: 13.5rem;font-family:Arial,Helvetica,sans-serif;font-size:12px;z-index:1;position:relative;">
                                                Chairman &amp; CEO</p>
                                        <p style="margin-top: -20px;margin-left: 200px;font-family:Arial,Helvetica,sans-serif;font-size:12px;z-index:1;position:relative;">Netglobal Solutions, Inc.</p></div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                `;

    function downloadDeposit(key) {
        let doc = new jspdf.jsPDF({
            orientation: 'p',
            unit: 'px'
        })

        const now = new Date()

        const data = data_collection[key]
        // console.log(data)

        doc.html(`<div id="PDFContent" class="mx-auto d-flex flex-column border-dark" style="width:55.8rem;padding-top:5rem;/*border:1px black solid;*/">${content(data)}</div>`, {
            html2canvas: {
                scale: .5
            },
            async callback(pdf) {
                const date = new Date();
                await pdf.save(`receipt-${date.toLocaleDateString()}.pdf`);
            },
        })
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
        console.log(parseFloat(total_pcab_fee) + fee, fee, total_pcab_fee)
        $("#Submit_deposit span.total-collection").text(`Total: ₱ ${parseToCurrency((resetToZero ? 0 : parseFloat(total_collection) + total_collection_bal))}`)
        $("#Submit_deposit span.pcab-fee").text(`Total: ₱ ${parseToCurrency((resetToZero ? 0 : parseFloat(total_pcab_fee)) + fee)}`)
        $("#Submit_deposit span.dst").text(`Total: ₱ ${parseToCurrency((resetToZero ? 0 : parseFloat(total_dst)) + dst)}`)
        $("#Submit_deposit span.lrf").text(`Total: ₱ ${parseToCurrency((resetToZero ? 0 : parseFloat(total_lrf)) + lrf)}`)
    }

    const depositTotal = () => {
        let total = 0
        $("#Submit_deposit #amount input").each(function() {
            total += parseFloat(this.value ? this.value.replaceAll(",", "") : 0)
        })
        console.log(total)
        $("#Submit_deposit .sum-of-deposit p").text(parseToCurrency(total))
    }

    // const shortDateFormat = (date) => {
    //     if (!date) return "<i>N/A<i>";
    //     return new Intl.DateTimeFormat('en-US', {
    //         year: "numeric",
    //         month: "2-digit",
    //         day: "2-digit"
    //     }).format(new Date(date))
    // }

    const updateUndepositedTooltip = (data) => {
        const list = {
            "balance_fees_pcab": "Fee",
            "balance_document_stamp_tax": "DST",
            "balance_legal_research_fund": "LRF"
        }
        $("#Submit_deposit label").each(function(key) {
            if (!key) return;
            const prop = Object.keys(list)[key - 1]
            this.children[0].dataset.mdbOriginalTitle = `Undeposited ${list[prop]} of ${shortDateFormat(data.last_deposit_date)}`;
            this.children[0].innerHTML = `(&#8369; ${parseToCurrency(data[prop])} <i class="icon-info bg-dark text-white rounded-circle"></i>)`;


        })
    }
    let latest_deposit_data = JSON.parse('<?= json_encode($last_deposit) ?>')
    let dbTotalCollection = 0;
    let data;

    $('#Submit_deposit').on("show.bs.modal", function() {
        $('#Daily_CollectionModal .close[data-dismiss=modal').click()
    })

    $("#dateOfDeposit input, #dateRange input").on("click", function() {
        this.showPicker();
    })

    $("#dateRange input").on("input", async function() {
        console.log('triggerf')

        $("#Submit_deposit .message").text("").removeClass("error", "success");
        const body = {
            collection_date_to: $("input[name='collection_date_to'").val(),
            collection_date_from: $("input[name='collection_date_from'").val()
        }
        updateToDepositAmount({}, true)
        if (new Date(this.value) > new Date((new Date()).getTime() - 86400000)) {
            const _this = this;
            $("#Submit_deposit .message").text(`Date '${this.name.split("_")[2].toUpperCase()}' should not today or further.`).addClass("error");
            setTimeout(function() {
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

    $("#dateRange input, #referenceNo input, #dateOfDeposit input, #amount input").on("input", function() {
        if (this.value != "") {
            this.parentElement.classList.add("filled")
            this.parentElement.classList.remove("error")
        } else
            this.parentElement.classList.remove("filled", "error")
    })

    $("#amount input").on("blur", function() {
        const regex = /(?:^[1-9]([0-9]+)?(?:\.[0-9]{1,2})?$)|(?:^(?:0)$)|(\.\d)/
        if (this.value != "") {
            if (!regex.test(this.value))
                this.parentElement.classList.add("error")
            else {
                this.value = parseToCurrency(this.value.replaceAll(",", ""))
                depositTotal()
            }
        } else {
            this.parentElement.classList.remove("error")
        }
    })
    $("#amount input").on("focus", function() {
        this.value = this.value.replaceAll(',', '')
    })

    $("#cancelDeposit, #Submit_deposit .close[data-dismiss=modal]").on("click", async () => {
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
        $("#Submit_deposit input").each(function() {
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
                    $(".modal button[data-dismiss=modal").each(function() {
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