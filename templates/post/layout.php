<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['post']['title'] ?></title>
</head>
<body>
    <div class="wrapper">
        <?php require_once("templates/header.php") ?> 
        <?php require_once("templates/post/$page.php"); ?>

    </div>
</body>
</html>