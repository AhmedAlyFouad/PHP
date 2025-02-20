<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Webpage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <h1>Ahmed Aly Fouad Kamal</h1>
    <p>AhmedAlyFouad@gmail.com</p>
    <h2>About</h2>
    <div>Lorem ipsum dolor sit amet consectetur adipisicing elit. <br>
        Iste libero quidem magnam dolore tempore delectus sequi, <br>
        repellendus porro dicta similique ducimus quisquam consectetur quo eaque cupiditate asperiores! Ducimus, <br>
        maiores beatae!
    </div>
    <h4>Skills:</h4>
    <ul>
       <li>HTML</li> 
       <li>CSS</li>
       <li>JS</li>
       <li>PHP</li>
       <li>Laravel</li>
    </ul>
    <h3>Projects</h3>
    <ul>
        <li><a href="https://prezi.com/p/wx-hkcbtj-fd/berimbolo-security-inc/">Berimblo-Security-Company</a></li>
        <li><a href="https://prezi.com/p/wx-hkcbtj-fd/berimbolo-security-inc/">Berimblo-Security-Company</a></li>
        <li><a href="https://prezi.com/p/wx-hkcbtj-fd/berimbolo-security-inc/">Berimblo-Security-Company</a></li>
    </ul>
    <h3>Contact me</h3>
    <div class="container">
        <form action="handel_form.php" method="POST" enctype="multipart/form-data">
            <label class="mt-2"><b>Enter Your Name: </b></label>
            <input type="text" name="name" class="form-control">
            <?php
            // name validation message
            if(isset($_SESSION["name_error"])){
                echo "<p class='text-danger'>{$_SESSION["name_error"]}</p>";
                unset($_SESSION["name_error"]);
            }
            ?>
            <label class="mt-2"><b>Enter Your Email: </b></label>
            <input type="email" name="email" class="form-control">
            <?php
            // email validation message
            if(isset($_SESSION["email_error"])){
                echo "<p class='text-danger'>{$_SESSION["email_error"]}</p>";
                unset($_SESSION["email_error"]);
            }
            ?>
            <label class="mt-2"><b>Enter Your Job</b></label>
            <input type="text" name="job" class="form-control">
            <?php
            // job validation message
            if(isset($_SESSION["job_error"])){
                echo "<p class='text-danger'>{$_SESSION["job_error"]}</p>";
                unset($_SESSION["job_error"]);
            }
            ?>
            <label class="mt-2"><b>Enter Your picture</b></label>
            <input type="file" name="picture" class="form-control">
            <?php
            // picture validation message
            if(isset($_SESSION["file_error"])){
                echo "<p class='text-danger'>{$_SESSION["file_error"]}</p>";
                unset($_SESSION["file_error"]);
            }
            ?>
            <button class="btn btn-success mt-2" type="submit" >Send</button>
        </form>
    </div>
    </form>
</body>
</html>