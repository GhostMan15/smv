function on_change(x){
    //on focus - render white line
    if(x == 1){
        document.getElementById('pass_field').style.borderBottomColor = "white";
        document.getElementById('show_btn').style.display = 'inline-block';
    }

    //lose focus - remove white line
    else if(x == 2){
        document.getElementById('pass_field').style.borderBottomColor = "rgba(255, 255, 255, 0)";

        //check if bar is empty, hide button if it is
        let value = document.getElementById('pass_field').value;
        let len = value.length;

        if(len == 0){
            document.getElementById('show_btn').style.display = 'none';
        }
    }   
}

function textAreaSize(){
    document.getElementById('textarea_field').style.height = "";
    document.getElementById('textarea_field').style.height = document.getElementById('textarea_field').scrollHeight + "px"
}

function passwordFieldWidth(){
    let password = document.getElementById('pass_field').value;
    let length = password.length;


    document.getElementById('pass_field').style.width = "0ch";
    if(length < 15){
        document.getElementById('pass_field').style.width = 15 + 'ch';
    }
    else{
        document.getElementById('pass_field').style.width = length + 'ch';
    }
}