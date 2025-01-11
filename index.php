<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  <link rel="stylesheet" href="styles1.css">
</head>

<body>
  
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between ">
      <a href="index.php" class="logo d-flex a-itlignems-center">
        <img src="assets/img/OXY_logo.png" alt="OXY_logo" >
      </a>
    </div><!-- End Logo -->
    
    <?php
      include 'connect.php';

      // แสดง Popup
      echo "<script>alert('เชื่อมต่อสำเร็จ!');</script>";
    ?>
    
    <nav class="header-nav ms-auto">

      <img class="logo_position" src="assets/img/logo_RBM.png" alt="RBM Logo" style="width: 100px; height: auto;">
        
    </nav><!-- End Icons Navigation -->
      
      

  </header><!-- End Header -->

  

  <main id="main" class="main">

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-12 col-md-12">
                <div class="card info-card sales-card">
  
                    <div class="card-body ">
                        <div class="card-title-wrapper">
                            <h5 class="card-title"> 
                                <img src="assets/img/SPO2_logo.png" alt="SPO2 Logo" style="width: 50px; height: auto;">
                                Spo2%
                            </h5>
                        </div>
  
                        
                        <div class="ps-3 card-title-wrapper end">
                            <div class="ps-3 card-title-wrapper span text-V">95</div>
                            <div class="ps-3 card-title-wrapper span text-normal ">
                                <div class="status-box">
                                    Normal
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Sales Card -->

            
            <div class="row">
            <!-- Sales Card 1 -->
            <div class="col-xxl-8 col-md-8">
                <div class="card info-card sales-card">
                    <div class="card-body">
                        <div class="card-title-wrapper">
                            <div class="card-title"> 
                                <img src="assets/img/PR_logo.png" alt="SPO2 Logo" style="width: 30px; height: auto;">
                                PR(bpm)
                            </div>
                        </div>
                        <div class=" center ps-3 card-title-wrapper end">
                            <span class="text-Vbpm">90</span>
                            <span class="text-normal">VPM</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- การ์ดด้านขวา -->
            <div class="col-xxl-4 col-md-4">
                <div class="d-flex flex-column ">
                    <!-- Sales Card 2 -->
                    <div class="card info-card sales-card">
                        <div class="card-body1">
                            <div class="center card-title-wrapper">
                                <div class="  card-title "> 
                                    <img src="assets/img/SPO2_logo.png" alt="SPO2 Logo" style="width: 40px; height: auto;">
                                    
                                </div>
                                <div class=" center ps-3 card-title-wrapper end">
                                  <span class="text-Vbpm">98</span>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                    <!-- Sales Card 3 -->
                    <div class=" center card info-card sales-card">
                        <div class="card-body1">
                            <div class="  card-title-wrapper">
                                <div class="card-title "> 
                                    <img src="assets/img/PR_logo.png" alt="SPO2 Logo" style="width: 30px; height: auto;">
                                    
                                </div>
                                <div class=" center ps-3 card-title-wrapper end">
                                  <span class="text-Vbpm">95</span>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>


            

            <!-- Reports -->
            <div class="col-12">
              <div class="card">

                

                <div class="card-body">
                  <h5 class="card-title">Reports </h5>

                  <!-- Export Data -->
                  <form action="export.php" method="post" class="form-right" >
                    <button class="button" type="submit">Export Data</button>
                  </form>

                  <!-- Line Chart -->
                  <div id="reportsChart"></div>

                  <script>
                    document.addEventListener("DOMContentLoaded", () => {
                      new ApexCharts(document.querySelector("#reportsChart"), {
                        series: [{
                          name: 'Sales',
                          data: [31, 40, 28, 51, 42, 82, 56],
                        }, {
                          name: 'Revenue',
                          data: [11, 32, 45, 32, 34, 52, 41]
                        }, {
                          name: 'Customers',
                          data: [15, 11, 32, 18, 9, 24, 11]
                        }],
                        chart: {
                          height: 350,
                          type: 'area',
                          toolbar: {
                            show: false
                          },
                        },
                        markers: {
                          size: 4
                        },
                        colors: ['#4154f1', '#2eca6a', '#ff771d'],
                        fill: {
                          type: "gradient",
                          gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.3,
                            opacityTo: 0.4,
                            stops: [0, 90, 100]
                          }
                        },
                        dataLabels: {
                          enabled: false
                        },
                        stroke: {
                          curve: 'smooth',
                          width: 2
                        },
                        xaxis: {
                          type: 'datetime',
                          categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
                        },
                        tooltip: {
                          x: {
                            format: 'dd/MM/yy HH:mm'
                          },
                        }
                      }).render();
                    });
                  </script>
                  <!-- End Line Chart -->

                </div>

              </div>
            </div><!-- End Reports -->
          </div>
        

      </div>
    </section>

  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>