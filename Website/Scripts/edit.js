let editMode = true;
let showClasses = true;

function EditMode(x){
    //edit mode is on already, hide trashcans
    if(editMode){
        var elements = document.getElementsByClassName("trashcan");
        for(var i = 0; i < elements.length; i++){
            elements[i].style.display = "none";
        }
        editMode = false;
    }
    //edit mode is off, show trashcans
    else{
        var elements = document.getElementsByClassName("trashcan");
        for(var i = 0; i < elements.length; i++){
            elements[i].style.display = "inline";
        }
        editMode = true;
    }
    
    //used on course.php to lock the subject name text field
    if(x == 2){
        if(editMode){
            document.getElementById('text_field').disabled = false;
        }
        else{
            document.getElementById('text_field').disabled = true;
        }
    }
}

function AllClasses(){
    //hide classes
    if(showClasses){
        document.getElementById('predmeti').style.display = "none";
        //document.getElementById('btn').innerHTML = "Vsi predmeti...";
        document.getElementById('arrow_img').src = 'Pictures/triangle_up.png';
        showClasses = false;
    }
    //show classes
    else{
        document.getElementById('predmeti').style.display = "block";
        //document.getElementById('btn').innerHTML = "Vsi predmeti";
        document.getElementById('arrow_img').src = 'Pictures/triangle_down.png';
        showClasses = true;
    }
}

function FieldWidth(){
    let x = document.getElementById('text_field').value;
    let length = x.length;

    if(length < 5){
        document.getElementById('text_field').style.width = "5ch";
    }
    else{
        document.getElementById('text_field').style.width = length + "ch";
    }
}

function FieldFocus(x){
    //show border
    if(x == 1){
        document.getElementById('text_field').style.borderBottomColor = "black";
    }
    //hide border
    else{
        document.getElementById('text_field').style.borderBottomColor = "transparent";
    }
}

FieldWidth();
EditMode();