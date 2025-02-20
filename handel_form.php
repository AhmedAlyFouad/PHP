<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = htmlspecialchars($_POST["name"]); // get the name
    if (empty($name)) { // check the name
        $_SESSION["name_error"] = "Name is invalid";
        header("Location: form_view.php");
        exit(); // Stops execution to prevent further code from running
    }

    $email = htmlentities($_POST["email"]); // get the email
    if (empty($email) || !str_contains($email, "@") || !str_ends_with($email, ".com")) { // validate the email
        $_SESSION["email_error"] = "email is invalid";
        header("Location: form_view.php");
        exit();
    }

    // if the file isn't exists with the data
    if (!isset($_FILES["picture"])) {
        $_SESSION["file_error"] = "Please upload a file";
        header("Location: form_view.php");
        exit();
    }

    // if the file has an error or too large 
    if ($_FILES["picture"]["error"] != 0) {
        $_SESSION["file_error"] = "Please upload a valid picture";
        header("Location: form_view.php");
        exit();
    }

    // Validate file size
    $picture_size = $_FILES["picture"]["size"];
    if ($picture_size > (2 * 1024 * 1024)) {
        $_SESSION["file_error"] = "The file must be less than 2 MB";
        header("Location: form_view.php");
        exit();
    }

   // validate the extension
    $picture_type = $_FILES["picture"]["type"];
    if ($picture_type == "image/png" || $picture_type == "image/jpeg") {
        move_uploaded_file($_FILES["picture"]["tmp_name"], "uploads/" . $_FILES["picture"]["name"]);
    }else{
        $_SESSION["file_error"] = "The image must be PNG or JPG";
            header("Location: form_view.php");
            exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="d-flex justify-content-center align-items-center vh-100 text-center">
        <div class="container">
            <img src=<?php echo "uploads/" . $_FILES["picture"]["name"] ?> alt="picture" class="rounded-circle" style="object-fit: cover; width: 300px; height: 300px;">
            <h2><?php echo $name ?></h2>
            <p class="text-secondary"><?php echo $email ?></p>
        </div>
    </div>
</body>

</html>