<?php

// Inialize session
session_start();

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: Login.php');
}

?>
<?php
include('config.php')
?>
<!doctype html>
<html lang="en">

<head>
    <title>Smart RFID Laundry</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/vendor/linearicons/style.css">
    <link rel="stylesheet" href="assets/vendor/chartist/css/chartist-custom.css">
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="assets/css/main.css">
    <!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
    <link rel="stylesheet" href="assets/css/demo.css">
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <!-- ICONS -->
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
</head>

<script>
    function check() {
        if (document.getElementById('search').value === '') {
            alert("กรุณาใส่เลขที่ออเดอร์ของท่านก่อน.");
            return false;
        } else {
            setInterval(getDataFromDb, 500);
        }
    }
    function getDataFromDb()
    {

        $('input#search').keypress(function(e) {
            if (e.which == '13') {
                e.preventDefault();
                //$("#LabelID").text("หมายเลขทะเบียน : "+document.getElementById("search").value);
                document.activeElement.blur();
            }
        });
        $.ajax({
            url: "http://119.59.115.80/CheckStatus/Service/getData.php?OrderNo="+document.getElementById("search").value ,
            type: "POST",
            data: ''
        })
            .success(function(result) {
                var obj = jQuery.parseJSON(result);
                var i=0;
                var OrderDate = new Array();
                var Deliverly = new Array();
                var DeliverlyDate = new Array();
                var Driver = new Array();
                var DriverDate = new Array();
                var Checker = new Array();
                var CheckerDate = new Array();
                var BranchEmp = new Array();
                var BranchEmpDate = new Array();
                var ReturnCust = new Array();
                var ReturnCustDate = new Array();
                var IsActive = new Array();
                var CancelDate = new Array();
                if(obj != '') {
                    //$("#myTable tbody tr:not(:first-child)").remove();
                    $("#myBody").empty();
                    $.each(obj, function (key, val) {
                        $("#LabelOrder").text("เลขที่ออเดอร์ : " + val["OrderNo"]);
                        $("#LabelDate").text("วันที่นัดรับ : " + val["AppointmentDate"]);
                        if (val["IsActive"] == 1) {
                            $("#LabelStatus").text("สถานะ : ปกติ");
                        } else {
                            $("#LabelStatus").text("สถานะ : ยกเลิก");
                        }
                        OrderDate.push(val["OrderDate"]);
                        Deliverly.push(val["DeliveryStatus"]);
                        DeliverlyDate.push(val["DeliveryDate"]);
                        Driver.push(val["IsDriverVerify"]);
                        DriverDate.push(val["DriverVerifyDate"]);
                        Checker.push(val["IsCheckerVerify"]);
                        CheckerDate.push(val["CheckerVerifyDate"]);
                        BranchEmp.push(val["IsBranchEmpVerify"]);
                        BranchEmpDate.push(val["BranchEmpVerifyDate"]);
                        ReturnCust.push(val["IsReturnCustomer"]);
                        ReturnCustDate.push(val["ReturnCustomerDate"]);
                        IsActive.push(val["IsActive"]);
                        CancelDate.push(val["DeletedDate"]);
                    });

                    var arrStatus = new Array();
                    var arrStatusDate = new Array();
                    if (IsActive[0] == "0") {
                        arrStatus.push("ผ้าอยู่กับร้านค้า");
                        arrStatus.push("ลูกค้ายกเลิกรายการซัก");
                        arrStatusDate.push(OrderDate[0]);
                        arrStatusDate.push(CancelDate[0]);
                        //dupicate

                    } else {
                        if (Deliverly[0] == 0 && Driver[0] == 0 && Checker[0] == 0 && BranchEmp[0] == 0 && ReturnCust[0] == 0) {
                            arrStatus.push("ผ้าอยู่กับร้านค้า");
                            arrStatusDate.push(OrderDate[0]);
                        } else if (Deliverly[0] == 0 && Driver[0] == 1 && Checker[0] == 0 && BranchEmp[0] == 0 && ReturnCust[0] == 0) {
                            arrStatus.push("ผ้าอยู่กับร้านค้า");
                            arrStatus.push("ผ้าอยู่กับคนขับรถนำส่งโรงงาน");
                            arrStatusDate.push(OrderDate[0]);
                            arrStatusDate.push(DriverDate[0]);
                        } else if (Deliverly[0] == 0 && Driver[0] == 1 && Checker[0] == 1 && BranchEmp[0] == 0 && ReturnCust[0] == 0) {
                            arrStatus.push("ผ้าอยู่กับร้านค้า");
                            arrStatus.push("ผ้าอยู่กับคนขับรถนำส่งโรงงาน");
                            arrStatus.push("ผ้าอยู่กับแผนก Factory Checker In");
                            arrStatusDate.push(OrderDate[0]);
                            arrStatusDate.push(DriverDate[0]);
                            arrStatusDate.push(CheckerDate[0]);
                        }else if (Deliverly[0] == 1 && Driver[0] == 0 && Checker[0] == 1 && BranchEmp[0] == 0 && ReturnCust[0] == 0) {
                            arrStatus.push("ผ้าอยู่กับร้านค้า");
                            arrStatus.push("ผ้าอยู่กับคนขับรถนำส่งโรงงาน");
                            arrStatus.push("ผ้าอยู่กับแผนก Factory Checker In");
                            arrStatus.push("ผ้าอยู่กับแผนก Factory Checker Out");
                            arrStatusDate.push(OrderDate[0]);
                            arrStatusDate.push(DriverDate[0]);
                            arrStatusDate.push(CheckerDate[CheckerDate.length - 1]);
                            arrStatusDate.push(CheckerDate[0]);
                        }else if (Deliverly[0] == 1 && Driver[0] == 1 && Checker[0] == 1 && BranchEmp[0] == 0 && ReturnCust[0] == 0) {
                            arrStatus.push("ผ้าอยู่กับร้านค้า");
                            arrStatus.push("ผ้าอยู่กับคนขับรถนำส่งโรงงาน");
                            arrStatus.push("ผ้าอยู่กับแผนก Factory Checker In");
                            arrStatus.push("ผ้าอยู่กับแผนก Factory Checker Out");
                            arrStatus.push("ผ้าอยู่กับคนขับรถนำคืนร้านค้า");
                            arrStatusDate.push(OrderDate[0]);
                            arrStatusDate.push(DriverDate[CheckerDate.length - 1]);
                            arrStatusDate.push(CheckerDate[CheckerDate.length - 1]);
                            arrStatusDate.push(CheckerDate[0]);
                            arrStatusDate.push(DriverDate[0]);
                        } else if (Deliverly[0] == 1 && Driver[0] == 1 && Checker[0] == 1 && BranchEmp[0] == 1 && ReturnCust[0] == 0) {
                            arrStatus.push("ผ้าอยู่กับร้านค้า");
                            arrStatus.push("ผ้าอยู่กับคนขับรถนำส่งโรงงาน");
                            arrStatus.push("ผ้าอยู่กับแผนก Factory Checker In");
                            arrStatus.push("ผ้าอยู่กับแผนก Factory Checker Out");
                            arrStatus.push("ผ้าอยู่กับคนขับรถนำคืนร้านค้า");
                            arrStatus.push("ผ้าอยู่กับร้านค้า");
                            arrStatusDate.push(OrderDate[0]);
                            arrStatusDate.push(DriverDate[CheckerDate.length - 1]);
                            arrStatusDate.push(CheckerDate[CheckerDate.length - 1]);
                            arrStatusDate.push(CheckerDate[0]);
                            arrStatusDate.push(DriverDate[0]);
                            arrStatusDate.push(BranchEmpDate[0]);
                        }else if (Deliverly[0] == 1 && Driver[0] == 1 && Checker[0] == 1 && BranchEmp[0] == 1 && ReturnCust[0] == 1) {
                            arrStatus.push("ผ้าอยู่กับร้านค้า");
                            arrStatus.push("ผ้าอยู่กับคนขับรถนำส่งโรงงาน");
                            arrStatus.push("ผ้าอยู่กับแผนก Factory Checker In");
                            arrStatus.push("ผ้าอยู่กับแผนก Factory Checker Out");
                            arrStatus.push("ผ้าอยู่กับคนขับรถนำคืนร้านค้า");
                            arrStatus.push("ผ้าอยู่กับร้านค้า");
                            arrStatus.push("ผ้าถึงมือลูกค้าแล้ว");
                            arrStatusDate.push(OrderDate[0]);
                            arrStatusDate.push(DriverDate[CheckerDate.length - 1]);
                            arrStatusDate.push(CheckerDate[CheckerDate.length - 1]);
                            arrStatusDate.push(CheckerDate[0]);
                            arrStatusDate.push(DriverDate[0]);
                            arrStatusDate.push(BranchEmpDate[0]);
                            arrStatusDate.push(ReturnCustDate[0]);
                        }
                    }

                    for (var i = 0; i < arrStatus.length; i++) {
                        var index =i+1;
                        var tr = "<tr>";
                        if(arrStatus[i]=="ลูกค้ายกเลิกรายการซัก"){
                            tr = tr + "<td style='color: #e60000'><center>" + index + "</center></td>";
                            tr = tr + "<td style='color: #e60000'>" + arrStatus[i] + "</td>";
                            tr = tr + "<td style='color: #e60000'><center>" + arrStatusDate[i] + "</center></td>";
                        }else if(arrStatus[i]=="ผ้าถึงมือลูกค้าแล้ว"){
                            tr = tr + "<td style='color: #2eb82e'><center>" + index + "</center></td>";
                            tr = tr + "<td style='color: #2eb82e'>" + arrStatus[i] + "</td>";
                            tr = tr + "<td style='color: #2eb82e'><center>" + arrStatusDate[i] + "</center></td>";
                        }else{
                            tr = tr + "<td style='color: #0f0f0f'><center>" + index + "</center></td>";
                            tr = tr + "<td style='color: #0f0f0f'>" + arrStatus[i] + "</td>";
                            tr = tr + "<td style='color: #0f0f0f'><center>" + arrStatusDate[i] + "</center></td>";
                        }
                        tr + "</tr>";
                        $('#myTable > tbody:last').append(tr);
                    }
                    //tr = tr + "<td style='color: #0f0f0f'><center>" + myArray[myArray.length-1] + "</center></td>";
                    //tr = tr + "<td style='color: #0f0f0f'><center>" + val["Row"] + "</center></td>";
                    /*tr = tr + "<td style='color: #0f0f0f'><center>" + val["OrderNo"] + "</center></td>";
                    tr = tr + "<td style='color: #0f0f0f'><center>" + val["OrderDate"] + "</center></td>";*/


                }/*else{
                    $("#myBody").empty();
                    $.each(obj, function(key, val) {
                        var tr = "<tr>";
                        tr = tr + "<td style='color: #0f0f0f'><center>" + val["OrderNo"] + "</center></td>";
                        tr = tr + "<td style='color: #0f0f0f'><center>" + val["OrderDate"] + "</center></td>";
                        tr = tr + "<td style='color: #0f0f0f'><center>" + val["IsDriverVerify"] + "</center></td>";
                        tr = tr + "</tr>";
                        $('#myTable > tbody:last').append(tr);
                    });
                }*/
            });
    }
    //setInterval(getDataFromDb, 500);
    function logout() {
        $.get("path.txt", function (data) {
            var resourceContent = data;
            var id="<?php echo $_SESSION['id'];?>";
            $.ajax({
                url: resourceContent + "/getLogout.php?IsSignOn=0&id="+id,
                type: "POST",
                data: ''
            })
                .success(function (result) {
                    //
                    window.location = 'Logout.php';
                });
        });
    }
</script>
<body>
<!-- WRAPPER -->
<div id="wrapper">
    <!-- NAVBAR -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="brand" style="background-color: #f9f9f9">
            <a href="index.php"><img src="assets/img/Logo-CLEANMATE-2.png" alt="Klorofil Logo" class="img-responsive logo"></a>
        </div>
        <div class="container-fluid" style="background-color: #f9f9f9">
            <div class="navbar-btn">
                <button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
            </div>
            <!--<form class="navbar-form navbar-left">
                <div class="input-group">
                    <select class="form-control input-group-sm">
                        <option value="cheese">Cheese</option>
                        <option value="tomatoes">Tomatoes</option>
                        <option value="mozarella">Mozzarella</option>
                        <option value="mushrooms">Mushrooms</option>
                        <option value="pepperoni">Pepperoni</option>
                        <option value="onions">Onions</option>
                    </select>
                    <span class="input-group-btn"><button type="button" class="btn btn-primary">Go</button></span>
                </div>
            </form>-->
            <!--<div class="navbar-btn navbar-btn-right">
                <a class="btn btn-success update-pro" href="https://www.themeineed.com/downloads/klorofil-pro-bootstrap-admin-dashboard-template/?utm_source=klorofil&utm_medium=template&utm_campaign=KlorofilPro" title="Upgrade to Pro" target="_blank"><i class="fa fa-rocket"></i> <span>UPGRADE TO PRO</span></a>
            </div>-->
            <div id="navbar-menu">
                <ul class="nav navbar-nav navbar-right">

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="assets/img/icon.png" class="img-circle" alt="Avatar"> <span><?php echo $_SESSION['FirstName'].' '.$_SESSION['LastName'].' ('.$_SESSION['BranchNameTH'].')';?></span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a onclick="logout()"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- END NAVBAR -->
    <!-- LEFT SIDEBAR -->
    <div id="sidebar-nav" class="sidebar">
        <div class="sidebar-scroll">
            <nav>
                <ul class="nav">
                    <br>
                    <!--<li><a href="index.html" class="active"><i class="lnr lnr-home"></i> <span>ตรวจสอบสินค้าเข้าโรงงาน</span></a></li>
                    <li><a href="elements.html" class=""><i class="lnr lnr-code"></i> <span>ตรวจสอบสินค้าจากโรงงาน</span></a></li>
                    <li><a href="charts.html" class=""><i class="lnr lnr-chart-bars"></i> <span>แจ้งเตือนสินค้าผิดประเภท</span></a></li>-->
                    <li><a href="index.php" class=""><i class="lnr lnr-chart-bars"></i> <span>ตรวจสอบสถานะสินค้า</span></a></li>
                </ul>
            </nav>
        </div>
    </div>
    <!-- END LEFT SIDEBAR -->
    <div class="main">
        <!-- MAIN CONTENT -->
        <div class="main-content">
            <div class="container-fluid">
                <h3 class="page-title">ตรวจสอบสถานะสินค้า</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">กรุณากรอกเลขที่ออเดอร์ของท่าน</h3>
                            </div>
                            <div class="panel-body">
                                <form method="post">
                                    <input type="text" value="" id="search" name="search" class="form-control" placeholder="ค้นหาเลขที่ออเดอร์..." onkeydown="if (event.keyCode == 13)
 {check()}">
                                    <br>
                                    <div align="center" id="myButton1">
                                        <button id="btnSearch" type="button" class="btn btn-success" onclick="check()"><i class="fa fa-check-circle"></i> ตกลง</button>
                                        <br>
                                    </div>
                                </form>
                            </div>
                            <br>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">ข้อมูลผลลัพธ์ </h3>
                            </div>
                            <div class="panel-body">
                                <p class="text-info" id="LabelOrder"><code style="font-size: medium" id="textOrder">เลขที่ออเดอร์ : </code></p>
                                <p class="text-info" id="LabelDate"><code style="font-size: medium" id="textDate">วันที่นัดรับ : </code></p>
                                <p class="text-info" id="LabelStatus"><code style="font-size: medium" id="textStatus">สถานะ : </code></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-headline">
                    <div class="panel-heading">
                        <h3 class="panel-title">ตารางข้อมูล</h3>
                        <div class="panel-body">
                            <table class="table table-striped" id="myTable">
                                <thead align="center">
                                <tr bgcolor="#191970">
                                    <th style="color: #f1f1f1"><center>ลำดับ</center></th>
                                    <th style="color: #f1f1f1"><center>สถานะ</center></th>
                                    <th style="color: #f1f1f1"><center>วดป/เวลา</center></th>
                                </tr>
                                </thead>
                                <tbody id="myBody">
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- END MAIN CONTENT -->
    </div>
    <!-- END MAIN -->
    <div class="clearfix"></div>
    <footer>
        <div class="container-fluid">

            </p>
        </div>
    </footer>
</div>
<!-- END WRAPPER -->
<!-- Javascript -->
<script src="assets/vendor/jquery/jquery.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
<script src="assets/vendor/chartist/js/chartist.min.js"></script>
<script src="assets/scripts/klorofil-common.js"></script>
<script>
    $(function() {
        var data, options;

        // headline charts
        data = {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            series: [
                [23, 29, 24, 40, 25, 24, 35],
                [14, 25, 18, 34, 29, 38, 44],
            ]
        };

        options = {
            height: 300,
            showArea: true,
            showLine: false,
            showPoint: false,
            fullWidth: true,
            axisX: {
                showGrid: false
            },
            lineSmooth: false,
        };

        new Chartist.Line('#headline-chart', data, options);


        // visits trend charts
        data = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            series: [{
                name: 'series-real',
                data: [200, 380, 350, 320, 410, 450, 570, 400, 555, 620, 750, 900],
            }, {
                name: 'series-projection',
                data: [240, 350, 360, 380, 400, 450, 480, 523, 555, 600, 700, 800],
            }]
        };

        options = {
            fullWidth: true,
            lineSmooth: false,
            height: "270px",
            low: 0,
            high: 'auto',
            series: {
                'series-projection': {
                    showArea: true,
                    showPoint: false,
                    showLine: false
                },
            },
            axisX: {
                showGrid: false,

            },
            axisY: {
                showGrid: false,
                onlyInteger: true,
                offset: 0,
            },
            chartPadding: {
                left: 20,
                right: 20
            }
        };

        new Chartist.Line('#visits-trends-chart', data, options);


        // visits chart
        data = {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            series: [
                [6384, 6342, 5437, 2764, 3958, 5068, 7654]
            ]
        };

        options = {
            height: 300,
            axisX: {
                showGrid: false
            },
        };

        new Chartist.Bar('#visits-chart', data, options);


        // real-time pie chart
        var sysLoad = $('#system-load').easyPieChart({
            size: 130,
            barColor: function(percent) {
                return "rgb(" + Math.round(200 * percent / 100) + ", " + Math.round(200 * (1.1 - percent / 100)) + ", 0)";
            },
            trackColor: 'rgba(245, 245, 245, 0.8)',
            scaleColor: false,
            lineWidth: 5,
            lineCap: "square",
            animate: 800
        });

        var updateInterval = 3000; // in milliseconds

        setInterval(function() {
            var randomVal;
            randomVal = getRandomInt(0, 100);

            sysLoad.data('easyPieChart').update(randomVal);
            sysLoad.find('.percent').text(randomVal);
        }, updateInterval);

        function getRandomInt(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }

    });
</script>
</body>

</html>
