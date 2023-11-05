let editMode = true;

function EditMode(){
    //edit mode is on already, hide trashcans
    if(editMode){
        var elements = document.getElementsByClassName("trashcan");
        //jQuery(".trashcan").css("display", "none");
        for(var i = 0; i < elements.length; i++){
            elements[i].style.display = "none";
        }
        editMode = false;
    }
    //edit mode is off, show trashcans
    else{
        var elements = document.getElementsByClassName("trashcan");
        //jQuery(".trashcan").css("display", "inline");
        for(var i = 0; i < elements.length; i++){
            elements[i].style.display = "inline";
        }
        editMode = true;
    }
}