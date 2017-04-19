<?php // Destry session if it hasn't been used for 15 minute.
session_start();
    $inactive = 900;
    if(isset($_SESSION['timeout']) ) 
    {
        $session_life = time() - $_SESSION['timeout'];
        if($session_life > $inactive)
        {
        header("Location: logout.php"); 
        }
    }
    $_SESSION['timeout'] = time();
    if (!isset($_SESSION["username"])) 
    {
        header("location: login.php"); 
        exit();
    }
include "db.php"; 
error_reporting(E_ALL); 
        ini_set('display_errors', 1);
            
?>
<?php 
$session_id = preg_replace('#[^0-9]#i', '', $_SESSION["id"]); // filter everything but numbers and letters
$username = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["username"]); // filter everything but numbers and letters
$password = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["password"]); // filter everything but numbers and letters
include "db.php"; 
$sql = $db->query("SELECT * FROM users WHERE loginId='$username' AND pwd='$password' LIMIT 1"); // query the person
// ------- MAKE SURE PERSON EXISTS IN DATABASE ---------
$existCount = mysqli_num_rows($sql); // count the row nums
if ($existCount > 0) { 
    while($row = mysqli_fetch_array($sql)){ 
             $thisid = $row["id"];
             $names = $row["names"];
             $account_type = $row["account_type"];
             if($account_type =='admin')
        {
            header("location: admin.php");
            exit();
        }
            }
        } 
        else{
        echo "
        
        <br/><br/><br/><h3>Your account has been temporally deactivated</h3>
        <p>Please contact: <br/><em>(+25) 0782010262</em><br/><b>uwamclemmy@gmail.com</b></p>       
        Or<p><a href='logout.php'>Click Here to login again</a></p>
        
        ";
        exit();
    }

?>
<?php
$memberList="";
$sqllist = $db->query("SELECT * FROM members ORDER BY id DESC");
$totalMembers = mysqli_num_rows($sqllist);
WHILE($row=mysqli_fetch_array($sqllist))
    {
        $memberList.='
        <tr>
            <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
            <td>'.$row['names'].'</td>
            <td>'.$row['phone'].'</td>
            <td>'.$row['houseNumber'].'</td>
            <td class="uk-text-center">
                <a href="#" class="ts_remove_row"><i class="md-icon material-icons">&#xE872;</i></a>
            </td>
        </tr>
        ';
    }
?>

<!doctype html>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en"> <!--<![endif]-->
<?php include'userheader.php' ;?>
    <!-- main sidebar -->
    <div id="page_content">
        <div id="page_content_inner">

            <h3><?php echo 'Manage '.$totalMembers.' members of '.$companyName.'';?></h3>
            <div class="uk-grid uk-grid-medium" data-uk-grid-margin="">
                <div class="uk-width-xLarge-8-10  uk-width-large-7-10">
                    <div class="md-card">
                        <div class="md-card-content">
                            <div class="uk-margin-bottom" id="status">
                                <a href="#" class="md-btn uk-margin-right">New</a>
                                <input type="file" name="file1" id="file1" onchange="uploadFile()" class="md-btn">
                                <a href="#" class="md-btn uk-margin-right" id="printTable">Print</a>
                                <div class="uk-button-dropdown" data-uk-dropdown="{mode:'click'}">
                                    <button class="md-btn">Columns <i class="uk-icon-caret-down"></i></button>
                                    <div class="uk-dropdown">
                                        <ul class="uk-nav uk-nav-dropdown" id="columnSelector"></ul>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-overflow-container uk-margin-bottom">
                                <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                                    <thead>
                                    <tr>
                                        <th data-name="Select" data-priority="1"><input type="checkbox" class="ts_checkbox_all"></th>
                                        <th data-priority="critical">Full Name</th>
                                        <th data-priority="1">Phone</th>
                                        <th data-priority="1">House Number</th>
                                        <th class="filter-false remove sorter-false uk-text-center" data-priority="1">Actions</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th>Full Name</th>
                                            <th>Phone</th>
                                            <th>House Number</th>
                                            <th class="uk-text-center">Actions</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php 
                                    echo $memberList;?>
                                    </tbody>
                                </table>
                            </div>
                            <ul class="uk-pagination ts_pager">
                                <li data-uk-tooltip title="Select Page">
                                    <select class="ts_gotoPage ts_selectize"></select>
                                </li>
                                <li class="first"><a href="javascript:void(0)"><i class="uk-icon-angle-double-left"></i></a></li>
                                <li class="prev"><a href="javascript:void(0)"><i class="uk-icon-angle-left"></i></a></li>
                                <li><span class="pagedisplay"></span></li>
                                <li class="next"><a href="javascript:void(0)"><i class="uk-icon-angle-right"></i></a></li>
                                <li class="last"><a href="javascript:void(0)"><i class="uk-icon-angle-double-right"></i></a></li>
                                <li data-uk-tooltip title="Page Size">
                                    <select class="pagesize ts_selectize">
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                    </select>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="uk-width-xLarge-2-10 uk-width-large-3-10 ">
                    <div class="md-card">
                        <div class="md-card-toolbar">
                            <h3 class="md-card-toolbar-heading-text">
                                BULK SMS
                            </h3>
                        </div>
                        <div class="md-card-content">
                            <div id="userdiv">
                                <select id="select_demo_4" data-md-selectize>
                                    <option value="">FROM...</option>
                                    <option value="a">Intwali</option>
                                </select></br>
                                <div class="md-input-wrapper">
                                    <label>BODY</label>
                                    <textarea class="md-input" name="name" id="name"></textarea>
                                    <span class="md-input-bar "></span>
                                </div></br>
                                COST: <?php 
                                $cost = number_format($totalMembers*16);
                                $balance = number_format(0);
                                echo $cost.'.00 Rwf<br>';
                                echo'BALANCE: '.$balance.'.00 Rwf<br>';
                                if($cost < $balance)
                                    {
                                        echo'<button onclick="updateUser()" class="md-btn md-btn-success">SEND</button>';
                                    }
                                else{
                                        ?>

                                        <button data-uk-modal="{target:'#modal_header_footer'}" class="md-btn md-btn-warning">BUY</button>
                                        <div class="uk-modal" id="modal_header_footer">
                                            <div class="uk-modal-dialog">
                                                <div class="uk-modal-header">
                                                    <h3 class="uk-modal-title">Buy <i class="material-icons" data-uk-tooltip="{pos:'top'}" title="You can pay with MTN Mobile money or Tigo Cash">&#xE8FD;</i></h3>
                                                </div>
                                                <p>Your MTN or TIGO number </br>
                                                    <input type="" class="md-input" name="">
                                                </p><div class="uk-modal-footer uk-text-right">
                                                    <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button><button data-uk-modal="{target:'#modal_new'}" type="button" class="md-btn md-btn-flat md-btn-flat-primary">BUY</button>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
            
            <div class="uk-modal" id="modal_daterange">
                <div class="uk-modal-dialog">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-small-1-2">
                            <div class="uk-input-group">
                                <span class="uk-input-group-addon"><i class="uk-input-group-icon uk-icon-calendar"></i></span>
                                <label for="ts_dp_start">Start Date</label>
                                <input class="md-input" type="text" id="ts_dp_start">
                            </div>
                        </div>
                        <div class="uk-width-small-1-2">
                            <div class="uk-input-group">
                                <span class="uk-input-group-addon"><i class="uk-input-group-icon uk-icon-calendar"></i></span>
                                <label for="ts_dp_end">End Date</label>
                                <input class="md-input" type="text" id="ts_dp_end">
                            </div>
                        </div>
                    </div>
                    <div class="uk-modal-footer uk-text-right">
                        <button type="button" class="md-btn md-btn-flat uk-modal-close">Cancel</button><button type="button" id="daterangeApply" class="md-btn md-btn-flat md-btn-flat-primary">Select range</button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- google web fonts -->
    <script>
        WebFontConfig = {
            google: {
                families: [
                    'Source+Code+Pro:400,700:latin',
                    'Roboto:400,300,500,700,400italic:latin'
                ]
            }
        };
        (function() {
            var wf = document.createElement('script');
            wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
            '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
            wf.type = 'text/javascript';
            wf.async = 'true';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(wf, s);
        })();
    </script>

    <!-- common functions -->
    <script src="assets/js/common.min.js"></script>
    <!-- uikit functions -->
    <script src="assets/js/uikit_custom.min.js"></script>
    <!-- altair common functions/helpers -->
    <script src="assets/js/altair_admin_common.min.js"></script>

    <!-- page specific plugins -->
    <!-- tablesorter -->
    <script src="bower_components/tablesorter/dist/js/jquery.tablesorter.min.js"></script>
    <script src="bower_components/tablesorter/dist/js/jquery.tablesorter.widgets.min.js"></script>
    <script src="bower_components/tablesorter/dist/js/widgets/widget-alignChar.min.js"></script>
    <script src="bower_components/tablesorter/dist/js/widgets/widget-columnSelector.min.js"></script>
    <script src="bower_components/tablesorter/dist/js/widgets/widget-print.min.js"></script>
    <script src="bower_components/tablesorter/dist/js/extras/jquery.tablesorter.pager.min.js"></script>
    <!-- ionrangeslider -->
    <script src="bower_components/ion.rangeslider/js/ion.rangeSlider.min.js"></script>

    <!--  tablesorter functions -->
    <script src="assets/js/pages/plugins_tablesorter.min.js"></script>
    
    <script>
        $(function() {
            if(isHighDensity()) {
                $.getScript( "bower_components/dense/src/dense.js", function() {
                    // enable hires images
                    altair_helpers.retina_images();
                });
            }
            if(Modernizr.touch) {
                // fastClick (touch devices)
                FastClick.attach(document.body);
            }
        });
        $window.load(function() {
            // ie fixes
            altair_helpers.ie_fix();
        });
    </script>

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-65191727-1', 'auto');
        ga('send', 'pageview');
    </script>

<script src="js/uploadFile.js"></script>
    
</body>
</html>
<!-- Localized -->