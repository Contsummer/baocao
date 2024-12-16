<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/main.css">
    <title>CHỦ ĐỀ </title>
</head>

<body>
    <div class="container">
        <div class="row">
            <?php include './include/nav.php'; ?>
        </div>
        <div class="row">
            <div class="col-md-3">
                <span class="ms-1 fw-bold fs-3">Chủ Đề </span>
                <ul class="list-group ">
                    <?php include './load_data.php'; ?>
                </ul>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <?php include 'listproduct.php'; ?>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <?php include './include/footer.php'; ?>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    </script>
</body>

</html>