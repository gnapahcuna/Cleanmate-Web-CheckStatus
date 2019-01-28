<?php

#starts a new session
session_start();

#includes a database connection
include 'connect.php';

#catches user/password submitted by html form
$user = $_GET['txtUsername'];
$password = $_GET['txtPassword'];

#checks if the html form is filled
if(empty($_GET['txtUsername']) || empty($_GET['txtPassword'])){
    echo "<meta http-equiv='refresh' content='1;URL=Login.php'>";
?>
<table align="center">
	<td align="center" valign="middle" height="500" width="1200">
		<h3><br><br>กรุณากรอกข้อมูลให้ครบทุกช่อง!</h3>
	</td>
</table>
<?php
}else{?>
<script src="assets/vendor/jquery/jquery.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
<script src="assets/vendor/chartist/js/chartist.min.js"></script>
<script src="assets/scripts/klorofil-common.js"></script>
<script>
    $.get( "path.txt", function( data ) {
        var resourceContent = data;
        $.ajax({
            url: resourceContent+"/getLogin.php?txtUsername=<?php echo $user ?>&txtPassword=<?php echo $password ?>" ,
            type: "POST",
            data: ''
        })
            .success(function(result) {
                if(result=="#2"){
                    alert('User นี้หมดอายุการใช้งานแล้ว')
                    window.location = 'index.php';
                }else {
                    if (result.length != 0) {
                        var obj = jQuery.parseJSON(result);
                        var i = 0;

                        if (obj != '') {
                            $.each(obj, function (key, val1) {
                                var menu = "";
                                $.each(val1['Data_Role'], function (key, val) {
                                    menu += val['ProgramCode'];
                                    if (key == val1['Data_Role'].length - 1) {

                                    } else {
                                        menu += ',';
                                    }
                                })

                                $.each(val1['Data_User'], function (key, val) {
                                    $.get("gdata.php", {
                                        id: val['AccountCode']
                                        , FirstName: val['FirstName']
                                        , LastName: val['LastName']
                                        , username: val['AccountCode']
                                        , BranchID: val['BranchID']
                                        , BranchNameTH: val['BranchNameTH']
                                        , MenuName: menu
                                    }, function (result) {
                                        if (result == 1) {
                                            window.location = 'index.php';
                                        } else {
                                            window.location = 'index.php';
                                        }
                                    })
                                });


                                /* <?php if($_SESSION['BranchID']==1){?>
                            window.location = 'Summary-All-F.php';
                        <?php }else{?>
                            window.location = 'Order-All.php';
                        <?php }?>*/

                            })
                        } else {
                            alert('Username หรือ Password ไม่ถูกต้อง!')
                            window.location = 'index.php';
                            //$('#check').text('Username หรือ Password ไม่ถูกต้อง!');
                        }

                    } else {
                        alert('Username หรือ Password ไม่ถูกต้อง!')
                        window.location = 'index.php';
                        //$('#check').text('Username หรือ Password ไม่ถูกต้อง!');
                    }
                }
            });
    });
</script>
<?php }?>
<!--<table align="center">
    <td align="center" valign="middle" height="500" width="1200">
        <h3 id="check"><br><br></h3>
    </td>
</table>-->