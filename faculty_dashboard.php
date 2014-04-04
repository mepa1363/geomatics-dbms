<?php
include('session_manager.php');
include ('gatekeeper.php');

if (!admin_gatekeeper()) {
    header('Location: student_dashboard.php');
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <link rel="shortcut icon" type="image/ico" href="images/favicon.ico"/>

    <title>Faculty Members Dashboard</title>

    <style type="text/css" title="currentStyle">
        @import "css/demo_page.css";
        @import "css/demo_table.css";
        @import "css/demo_table_jui.css";
        @import "css/aristo.css";
        @import "css/TableTools_JUI.css";
    </style>
    <link rel="stylesheet" type="text/css" href="style_template/style_template.css"/>
    <link rel="stylesheet" type="text/css" href="css/calendar.css"/>
    <style type="text/css">
        tr.odd {
            background-color: #E9E9E9;
        }

        tr.even {
            background-color: #F2F2F2;
        }

        tr.odd td.sorting_1 {
            background-color: #C8EFFE;
        }

        tr.even td.sorting_1 {
            background-color: #91E0FE;
        }

        .dataTables_filter {
            width: 40%;
        }

        .dataTables_length {
            width: 30%;
        }
    </style>
    <script type="text/javascript" src="js/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="js/jquery.validate.js"></script>
    <script type="text/javascript" src="js/jquery.placeholder.js"></script>
    <script type="text/javascript" src="js/jquery.form.js"></script>

    <script type="text/javascript" src="js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="js/TableTools.js"></script>
    <script type="text/javascript" src="js/ZeroClipboard.js"></script>


    <script type="text/javascript">
        var oTable;
        $(document).ready(function () {

            var offset = $("#sidebar_animate").offset();
            var topPadding = 15;
            $(window).scroll(function () {
                if ($(window).scrollTop() > offset.top) {
                    $("#sidebar_animate").stop().animate({
                        marginTop:$(window).scrollTop() - offset.top + topPadding
                    });
                } else {
                    $("#sidebar_animate").stop().animate({
                        marginTop:0
                    });
                }
            });

            oTable = $('#example').dataTable({
                "bProcessing":true,
                "bServerSide":true,
                //"sServerMethod": "GET",
                "sPaginationType":"full_numbers",
                "sAjaxSource":"faculty_process.php",
                //"sScrollX":"100%",
                //"sScrollXInner": "150%",
                //"bScrollCollapse":true,
                "bJQueryUI":true,
                //"bAutoWidth": false
                "sDom":'<"H"lTfr>t<"F"ip>',
                "oTableTools":{
                    "sSwfPath":"style_template/copy_csv_xls_pdf.swf",
                    "aButtons":[
                        {
                            "sExtends":"xls",
                            "bHeader":true,
                            "bFooter":false,
                            "mColumns":"visible"
                        },
                        {
                            "sExtends":"pdf",
                            "sPdfOrientation":"landscape",
                            "bHeader":true,
                            "bFooter":false,
                            "mColumns":"visible"
                        },
                        "print"
                    ]
                },
                "aaSorting":[
                    [ 2, "asc" ]
                ],
                "aoColumns":[
                    {"bVisible":false, "bSearchable":false},
                    {"sWidth":110},
                    {"sWidth":110}
                ]


            });

            $("#example tbody").click(function (event) {
                $(oTable.fnSettings().aoData).each(function () {
                    $(this.nTr).removeClass('row_selected');
                });
                $(event.target.parentNode).addClass('row_selected');
                $('#faculty_id_update').val(getSelectedId());
                $('#faculty_first_name_update').val(getSelectedFirstName());
                $('#faculty_last_name_update').val(getSelectedLastName());
            });

        });

        function getSelectedId() {
            var anSelected = fnGetSelected(oTable);
            var data = anSelected[0];
            //getting hidden column value
            var selected_id = oTable.fnGetData(data, 0);
            return selected_id;
        }

        function getSelectedFirstName() {
            var anSelected = fnGetSelected(oTable);
            var data = anSelected[0];
            //getting hidden column value
            var selected_first_name = oTable.fnGetData(data, 1);
            return selected_first_name;
        }

        function getSelectedLastName() {
            var anSelected = fnGetSelected(oTable);
            var data = anSelected[0];
            //getting hidden column value
            var selected_last_name = oTable.fnGetData(data, 2);
            return selected_last_name;
        }

        function fnGetSelected(oTableLocal) {
            var aReturn = new Array();
            var aTrs = oTableLocal.fnGetNodes();
            for (var i = 0; i < aTrs.length; i++) {
                if ($(aTrs[i]).hasClass('row_selected')) {
                    aReturn.push(aTrs[i]);
                }
            }
            return aReturn;
        }

        function display_items_toggle(div1, div2) {
            if ($('#' + div1).is(':visible')) {
                $('#' + div1).fadeOut('fast');
                $('#' + div2).css('color', '#67686A');
                $('#' + div2).css('background', '#F1F1F1');
                $('#' + div2).css('border-radius', '5px');
                $('#' + div2).css('font-weight', 'normal');
            } else if ($('#' + div1).is(':hidden')) {
                $('#' + div1).fadeIn('fast');
                $('#' + div2).css('color', '#ffffff');
                $('#' + div2).css('background', '#8DC63F');
                $('#' + div2).css('border-radius', '5px');
                $('#' + div2).css('font-weight', 'bold');
            }
        }

    </script>
</head>
<body id="dt_example">
<div id="main">
    <div id="header">
        <div id="logo">
            <img src="images/ucalgary2.png" style="width: 100px;">
            <img src="images/geoamtics2.png" style="width: 90px; position: relative; float: right; margin-top: 3px;">

            <div id="logo_text">
                <img src="images/logo6.png" style="height: 120px; margin-left: 0px;">
            </div>
        </div>
        <div id="menubar">
            <ul id="menu">
                <!-- put class="selected" in the li tag for the selected page - to highlight which page you're on -->
                <li><a href="student_dashboard.php">Students</a></li>
                <li class="selected"><a href="#">Faculty Members</a></li>
                <li><a href="users_dashboard.php">Users</a></li>
                <li><a href="ip_settings.php">IPs</a></li>
            </ul>
            <ul id="menu_logout">
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
    <div id="content_header"></div>
    <div id="site_content">
        <div id="sidebar_animate" class="sidebar">
            <!-- insert your sidebar items here -->
            <h1>Tools</h1>
            <ul>
                <li><a href="#" id="add_faculty"
                       onclick="display_items_toggle('add_faculty_form','add_faculty')">Add</a></li>
                <form id="add_faculty_form" method="post" action="add_faculty_process.php" style="display: none;">
                    <fieldset>
                        First Name: <input type="text" name="faculty_first_name" style="width: 100px;">
                        Last Name: <input type="text" name="faculty_last_name" style="width: 100px;">
                        <input type="submit" name="submit" class="button" value="Add Faculty Member"
                               style="margin-left: 10px;">
                    </fieldset>
                </form>
                <li><a href="#" id="update_faculty"
                       onclick="display_items_toggle('update_faculty_form','update_faculty')">Update</a>
                </li>
                <form id="update_faculty_form" method="post" action="update_faculty_process.php" style="display: none;">
                    <fieldset>
                        <input type="hidden" id="faculty_id_update" name="faculty_id" style="width: 100px;">
                        First Name: <input type="text" id="faculty_first_name_update" name="faculty_first_name"
                                           style="width: 100px;">
                        Last Name: <input type="text" id="faculty_last_name_update" name="faculty_last_name"
                                          style="width: 100px;">
                        <input type="submit" name="submit" class="button" value="Update Faculty Member"
                               style="margin-left: 5px;">
                    </fieldset>
                </form>
            </ul>
        </div>
        <div id="content">
            <h1>Welcome to Faculty Members Dashboard</h1>

            <div id="dynamic">
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td colspan="5" class="dataTables_empty">Loading data from server</td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <div class="spacer"></div>
        </div>
    </div>
</div>
<div id="content_footer"></div>
<div id="footer">
    <p><a href="student_dashboard.php">Students</a> | <a href="faculty_dashboard.php">Faculty Members</a> | <a
            href="users_dashboard.php">Users</a> | <a href="ip_settings.php">IPs</a>
    </p>

    <p>Copyright &copy; department of geomatics engineering 2012</p>
</div>

</body>
</html>