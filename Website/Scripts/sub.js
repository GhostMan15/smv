function on_change(x){
    let value = document.getElementById('grade_input').value;
    //on focus - render white line
    if(x == 1){
        document.getElementById('grade_input').style.borderBottomColor = "black";
    }

    //lose focus - remove white line
    else if(x == 2){
        document.getElementById('grade_input').style.borderBottomColor = "transparent";
    }

    if(value < 0){
        document.getElementById('grade_input').value = 0;
    }

    else if(value > 100){
        document.getElementById('grade_input').value = 100;
        document.getElementById('grade_input').style.color = "darkgreen";
    }

    else if(value >= 50){
        document.getElementById('grade_input').style.color = "darkgreen";
    }

    else if(value < 50){
        document.getElementById('grade_input').style.color = "red";
    }
}