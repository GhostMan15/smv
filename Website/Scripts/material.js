function textAreaSize(){
    document.getElementById('textarea_field').style.height = "";
    document.getElementById('textarea_field').style.height = document.getElementById('textarea_field').scrollHeight + "px"
}

function on_change(x){
    //on focus - render white line
    if(x == 1){
        document.getElementById('title_field').style.borderBottomColor = "lightgray";
    }

    //lose focus - remove white line
    else if(x == 2){
        document.getElementById('title_field').style.borderBottomColor = "transparent";
    }   

    //on focus textarea 
    if(x == 3){
        document.getElementById('textarea_field').style.borderColor = "lightgray";
    }

    //lose focus textarea
    else if(x==4){
        document.getElementById('textarea_field').style.borderColor = "transparent";
    }
}
