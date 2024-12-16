<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Home Page</title>
    <link href="./assets/css/main.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

    <div class="container">
        <div class="row">
            <?php include './include/nav.php'; ?>
        </div>
        <div class="row ">
            <?php include './include/header.php'; ?>
        </div>
        <div class="row ">
            <h2 class="">HOA GIAO NHANH 60 PHÚT</h2>
            <?php include './listproduct.php'; ?>
        </div>

    </div>
    <?php include './include/footer.php'; ?>

</body>

</html>