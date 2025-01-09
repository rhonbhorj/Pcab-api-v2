<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Dashboard</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href=<?php echo base_url('/assets/css/main.css'); ?> />
    <link rel="stylesheet" href=<?php echo base_url('/assets/vendors/simple-line-icons/css/simple-line-icons.css'); ?> />
    <link rel="stylesheet" href=<?php echo base_url('/assets/vendors/flag-icon-css/css/flag-icon.min.css'); ?> />
    <link rel="stylesheet" href=<?php echo base_url('/assets/vendors/css/vendor.bundle.base.css'); ?> />


    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href=<?php echo base_url('/assets/vendors/css/vendor.bundle.base.css'); ?> />
    <link rel="stylesheet" href=<?php echo base_url('/assets/vendors/css/vendor.bundle.base.css'); ?> />
    <link rel="stylesheet" href=<?php echo base_url('/assets/vendors/daterangepicker/daterangepicker.css'); ?> />
    <link rel="stylesheet" href=<?php echo base_url('/assets/vendors/chartist/chartist.min.css'); ?> />

    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href=<?php echo base_url('/assets/css/style.css'); ?> />
    <!-- End layout styles -->
    <link rel="shortcut icon" href=<?php echo base_url('/assets/images/pcab_logo.png'); ?> />

    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous"> -->
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
        </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
        integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous">
        </script> -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous">
    </script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" />
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" integrity="sha512-qZvrmS2ekKPF2mSznTQsxqPgnpkI4DNTlrdUmTzrDgektczlKNRRhy5X5AAOnx5S09ydFYWWNSfcEqDTTHgtNA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/3.0.6/purify.min.js" integrity="sha512-H+rglffZ6f5gF7UJgvH4Naa+fGCgjrHKMgoFOGmcPTRwR6oILo5R+gtzNrpDp7iMV3udbymBVjkeZGNz1Em4rQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script> -->
</head>

<body>


    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->

        <?php $this->load->view('./admin/partials/_navbar.php'); ?>

        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->

            <?php $this->load->view('./admin/partials/_sidebar.php'); ?>

            <!-- partial -->
            <div class="main-panel">
                <!-- <div class="box">
                    <div class="container">
                        <span class="dot"></span>
                        <span class="dot"></span>
                        <span class="dot"></span>
                        <span class="dot"></span>
                    </div>
                </div> -->
                <div class="content-wrapper p-0 pl-3 m-0 bg-white">
                    <!-- main view container -->
                    <?php
                    $view = isset($route) ? $route : "acknowledgement-receipt";
                    $this->load->view('./modules/' . $view);
                    ?>

                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->



                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>


    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src=<?php echo base_url('/assets/js/off-canvas.js'); ?>></script>
    <script src=<?php echo base_url('/assets/js/misc.js'); ?>></script>
    <script src=<?php echo base_url('/assets/vendors/daterangepicker/daterangepicker.js'); ?>></script>
    <script src=<?php echo base_url('/assets/vendors/chartist/chartist.min.js'); ?>></script>

    <!-- endinject -->
    <!-- Custom js for this page -->

    <!-- <script src=<?php echo base_url('/assets/js/dashboard.js'); ?>></script> -->

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.1/mdb.min.js"></script>
    <!-- End custom js for this page -->
    <link rel="stylesheet" href="//cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
    <script src="//cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
</body>
<!-- <script>
    setTimeout(() => {
        $(".main-panel .box").css("display", "none")
    }, 1000)
</script> -->

</html>