<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?TPLVAR_TITLE?></title>
    <link rel="icon" href="<?TPLVAR_ROOT_URL?>favico.ico" type="image/x-icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
    <!-- BEGIN DYNAMIC BLOCK: cssRow -->
    <style type="text/css">@import "<?TPLVAR_ROOT_URL?>www/themes/<?TPLVAR_THEME?>/assets/css/<?TPLVAR_CSSNAME?>.css?<?TPLVAR_MICRO?>";</style>
    <!-- END DYNAMIC BLOCK: cssRow -->
    <!-- BEGIN DYNAMIC BLOCK: jsRow -->
    <script type="text/javascript" src="<?TPLVAR_ROOT_URL?>www/themes/<?TPLVAR_THEME?>/assets/js/<?TPLVAR_JNAME?>"></script>
    <!-- END DYNAMIC BLOCK: jsRow -->

    <!-- <script src="http://services.markaxis.com:5000/socket.io/socket.io.js"></script> -->
    <!-- <script src="http://localhost/ws/socket.io/socket.io.js"></script> -->
    <script src="http://localhost:5000/socket.io/socket.io.js"></script>
    <script>
        //socket = io.connect('http://services.markaxis.com:5000');
        socket = io.connect('http://localhost:5000');

        socket.on("connect", function(e) {
            socket.emit("subscribe", Aurora.USERID);

            socket.on("chatMessage", function(e) {
                var obj = $.parseJSON(e);
                console.log( obj )

                var selected = $(".selected");
                selected.attr("data-room", obj.data.crID);
                $("#message").val("");
                $(".message-wrapper").append( $(obj.html) );
                var height = $(".message-wrapper").prop("scrollHeight");
                $(".message-wrapper").scrollTop( height );
            });
        });
    </script>
</head>
<body class="navbar-top">

