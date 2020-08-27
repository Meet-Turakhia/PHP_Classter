<!DOCTYPE html>
<html lang="en" id="top">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/icon.png">
    <link rel="stylesheet" href="assets/css/viewclass.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
    <title>Class Page</title>

</head>

<body>

    <?php
    require("backend.php");
    session_start();
    if (!isset($_SESSION["username"])) {
        header("Location: login.php");
    }
    $class_id = $_GET["class_id"];
    $error = NULL;
    $success = NULL;
    $edit_id = NULL;
    if (isset($_POST["submit"])) {
        $roll_no = $_POST["rollno"];
        $fullname = $_POST["fullname"];
        $email = $_POST["email"];
        $phone = $_POST["phoneno"];
        $cgpa = $_POST["cgpa"];
        $result = $mysqli->query("SELECT * FROM student WHERE roll_no ='$roll_no'");
        while ($row = $result->fetch_assoc()) {
            $repeatno_id = $row["student_id"];
            $result = $mysqli->query("SELECT * FROM student_class WHERE student_id = '$repeatno_id' AND class_id = '$class_id'");
            $row = $result->fetch_assoc();
            if ($row) {
                $error = "Roll no already exists in classroom, try again!";
            }
        }
        if ($error != "Roll no already exists in classroom, try again!") {
            $result2 = $mysqli->query("SELECT * FROM student WHERE roll_no = '$roll_no' AND email = '$email'");
            $row2 = $result2->fetch_assoc();
            if ($row2) {
                $student_id = $row2["student_id"];
                $result = $mysqli->query("INSERT INTO student_class(class_id, student_id) VALUES($class_id, $student_id)");
                if ($result) {
                    $success = "student added successfully!";
                } else {
                    $error = $mysqli->error;
                }
            } else {
                $result = $mysqli->query("INSERT INTO student(roll_no, fullname, email, phone, cgpa) VALUES('$roll_no', '$fullname', '$email', '$phone', '$cgpa')");
                if ($result) {
                    $id_fetch = $mysqli->query("SELECT student_id FROM student WHERE roll_no = '$roll_no' AND email = '$email'");
                    $id_row = $id_fetch->fetch_assoc();
                    $student_id = $id_row["student_id"];
                    $result2 = $mysqli->query("INSERT INTO student_class(class_id, student_id) VALUES('$class_id', '$student_id')");
                    if ($result && $result2) {
                        $success = "student added successfully!";
                    } else {
                        $error = "some error occured, try again!";
                    }
                } else {
                    $error = "email already exists, try again!";
                }
            }
        }
    }

    if (isset($_POST["submit2"])) {
        $email = $_POST["email"];
        $result = $mysqli->query("SELECT * FROM student WHERE email = '$email'");
        $row = $result->fetch_assoc();
        $student_id = $row["student_id"];
        $roll_no = $row["roll_no"];
        $result2 = $mysqli->query("SELECT * FROM student WHERE roll_no ='$roll_no'");
        while ($row2 = $result2->fetch_assoc()) {
            $repeatno_id = $row2["student_id"];
            $result = $mysqli->query("SELECT * FROM student_class WHERE student_id = '$repeatno_id' AND class_id = '$class_id'");
            $row = $result->fetch_assoc();
            if ($row) {
                $error = "Roll no already exists in classroom, try again!";
            }
        }
        if ($error != "Roll no already exists in classroom, try again!") {
            $result2 = $mysqli->query("INSERT INTO student_class(class_id, student_id) values ('$class_id', '$student_id')");
            if ($result2) {
                $success = "Student added successfully!";
            } else {
                $error = "some error occurred, try again!";
            }
        }
    }

    if (isset($_GET["delete_id"])) {
        $delete_id = $_GET["delete_id"];
        $result = $mysqli->query("DELETE FROM student_class WHERE student_id = '$delete_id' AND class_id = '$class_id'");
        if ($result) {
            $success = "row deleted successfully!";
            $result = $mysqli->query("SELECT * FROM student_class WHERE student_id = '$delete_id'");
            $row = $result->fetch_assoc();
            if (!$row) {
                $result = $mysqli->query("DELETE FROM student WHERE student_id = '$delete_id'");
            }
        }
    }

    if (isset($_GET["edit_id"])) {
        echo '<script type="text/javascript">',
            "function editmodal() {
        console.log('hi');
        setTimeout(function () {
            $('#myModal').modal({backdrop: 'static', keyboard: false, show:true});
        }, 1000);
        }",
            'editmodal();',
            '</script>';
    }

    if (isset($_POST["update"])) {
        $roll_no = $_POST["rollno"];
        $fullname = $_POST["fullname"];
        $email = $_POST["email"];
        $phone = $_POST["phoneno"];
        $cgpa = $_POST["cgpa"];
        $result = $mysqli->query("SELECT * FROM student WHERE roll_no ='$roll_no' AND email != '$email'");
        while ($row = $result->fetch_assoc()) {
            $repeatno_id = $row["student_id"];
            $result = $mysqli->query("SELECT * FROM student_class WHERE student_id = '$repeatno_id' AND class_id = '$class_id'");
            $row = $result->fetch_assoc();
            if ($row) {
                $error = "Roll no already exists in classroom, try again!";
            }
        }
        if ($error != "Roll no already exists in classroom, try again!") {
            $edit_id = $_GET["edit_id"];
            $result = $mysqli->query("UPDATE student SET roll_no = '$roll_no', fullname = '$fullname', email = '$email', phone = '$phone', cgpa = '$cgpa' WHERE student_id = '$edit_id'");
            if ($result) {
                $success = "student details updated successfully!";
                $url = (explode("&", $_SERVER['HTTP_REFERER']));
                unset($_GET["edit_id"]);
                header("location:" . $url[0]);
            } else {
                $error = "email already exists in classroom, try again!";
            }
        }
    }

    if (isset($_GET["logout"])) {
        session_destroy();
        header("location: login.php");
    }
    ?>

    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-lg">
        <a class="navbar-brand" href="#" style="font-size: 25px">
            <i class="fas fa-user-graduate" style="color: #009933;"></i> Student Portal
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" id="link" href="index.php"><i class="fas fa-home"></i> Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="link" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-users"></i> Class
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <?php
                        $classes = $mysqli->query("SELECT * FROM class INNER JOIN branch ON class.branch_id = branch.branch_id");
                        while ($class = $classes->fetch_assoc()) {
                        ?>
                            <a class="dropdown-item" id="link" href="viewclass.php?class_id=<?php echo $class["class_id"]; ?>">
                                <?php echo $class["name"]; ?>
                                <span> <?php echo $class["subject"]; ?></span>
                                <span> <?php echo $class["branch_name"]; ?></span></a>
                        <?php } ?>
                    </div>
                </li>
            </ul>
            <ul class="nav navbar-nav ml-auto">
                <li>
                    <h5 class="mt-2 mr-2" style="color: #009933;">Welcome,
                        <?php
                        echo $_SESSION["username"];
                        ?>
                    </h5>
                </li>
                <form action="">
                    <li class="nav-item">
                        <button type="submit" name="logout" class="btn" id="link"><i class="fas fa-sign-out-alt"></i><span class="sr-only">(current)</span></button>
                    </li>
                </form>
            </ul>
        </div>
    </nav>

    <div class="container bannercontainer">
        <img class="mt-5 mb-5 center" src="assets/images/greenbanner.jpg" alt="bookclub banner" width="90%" height="auto" style="image-rendering: pixelated; border-radius: 5px;">
        <div class="top-left">
            <div class="row">
                <h1 id="banner-heading">
                    <?php
                    $result = $mysqli->query("SELECT * FROM class INNER JOIN userdetails ON class.teacher_id = userdetails.user_id WHERE class_id='$class_id'");
                    $result2 = $mysqli->query("SELECT * FROM class INNER JOIN branch ON class.branch_id = branch.branch_id WHERE class_id='$class_id'");
                    $row = $result->fetch_assoc();
                    $row2 = $result2->fetch_assoc();
                    echo $row["subject"];
                    ?></h1>
            </div>
            <div class="row">
                <h2 id="banner-text">
                    <?php echo $row["name"]; ?>
                    <span><?php echo $row2["branch_name"]; ?></span>
                </h2>
            </div>
            <div class="row">
                <h2 id="banner-text">
                    <?php echo "Teacher: " . $row["username"] ?>
                </h2>
            </div>
        </div>
    </div>

    <div class="container center">

        <ul class="list-inline mt-3 mb-5">
            <li class="list-inline-item">
                <?php if ($_SESSION["position"] != "viewer") { ?>
                    <h3 class="basic">
                        Add<span style="color: #009933;"> Students</span>
                    </h3>
                <?php } else { ?>
                    <h3 class="basic">
                        List of<span style="color: #009933;"> Students</span>
                    </h3>
                <?php } ?>
            </li>
            <?php if ($_SESSION["position"] != "viewer") { ?>
                <li class="list-inline-item">
                    <a href="" style="color: black;" data-toggle="modal" data-target="#myModal">
                        <i class="fa fa-plus-circle basic" title="Add Student" id="addstudents" style="font-size: 30px;" aria-hidden="true"></i>
                    </a>
                </li>
            <?php } ?>
        </ul>

        <div class="modal fade" id="myModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header center">
                        <?php
                        if (isset($_GET["edit_id"])) {
                            $edit_id = $_GET["edit_id"];
                            $getinfo = $mysqli->query("SELECT * FROM student WHERE student_id = '$edit_id'");
                            $studentinfo = $getinfo->fetch_assoc();
                            if (!$result) {
                                $error = "some error occurred, try again!";
                            }
                        }
                        ?>
                        <?php if ($edit_id) { ?>
                            <h4 class="modal-title" style="color: #009933;">Edit Student</h4>
                        <?php } else { ?>
                            <h4 class="modal-title" style="color: #009933;">Add Student</h4>
                        <?php } ?>
                        <?php if (!$edit_id) { ?>
                            <a href="viewclass.php?class_id=<?php echo $class_id; ?>" name="close" class="close" data-dismiss="modal">&times;</a>
                        <?php } ?>
                    </div>

                    <div class="modal-body">
                        <form action="" method="POST" id="nonexisting">
                            <div class="form-group">
                                <label for="rollno">Roll No:</label>
                                <?php if ($edit_id) { ?>
                                    <input type="text" value="<?php echo $studentinfo["roll_no"]; ?>" class="form-control" name="rollno" placeholder="Enter Roll No:" required autocomplete="off">
                                <?php } else { ?>
                                    <input type="text" class="form-control" name="rollno" placeholder="Enter Roll No:" required autocomplete="off">
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="fullname">Fullname:</label>
                                <?php if ($edit_id) { ?>
                                    <input type="text" value="<?php echo $studentinfo["fullname"]; ?>" class="form-control" name="fullname" placeholder="Enter Full Name:" required autocomplete="off">
                                <?php } else { ?>
                                    <input type="text" class="form-control" name="fullname" placeholder="Enter Full Name:" required autocomplete="off">
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <?php if ($edit_id) { ?>
                                    <input type="email" value="<?php echo $studentinfo["email"]; ?>" class="form-control" name="email" placeholder="Enter Email:" required autocomplete="off">
                                <?php } else { ?>
                                    <input type="email" class="form-control" name="email" placeholder="Enter Email:" required autocomplete="off">
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="phoneno">Phone No:</label>
                                <?php if ($edit_id) { ?>
                                    <input type="tel" value="<?php echo $studentinfo["phone"]; ?>" class="form-control" name="phoneno" placeholder="Enter Phone No:" pattern="^((\+){1}91){1}[1-9]{1}[0-9]{9}$" title="Use Indian Pattern, eg:- +919999999999" required autocomplete="off">
                                <?php } else { ?>
                                    <input type="tel" class="form-control" name="phoneno" placeholder="Enter Phone No:" pattern="^((\+){1}91){1}[1-9]{1}[0-9]{9}$" title="Use Indian Pattern, eg:- +919999999999" required autocomplete="off">
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="cgpa">cgpa:</label>
                                <?php if ($edit_id) { ?>
                                    <input type="text" value="<?php echo $studentinfo["cgpa"]; ?>" class="form-control" name="cgpa" placeholder="Enter CGPA:" required autocomplete="off">
                                <?php } else { ?>
                                    <input type="text" class="form-control" name="cgpa" placeholder="Enter CGPA:" required autocomplete="off">
                                <?php } ?>
                            </div>
                            <?php if (!$edit_id) { ?>
                                <button type="submit" class="btn btn-success" name="submit">Submit</button><br>
                            <?php } else { ?>
                                <button type="submit" class="btn btn-success" name="update">Update</button><br>
                            <?php } ?>
                            <?php
                            if ($error) {
                                echo "<small style='color: red;'>" . $error . "</small>";
                            }
                            if ($success) {
                                echo "<small style='color: green;'>" . $success . "</small>";
                            }
                            ?>
                        </form>

                        <form action="" method="POST" id="preexisting">
                            <div class="form-group">
                                <label for="email">Select Email:</label>
                                <select class="form-control" onfocus='this.size=3;' onblur='this.size=1;' onchange='this.size=1; this.blur();' name="email">
                                    <?php
                                    $repeat_email = array();
                                    $repeat_email2 = array();
                                    $result = $mysqli->query("SELECT email FROM student INNER JOIN student_class ON student.student_id = student_class.student_id WHERE student_class.class_id != '$class_id'");
                                    $result2 = $mysqli->query("SELECT email FROM student INNER JOIN student_class ON student.student_id = student_class.student_id WHERE student_class.class_id = '$class_id'");
                                    while ($row = $result->fetch_assoc()) {
                                        array_push($repeat_email, $row["email"]);
                                    }
                                    while ($row2 = $result2->fetch_assoc()) {
                                        array_push($repeat_email2, $row2["email"]);
                                    }
                                    $unique_email = array_diff($repeat_email, $repeat_email2);
                                    foreach ($unique_email as $email) {
                                    ?>
                                        <option><?php echo $email; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success" name="submit2">Submit</button><br>
                            <?php
                            if ($error) {
                                echo "<small style='color: red;'>" . $error . "</small>";
                            }
                            if ($success) {
                                echo "<small style='color: green;'>" . $success . "</small>";
                            }
                            ?>
                        </form>
                        <?php if (!$edit_id) { ?>
                            <br>
                            <button class="btn btn-success" type="button" id="prebtn">Preexisting</button><span> <button class="btn btn-success" type="button" id="nonbtn">Nonexisting</button></span><br>
                        <?php } ?>
                    </div>

                </div>
            </div>
        </div>

        <div class="table-responsive table-left mb-5">
            <table class="table">
                <thead class="bg-success">
                    <tr>
                        <th scope="col">Roll no</th>
                        <th scope="col">Fullname</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone No</th>
                        <th scope="col">CGPA</th>
                        <?php if ($_SESSION["position"] != "viewer") { ?>
                            <th scope="col">Action</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody class="table-success parent">
                    <?php
                    $students = $mysqli->query("SELECT * FROM student ORDER BY roll_no");
                    while ($studentrow = $students->fetch_assoc()) {
                        $student_id = $studentrow["student_id"];
                        $relation = $mysqli->query("SELECT * FROM student_class WHERE student_id = '$student_id' AND class_id = '$class_id'");
                        $relationrow = $relation->fetch_assoc();
                        if ($relationrow) {
                    ?>
                            <tr>
                                <td><?php echo $studentrow["roll_no"]; ?></td>
                                <td><?php echo $studentrow["fullname"]; ?></td>
                                <td><?php echo $studentrow["email"]; ?></td>
                                <td><?php echo $studentrow["phone"]; ?></td>
                                <td><?php echo $studentrow["cgpa"]; ?></td>
                                <?php if ($_SESSION["position"] != "viewer") { ?>
                                    <td><a name="edit" id="edit" href="viewclass.php?class_id=<?php echo $class_id; ?>&edit_id=<?php echo $studentrow["student_id"]; ?>" class="text-success mb-1 mr-3"><i class="fas fa-edit"></i></a>
                                        <span><a name="delete" onclick="return confirm('Are you sure, you want to delete the record?')" href="viewclass.php?class_id=<?php echo $class_id; ?>&delete_id=<?php echo $studentrow["student_id"]; ?>" class="text-success mb-1"><i class="fas fa-trash"></i></a></span>
                                    </td>
                                <?php } ?>
                            </tr>
                    <?php }
                    } ?>
                </tbody>
            </table>

        </div>

    </div>

    <footer class="page-footer font-small bg-light footer-border" style="border-top: 2px solid black !important;">

        <div class="container">

            <div class="row text-center d-flex justify-content-center pt-5 mb-3">
                <div class="col-md-2 mb-3">
                    <h6 class="text-uppercase font-weight-bold">
                        <a href="#top" style="color: #009933;">Top <i class="fas fa-arrow-up"></i></a>
                    </h6>
                </div>
            </div>
            <hr class="rgba-white-light" style="margin: 0 15%;">
            <div class="row d-flex text-center justify-content-center mb-md-0 mb-4">
                <div class="col-md-8 col-12 mt-5">
                    <p style="line-height: 1.7rem">Sed ut perspiciatis unde omnis iste natus error sit voluptatem
                        accusantium doloremque laudantium, totam rem
                        aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt
                        explicabo.
                        Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia
                        consequuntur.</p>
                </div>
            </div>
            <hr class="clearfix d-md-none rgba-white-light" style="margin: 10% 15% 5%;">
            <div class="row pb-3">
                <div class="col-md-12">
                    <div class="mb-2 mt-4 center">
                        <a href="#" class="text-decoration-none">
                            <i class="fab fa-facebook-f fa-lg mr-4" style="color: black; font-size:22px;" onmouseover="this.style.color='#009933'; this.style.fontSize='28px';" onmouseout="this.style.color='black'; this.style.fontSize='22px';"></i>
                        </a>
                        <a href="#" class="text-decoration-none">
                            <i class="fab fa-twitter fa-lg mr-4" style="color: black; font-size:22px;" onmouseover="this.style.color='#009933'; this.style.fontSize='28px';" onmouseout="this.style.color='black'; this.style.fontSize='22px';"></i>
                        </a>
                        <a href="#" class="text-decoration-none">
                            <i class="fab fa-google-plus-g fa-lg mr-4" style="color: black; font-size:22px;" onmouseover="this.style.color='#009933'; this.style.fontSize='28px';" onmouseout="this.style.color='black'; this.style.fontSize='22px';"></i>
                        </a>
                        <a href="#" class="text-decoration-none">
                            <i class="fab fa-linkedin-in fa-lg mr-4" style="color: black; font-size:22px;" onmouseover="this.style.color='#009933'; this.style.fontSize='28px';" onmouseout="this.style.color='black'; this.style.fontSize='22px';"></i>
                        </a>
                        <a href="#" class="text-decoration-none">
                            <i class="fab fa-instagram fa-lg mr-4" style="color: black; font-size:22px;" onmouseover="this.style.color='#009933'; this.style.fontSize='28px';" onmouseout="this.style.color='black'; this.style.fontSize='22px';"></i>
                        </a>
                        <a href="#" class="text-decoration-none">
                            <i class="fab fa-pinterest fa-lg" style="color: black; font-size:22px;" onmouseover="this.style.color='#009933'; this.style.fontSize='28px';" onmouseout="this.style.color='black'; this.style.fontSize='22px';"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <div class="footer-copyright text-center py-3">Made by
            <a href="https://github.com/Meet-Turakhia"> Meet Turakhia</a>
        </div>

    </footer>

    <script language="javascript" type="text/javascript" src="assets/javascript/viewclass.js"></script>
</body>

</html>