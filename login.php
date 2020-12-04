<!DOCTYPE html>
<html lang="en" id="top">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/icon.png">
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
    <title>Login || Register</title>

</head>

<body>

    <?php
    session_start();
    if (isset($_SESSION["username"])) {
        header("Location: index.php");
    } else {
        require("backend.php");
        $error = NULL;
        $success = NULL;
        if (isset($_POST["login"])) {
            $email = $_POST["email"];
            $password = $_POST["password"];
            $studentcheck = $_POST["studentcheck"];
            if ($studentcheck == "on") {
                $password = sha1($password);
                $result = $mysqli->query("SELECT * FROM student WHERE email = '$email' AND password = '$password'");
                if ($row = $result->fetch_assoc()) {
                    session_start();
                    $result = $mysqli->query("SELECT * FROM student WHERE email = '$email' AND password = '$password'");
                    $row = $result->fetch_assoc();
                    $_SESSION['username'] = $row["fullname"];
                    $_SESSION['position'] = "student";
                    $_SESSION['user_id'] = $row["student_id"];
                    $_SESSION['email_id'] = $row["email"];
                    header("Location:index.php");
                } else {
                    $error =  "Invalid username or password ❌";
                }
            } else {
                $password = sha1($password);
                $result = $mysqli->query("SELECT * FROM userdetails WHERE email_id = '$email' AND password = '$password'");
                if ($row = $result->fetch_assoc()) {
                    session_start();
                    $result = $mysqli->query("SELECT * FROM userdetails WHERE email_id = '$email' AND password = '$password'");
                    $row = $result->fetch_assoc();
                    $_SESSION['username'] = $row["username"];
                    $_SESSION['position'] = $row["position"];
                    $_SESSION['user_id'] = $row["user_id"];
                    $_SESSION['email_id'] = $row["email_id"];
                    header("Location:index.php");
                } else {
                    $error =  "Invalid username or password ❌";
                }
            }
        }

        if (isset($_POST["register"])) {
            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $cpassword = $_POST["cpassword"];
            $position = $_POST["position"];
            $secret_code = $_POST["secretcode"];
            $class_id = $_POST["class"];
            $key = $mysqli->query("SELECT secret_code FROM statuscode WHERE position = '$position'");
            $key_row = $key->fetch_assoc();
            $key = $key_row["secret_code"];
            if ($secret_code != $key) {
                $error = "entered code for " . $position . " is incorrect ❌";
            } else {
                $usernamecheck = $mysqli->query("SELECT username FROM userdetails WHERE username = '$username'");
                $user_row = $usernamecheck->fetch_assoc();
                $emailcheck = $mysqli->query("SELECT email_id FROM userdetails WHERE email_id = '$email'");
                $email_row = $emailcheck->fetch_assoc();
                if ($user_row) {
                    $error = "Username exists, try another one ❌";
                } elseif ($email_row) {
                    $error = "email already exists, try another one ❌";
                } else {
                    if ($password == $cpassword) {
                        $password = sha1($password);
                        $result = $mysqli->query("INSERT INTO userdetails(username, email_id, password, position) VALUES ('$username', '$email', '$password', '$position')");
                        if ($class_id != NULL) {
                            $hod_id = $mysqli->query("SELECT user_id FROM userdetails WHERE username = '$username'");
                            $hod_row = $hod_id->fetch_assoc();
                            $hod_id = $hod_row["user_id"];
                            $branchresult = $mysqli->query("UPDATE branch SET hod_id = '$hod_id' WHERE branch_id = '$class_id'");
                        }
                        if ($result && $branchresult) {
                            $success = "User registered successfully ✔";
                        } else {
                            $error = "Some error occured, try again ❌";
                        }
                    } else {
                        $error = "passwords dont match, try again ❌";
                    }
                }
            }
        }


    ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-lg">
            <a class="navbar-brand" href="index.php" style="font-size: 25px">
                <i class="fas fa-user-graduate" style="color: #009933;"></i> Classter
            </a>
            <?php if (isset($_SESSION["username"])) { ?>
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
                </div>
            <?php } ?>
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
            <div class="row align-items-center justify-content-center">
                <div class="col-sm center m-3">
                    <i class="fas fa-user-graduate" style="font-size: 1200%; color:#009933;"></i>
                    <h1 style="text-align: center; margin-top: 5%; color:#009933;" class="ml2">Classter</h1>
                </div>

                <div class="col-sm" style="background-color:#009933; height: 109vh; color:white;">
                    <div id="loginform" class="container shadow-lg" style="background-color: white; color:#009933; margin-top: 25%;">
                        <h2 class="center pt-3">Login</h2>
                        <form class="p-2" method="POST">
                            <div class="form-group">
                                <label for="username">Email:</label>
                                <input type="email" class="form-control" name="email" placeholder="Enter Email:" required autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" name="password" placeholder="Enter Password:" required autocomplete="off">
                            </div>
                            <div class="form-check">
                                <input type="hidden" class="form-check-input" name="studentcheck" value="NULL">
                                <input type="checkbox" class="form-check-input" name="studentcheck">
                                <label class="form-check-label" for="student">Student</label>
                            </div>
                            <button type="submit" name="login" class="btn mybtn">Login</button>
                            <h5 style="font-size: 15px;" class="mt-2">Dont have an account?
                                <span><a id="registerlink">Register</a></span></h5>
                            <?php
                            ?>
                        </form>
                    </div>

                    <div id="registerform" class="container shadow-lg" style="background-color: white; color:#009933; margin-top: 2%; display: none;">
                        <h2 class="center pt-3">Register</h2>
                        <form class="p-2" method="POST">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" name="username" placeholder="Enter Username:" required autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="email">Email address:</label>
                                <input type="email" class="form-control" name="email" placeholder="Enter Email:" required autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="originalpassword" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" placeholder="Enter Password:" required autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="cpassword">Confirm Password</label>
                                <input type="password" id="verify" class="form-control" name="cpassword" placeholder="Enter Password Again:" required autocomplete="off">
                            </div>
                            <p class="text-center d-none text-danger" id="verifymessage" style="font-size: 15px;">The
                                passwords don't match</p>
                            <p>Please select your position:</p>
                            <input id="admin" type="radio" name="position" value="admin">
                            <label for="admin">Admin</label>
                            <input style="display: none;" type="password" name="secretcode" id="adminsecretcode" disabled>
                            <input type="hidden" value="NULL" name="class" id="adminclass">
                            <br>
                            <input id="hod" type="radio" name="position" value="hod">
                            <label for="hod">HOD</label>
                            <input style="display: none;" type="password" name="secretcode" id="hodsecretcode" disabled>
                            <label style="display: none;" for="class" id="hodclasslabel">Select Branch:</label>
                            <select style="display: none;" name="class" id="hodclassselect" disabled>
                                <?php
                                $classresults =  $mysqli->query("SELECT * FROM branch");
                                while ($classrow = $classresults->fetch_assoc()) { ?>
                                    <option value="<?php echo $classrow["branch_id"] ?>"><?php
                                                                                            echo $classrow["branch_name"];
                                                                                            ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <br>
                            <input id="teacher" type="radio" name="position" value="teacher">
                            <label for="teacher">Teacher</label>
                            <input style="display: none;" type="password" name="secretcode" id="teachersecretcode" disabled>
                            <input type="hidden" value="NULL" name="class" id="teacherclass">
                            <br>
                            <input id="viewer" type="radio" name="position" value="viewer">
                            <label for="viewer">Viewer</label>
                            <input style="display: none;" type="text" value="NULL" name="secretcode" id="viewersecretcode" disabled>
                            <input type="hidden" value="NULL" name="class" id="viewerclass">
                            <br>
                            <button type="submit" name="register" id="register" class="btn mybtn">Register</button>
                            <h5 style="font-size: 15px;" class="mt-2">Have an account?
                                <span><a id="loginlink">Login</a></span></h5>
                        </form>
                    </div>

                </div>
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

            <div class="footer-copyright text-center py-3"> Made by
                Meet Turakhia
            </div>

        </footer>

        <script language="javascript" type="text/javascript" src="assets/javascript/login.js"></script>
    <?php
    }
    ?>
</body>

</html>