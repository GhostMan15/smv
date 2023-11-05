let editMode = false;

function EditMode(){
    //edit mode is on already, hide trashcans
    if(editMode){
        document.getElementById('trashcan').style.display = "none";
        editMode = false;
    }
    //edit mode is off, show trashcans
    else{
        document.getElementById('trashcan').style.display = "block";
        editMode = true;
    }
}