function redirect(){
    window.location.href = "register.php?admin=1"
}

function toggle(x){
    if(x==1){
        document.getElementById('table1').style.display = "none";
        document.getElementById('pic1').src = "Pictures/triangle_down.png";
    }
    else if(x==2){
        document.getElementById('table2').style.display = "none";
        document.getElementById('pic2').src = "Pictures/triangle_down.png";
    }
    else{
        document.getElementById('table3').style.display = "none";
        document.getElementById('pic3').src = "Pictures/triangle_down.png";
    }
}