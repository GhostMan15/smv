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
    <div class="bannerr">
        
        <div class="navbar">
            <a href='homepage.html'><img src='Pictures/logo1.png' class="logo"></a> 
            <ul>
                <li> <a href='home.php'>Domov</a></li>
                <li id="checked"> <a href='class.php'>Predmeti</a></li>
                <li> <a href='$$$'>Učenci</a></li>
                <li> <a href='vp.php'>Vaš Profil</a></li>
                <li> <a href='login.php'>Odjava</a></li>
            </ul>
        </div>
        <div class="slikicaDIV"> <img class="slikica" src='Pictures/quote.png' id="slikaID"> </div>
        <div class="Predmeti"> 
            <div class="PredmetiMini">
                <h1><a href ='###'> Nup &nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;&nbsp;&nbsp;  Ucitelj1, Ucitelj2, Ucitelj3 </a></h1>
                <h1><a href ='###'> Slo &nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;&nbsp;&nbsp;  Ucitelj1, Ucitelj2, Ucitelj3 </a></h1>
                <h1><a href ='###'> Mat &nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;&nbsp;&nbsp;  Ucitelj1, Ucitelj2, Ucitelj3 </a></h1>
                <h1><a href ='###'> Nup &nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;&nbsp;&nbsp;  Ucitelj1, Ucitelj2, Ucitelj3 </a></h1>
                <h1><a href ='###'> Nup &nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;&nbsp;&nbsp;  Ucitelj1, Ucitelj2, Ucitelj3 </a></h1>
                <h1><a href ='###'> Nup &nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;&nbsp;&nbsp;  Ucitelj1, Ucitelj2, Ucitelj3 </a></h1>
                <h1><a href ='###'> Nup &nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;&nbsp;&nbsp;  Ucitelj1, Ucitelj2, Ucitelj3 </a></h1>
                <h1><a href ='###'> Nup &nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;&nbsp;&nbsp;  Ucitelj1, Ucitelj2, Ucitelj3 </a></h1>
                <h1><a href ='###'> Nup &nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;&nbsp;&nbsp;  Ucitelj1, Ucitelj2, Ucitelj3 </a></h1>
            </div>
         </div>
      </div>
     
    
    
</body>
<!--BODY-->
<script>
    var t = 0;
        while(true){
            t = Math.floor(Math.random() * 4);
            if(t != 0){
                break;
            }
        }
            
            document.getElementById('slikaID').src = 'Pictures/quote' + t + '.png';
            
                
</script>
</html>