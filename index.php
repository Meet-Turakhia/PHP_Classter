<!DOCTYPE html>
<html lang="en" id="top">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/icon.png">
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/22d43b373b.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
    <title>Classter</title>

</head>

<body>

    <?php
    require("backend.php");
    session_start();
    if (!isset($_SESSION["username"])) {
        header("Location: login.php");
    }
    $error = NULL;
    $success = NULL;
    if ($_SESSION["position"] == "teacher" || $_SESSION["position"] == "hod") {
        $teacher_id = $_SESSION["user_id"];
    }
    if (isset($_POST["submit"])) {
        $name = $_POST["name"];
        $subject = $_POST["subject"];
        $branch_id = $_POST["branchid"];
        $result = $mysqli->query("SELECT * FROM class WHERE name = '$name' AND subject = '$subject' AND branch_id = '$branch_id'");
        $row = $result->fetch_assoc();
        if ($row) {
            $error = "class already exists, try again ❌";
        } else {
            $result = $mysqli->query("INSERT INTO class(name, subject, branch_id, teacher_id) values ('$name', '$subject', '$branch_id', '$teacher_id')");
            if (!$result) {
                $error = "some error occured, try again ❌";
            }
        }
    }


    if (isset($_GET["trash_id"])) {
        $trash_id = $_GET["trash_id"];
        $result = $mysqli->query("DELETE FROM class WHERE class_id = '$trash_id'");
        if ($result) {
            $success = "class deleted scuccessfully ✔";
        } else {
            $error = "some error occured, try again ❌";
        }
    }

    if (isset($_GET["edit_id"])) {
        echo '<script type="text/javascript">',
        "function editmodal() {
        console.log('hi');
        setTimeout(function () {
        $('#myModal').modal({backdrop: 'static', keyboard: false, show:true})          
        }, 1000);
        }",
        'editmodal();',
        '</script>';
    }

    if (isset($_POST["update"])) {
        $name = $_POST["name"];
        $subject = $_POST["subject"];
        $branch_id = $_POST["branchid"];
        $edit_id = $_GET["edit_id"];
        $result = $mysqli->query("SELECT * FROM class WHERE name = '$name' AND subject = '$subject' AND branch_id = '$branch_id' AND class_id != '$edit_id'");
        $row = $result->fetch_assoc();
        if ($row) {
            $error = "class already exists, try again ❌";
        } else {
            $result = $mysqli->query("UPDATE class SET name = '$name', subject = '$subject', branch_id = '$branch_id' WHERE class_id = '$edit_id'");
            if ($result) {
                $success = "class updated successfully ✔";
                $url = (explode("?", $_SERVER['HTTP_REFERER']));
                unset($_GET["edit_id"]);
                header("location:" . $url[0]);
            } else {
                $error = "some error occured try again ❌";
            }
        }
    }

    if (isset($_GET["logout"])) {
        session_destroy();
        header("location: login.php");
    }
    ?>

    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-lg">
        <a class="navbar-brand" href="index.php" style="font-size: 25px">
            <i class="fas fa-user-graduate" style="color: #009933;"></i> Classter
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
                        <i class="fas fa-chalkboard-teacher"></i> Class
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <?php
                        if ($_SESSION["position"] == "viewer" || $_SESSION["position"] == "admin") {
                            $classes = $mysqli->query("SELECT * FROM class INNER JOIN branch ON class.branch_id = branch.branch_id ORDER BY branch.branch_name");
                        } elseif ($_SESSION["position"] == "teacher") {
                            $classes = $mysqli->query("SELECT * FROM class INNER JOIN branch ON class.branch_id = branch.branch_id WHERE class.teacher_id = '$teacher_id' ORDER BY branch.branch_name");
                        } elseif ($_SESSION["position"] == "hod") {
                            $hod_id = $_SESSION["user_id"];
                            $classes = $mysqli->query("SELECT * FROM class INNER JOIN branch ON class.branch_id = branch.branch_id WHERE branch.hod_id = '$hod_id' ORDER BY branch.branch_name");
                        } elseif ($_SESSION["position"] == "student") {
                            $student_id = $_SESSION["user_id"];
                            $classes = $mysqli->query("SELECT * FROM class INNER JOIN branch ON class.branch_id = branch.branch_id INNER JOIN student_class ON class.class_id = student_class.class_id WHERE student_id = '$student_id'");
                        }
                        while ($class = $classes->fetch_assoc()) {
                        ?>
                            <a class="dropdown-item" id="link" href="viewclass.php?class_id=<?php echo $class["class_id"]; ?>">
                                <?php echo $class["name"]; ?>
                                <span> <?php echo $class["subject"]; ?></span>
                                <span> <?php echo $class["branch_name"]; ?></span>
                            </a>
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

    <?php if ($success) { ?>
        <div class="alert alert-success alert-dismissible fade show m-0" role="alert">
            <?php echo $success ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } elseif ($error) { ?>
        <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
            <?php echo $error ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } ?>

    <div class="container-fluid">

        <div class="center">
            <i class="fas fa-user-graduate mt-5" style="color: #009933; font-size: 50px;"></i>
            <h1 style="color:#009933;" class="ml2">Classter</h1>
        </div>

        <ul class="list-inline center mt-5">
            <li class="list-inline-item">
                <?php if ($_SESSION["position"] == "teacher") { ?>
                    <h3 class="basic">
                        All Your<span style="color: #009933;"> Classes</span>
                    </h3>
                <?php } elseif ($_SESSION["position"] == "hod") {
                    $hod_id = $_SESSION["user_id"];
                    $result = $mysqli->query("SELECT branch_name FROM branch WHERE hod_id = '$hod_id'");
                    $row = $result->fetch_assoc();
                ?>
                    <h3 class="basic">
                        List of <?php echo $row["branch_name"]; ?><span style="color: #009933;"> Classes</span>
                    </h3>
                <?php } elseif ($_SESSION["position"] == "student") { ?>
                    <h3 class="basic">
                        Your Enrolled<span style="color: #009933;"> Classes</span>
                    </h3>
                <?php } else { ?>
                    <h3 class="basic">
                        All Active<span style="color: #009933;"> Classes</span>
                    </h3>
                <?php } ?>
            </li>
            <?php if (!($_SESSION["position"] == "admin" || $_SESSION["position"] == "viewer" || $_SESSION["position"] == "student")) { ?>
                <li class="list-inline-item">
                    <a href="" style="color: black;" data-toggle="modal" data-target="#myModal">
                        <i class="fa fa-plus-circle basic" title="Create a class" id="addclass" style="font-size: 30px;" aria-hidden="true"></i>
                    </a>
                </li>
            <?php } ?>
        </ul>

        <div class="modal fade" id="myModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <?php if (isset($_GET["edit_id"])) {
                        $edit_id = $_GET["edit_id"];
                        $result = $mysqli->query("SELECT * FROM class INNER JOIN branch ON class.branch_id = branch.branch_id WHERE class_id = '$edit_id'");
                        $row = $result->fetch_assoc();
                    } ?>
                    <div class="modal-header center">
                        <?php if (isset($edit_id)) { ?>
                            <h4 class="modal-title" style="color: #009933;">Edit Class</h4>
                        <?php } else { ?>
                            <h4 class="modal-title" style="color: #009933;">Create Class</h4>
                        <?php } ?>
                        <?php if (!isset($edit_id)) { ?>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <?php } ?>
                    </div>

                    <div class="modal-body center">
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="name">Class Name:</label>
                                <?php if (isset($edit_id)) { ?>
                                    <input type="text" value="<?php echo $row["name"]; ?>" class="form-control" name="name" placeholder="Enter Class Name:" required autocomplete="off">
                                <?php } else { ?>
                                    <input type="text" class="form-control" name="name" placeholder="Enter Class Name:" required autocomplete="off">
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="subject">Subject:</label>
                                <?php if (isset($edit_id)) { ?>
                                    <input type="text" value="<?php echo $row["subject"] ?>" class="form-control" name="subject" placeholder="Enter Subject:" required autocomplete="off">
                                <?php } else { ?>
                                    <input type="text" class="form-control" name="subject" placeholder="Enter Subject:" required autocomplete="off">
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="branch">Select Branch:</label>
                                <select class="form-control" name="branchid" required autocomplete="off">
                                    <?php if (isset($edit_id)) { ?>
                                        <option value="<?php echo $row["branch_id"]; ?>" selected>
                                            <?php
                                            echo $row["branch_name"];
                                            ?>
                                        </option>
                                        <?php
                                        $selected_branch = $row["branch_id"];
                                        $classresults = $mysqli->query("SELECT * FROM branch where branch_id != '$selected_branch'");
                                        while ($classrow = $classresults->fetch_assoc()) { ?>
                                            <option value="<?php echo $classrow["branch_id"]; ?>">
                                                <?php
                                                echo $classrow["branch_name"];
                                                ?>
                                            </option>
                                        <?php } ?>
                                    <?php } elseif ($_SESSION["position"] == "hod") { ?>
                                        <?php
                                        $classresults =  $mysqli->query("SELECT * FROM branch where hod_id = '$hod_id'");
                                        while ($classrow = $classresults->fetch_assoc()) { ?>
                                            <option value="<?php echo $classrow["branch_id"]; ?>">
                                                <?php
                                                echo $classrow["branch_name"];
                                                ?>
                                            </option>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <?php
                                        $classresults =  $mysqli->query("SELECT * FROM branch");
                                        while ($classrow = $classresults->fetch_assoc()) { ?>
                                            <option value="<?php echo $classrow["branch_id"]; ?>">
                                                <?php
                                                echo $classrow["branch_name"];
                                                ?>
                                            </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <?php if (!isset($edit_id)) { ?>
                                <button type="submit" class="btn btn-success" name="submit">Submit</button><br>
                            <?php } else { ?>
                                <button type="Update" class="btn btn-success" name="update">Update</button><br>
                            <?php } ?>
                            <?php
                            ?>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <div class="card-columns" style="margin: 5% 10% 4% 10%;">
            <?php
            if ($_SESSION["position"] == "teacher") {
                $classes = $mysqli->query("SELECT * FROM class INNER JOIN branch ON class.branch_id = branch.branch_id WHERE teacher_id = '$teacher_id'");
            } elseif ($_SESSION["position"] == "hod") {
                $classes = $mysqli->query("SELECT * FROM class INNER JOIN branch ON class.branch_id = branch.branch_id WHERE branch.hod_id = '$hod_id'");
            } elseif ($_SESSION["position"] == "student") {
                $student_id = $_SESSION["user_id"];
                $classes = $mysqli->query("SELECT * FROM class INNER JOIN branch ON class.branch_id = branch.branch_id INNER JOIN student_class ON class.class_id = student_class.class_id WHERE student_id = '$student_id'");
            } else {
                $classes = $mysqli->query("SELECT * FROM class INNER JOIN branch ON class.branch_id = branch.branch_id ORDER BY branch.branch_name");
            }
            while ($class = $classes->fetch_assoc()) {
            ?>
                <div class="card border-success mb-5" id="cardshadow">
                    <div class="card-header bg-success"><span class="text-light"><?php echo $class["name"]; ?></span> <span class="text-light"> <?php echo $class["branch_name"]; ?></span>
                        <?php if (!($_SESSION["position"] == "viewer" || $_SESSION["position"] == "student")) { ?>
                            <span>
                                <a onclick="return confirm('Are you sure, you want to delete the class?')" href="index.php?trash_id=<?php echo $class["class_id"]; ?>"><i class="fas fa-trash ml-3 text-light" style="float: right;"></i></a>
                                <a href="index.php?edit_id=<?php echo $class["class_id"]; ?>"><i class="fas fa-edit text-light" style="float: right;"></i></a>
                            </span>
                        <?php } ?>
                    </div>
                    <a href="viewclass.php?class_id=<?php echo $class['class_id']; ?>" style="text-decoration: none;">
                        <div class="card-body text-success">
                            <h5 class="card-title"><span style="color: black;">Subject: </span><?php echo $class["subject"]; ?></h5>
                            <?php
                            $id = $class["teacher_id"];
                            $teacherfetch = $mysqli->query("SELECT username FROM userdetails WHERE user_id = '$id'");
                            $teacher = $teacherfetch->fetch_assoc();
                            ?>
                            <p class="card-text"><span style="color: black;">Teacher: </span><?php echo $teacher["username"]; ?></p>
                        </div>
                    </a>
                </div>
            <?php } ?>
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
                    <p style="line-height: 1.7rem">Classter is a virtual classroom management sytem with college hierarchy which lets
                        teachers make classes, the viewers can view them, the students can login and vew their details and admin and hod have respective powers</p>
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

        <div class="footer-copyright text-center py-3"> Made by
            Meet Turakhia
        </div>

    </footer>

    <script language="javascript" type="text/javascript" src="assets/javascript/index.js"></script>
</body>

</html>