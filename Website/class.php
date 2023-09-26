<!DOCTYPE html>
<html lang="en">

<!--HEAD-->

<head>
    <meta name="author" content="Mark Sadnik">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Stylesheets/class.css">
    <link rel="stylesheet" type="text/css" href="Stylesheets/navbar.css">
    <title>Predmeti</title>
</head>
<!--HEAD-->

<!--BODY-->

<body>
    <div class="banner">
        
        <div class="navbar">
            <a href='homepage.html'><img src='Pictures/logo1.png' class='logo'></a> 
            <ul>
                <li> <a href='home.php'>Domov</a></li>
                <li id="checked"> <a href='class.php'>Predmeti</a></li>
                <li> <a href='$$$'>Učenci</a></li>
                <li> <a href='vp.php'>Vaš Profil</a></li>
                <li> <a href='login.php'>Odjava</a></li>
            </ul>
        </div>
    </div>
    <div> <img src='Pictures/quote2.png' style="width: 450px; height: 149px; transform: translate(133%, -149px);" class='logo'> </div>
</body>
<!--BODY-->
<script>
        function random(){

            document.getElementById("one").innerHTML = Math.floor(Math.random() * 10);
                }
</script>
</html>