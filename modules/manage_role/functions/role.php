<?php
include("../../../Resources/sessions.php");

require_once("../../../classes/DBConnect.php");
require_once("../../../classes/Constants.php");
require_once("../classes/Role.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);
?>

<html>
<head>
    <?php
    include "../../../Resources/Dashboard/header.php"
    ?>
    <title>Manage Role | EGyaan</title>
    <script src="../../../Resources/jquery.min.js"></script>
    <script>

        $(document).ready(function () {

            $("#submit").click(function () {
                var role_name = $("#role_name").val();

                if (role_name == "") {
                    $("#role_err").text("Please enter the Name of the Role");
                    return false;
                }
                else {
                    $("#role_err").text("");
                }
            });

        });
    </script>

    <script>
        function del_confirm() {
            var x;
            if (confirm("Are you sure you want to delete it ?") == true) {

            } else {
                event.preventDefault();
            }
            //document.getElementById("demo").innerHTML = x;
        }

    </script>
</head>
<body>
<div class="wrapper">
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <br>
            <ol class="breadcrumb">
                <li><a href="../../login/functions/Dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                <li class="active"><b>Manage Roles</b></li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Manage Roles</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <form role="form" action="add_role.php" method="post" id="role">
                                <div class="form-group">
                                    <label>Role Name</label>
                                    <input class="form-control" type="text" name="role_name" id="role_name">
                                </div>
                                <div id="role_err"></div>
                                <div class="form-group">
                                    <input type="checkbox" class="flat" name="isTeacher" value=1>&nbsp;Is Teacher<br>
                                </div>
                                <button class="btn btn-primary" type="submit" value="Add Role" id="submit"><i
                                            class="fa fa-plus"></i>&nbsp; Add Role
                                </button>
                            </form>
                            <hr>

                            <?php
                            $i = 0;

                            $roles = new Role($dbConnect->getInstance());
                            $getRoles = $roles->getRole();

                            if ($getRoles != null) {
                                echo "<div class='box-header'>
                            <h3 class='box-title'><b>Roles</b></h3>
                        </div>";
                                echo "<table class='table table-bordered table-hover example2'>
				<thead>
					<th>Sr No.</th>
					<th>Role</th>
					<th>Is Teacher</th>
					<th>Assign Privilege</th>
					<th>Edit</th>
					<th>Delete</th>
					<th>View Privilege</th>
				</thead>
				<tbody>";
                                while ($row = $getRoles->fetch_assoc()) {
                                    $i++;
                                    $id = $row['id'];
                                    $name = $row['name'];
                                    $isTeacher = $row['is_teacher'];

                                    echo "<tr>";

                                    echo "<td>";
                                    echo $i;
                                    echo "</td>";

                                    echo "<td>";
                                    echo $name;
                                    echo "</td>";

                                    echo "<td>";
                                    if ($isTeacher == 1) {
                                        echo "Yes";
                                    } else {
                                        echo "No";
                                    }

                                    echo "</td>";

                                    echo "<td>";
                                    if ($id == Constants::ROLE_STUDENT_ID || $id == Constants::ROLE_PARENT_ID || $id == Constants::ROLE_TEACHER_ID || $id == Constants::ROLE_ADMIN_ID) {
                                        echo "Privileges for this role cannot be updated!";
                                    } else {
                                        echo "<form role='form' action=assign_privilege.php method=post><button class='btn btn-default' type=submit name=assign value='$id'>Assign</form>";
                                    }
                                    echo "</td>";

                                    echo "<td>";
                                    if ($id == Constants::ROLE_STUDENT_ID || $id == Constants::ROLE_PARENT_ID || $id == Constants::ROLE_TEACHER_ID || $id == Constants::ROLE_ADMIN_ID) {
                                        echo "Cannot be edited!";
                                    } else {
                                        echo "<form role='form' action=edit_role.php method=post><button class='btn btn-primary' type=submit name=edit value='$id'><i class='fa fa-pencil'></i>&nbsp;Edit</button></form>";
                                    }
                                    echo "</td>";

                                    echo "<td>";
                                    if ($id == Constants::ROLE_STUDENT_ID || $id == Constants::ROLE_PARENT_ID || $id == Constants::ROLE_TEACHER_ID || $id == Constants::ROLE_ADMIN_ID) {
                                        echo "Cannot be deleted!";
                                    } else {
                                        echo "<form role='form' action=delete_role.php method=post><button class='btn btn-danger' type=submit name=delete id=delete value='$id' onclick=del_confirm()><i class='fa fa-trash'></i>&nbsp;Delete</button></form>";
                                    }
                                    echo "</td>";

                                    echo "<td>";
                                    echo "<form role='form' action=view_privilege.php method=post><button class='btn btn-warning' type=submit name=view id=view value='$id'><i class='fa fa-eye'></i>&nbsp;View</button></form>";
                                    echo "</td>";

                                    echo "</tr>";
                                }
                                echo "</tbody></table>";
                            } else {
                                echo "No Records";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<?php
include "../../../Resources/Dashboard/footer.php";
?>
</body>
</html>
