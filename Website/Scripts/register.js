var show1 = false, show2 = false, show3 = false;

function redirect(){
    window.location.href = "register.php?admin=1"
}

function toggle(x){
    //Students table
    if(x==1){
        //hide table
        if(show1){
            document.getElementById('table1').style.display = "none";
            document.getElementById('pic1').src = "Pictures/triangle_up.png";
            show1 = false;
        }
        //show table
        else{
            document.getElementById('table1').style.display = "block";
            document.getElementById('pic1').src = "Pictures/triangle_down.png";
            show1 = true;
        }
    }

    //professors table
    if(x==2){
        //hide table
        if(show2){
            document.getElementById('table2').style.display = "none";
            document.getElementById('pic2').src = "Pictures/triangle_up.png";
            show2 = false;
        }
        //show table
        else{
            document.getElementById('table2').style.display = "block";
            document.getElementById('pic2').src = "Pictures/triangle_down.png";
            show2 = true;
        }
    }

    //admin table
    if(x==3){
        //hide table
        if(show3){
            document.getElementById('table3').style.display = "none";
            document.getElementById('pic3').src = "Pictures/triangle_up.png";
            show3 = false;
        }
        //show table
        else{
            document.getElementById('table3').style.display = "block";
            document.getElementById('pic3').src = "Pictures/triangle_down.png";
            show3 = true;
        }
    }
}