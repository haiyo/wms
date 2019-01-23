<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?TPLVAR_TITLE?></title>
    <link rel="icon" href="<?TPLVAR_ROOT_URL?>favico.ico" type="image/x-icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <!-- BEGIN DYNAMIC BLOCK: cssRow -->
    <style type="text/css">@import "<?TPLVAR_ROOT_URL?>www/themes/<?TPLVAR_THEME?>/assets/css/<?TPLVAR_CSSNAME?>.css?<?TPLVAR_MICRO?>";</style>
    <!-- END DYNAMIC BLOCK: cssRow -->
    <!-- BEGIN DYNAMIC BLOCK: jsRow -->
    <script type="text/javascript" src="<?TPLVAR_ROOT_URL?>www/themes/<?TPLVAR_THEME?>/assets/js/<?TPLVAR_JNAME?>"></script>
    <!-- END DYNAMIC BLOCK: jsRow -->

    <script src="http://localhost:3000/socket.io/socket.io.js"></script>
    <script>
        var socket = io.connect('http://localhost:3000');
    </script>
</head>
<body class="navbar-top">

