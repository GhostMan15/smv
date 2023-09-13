/*let pass_field = document.getElementById('pass_field');*/
/*let default_css = window.getComputedStyle(pass_field);
alert(default_css);*/

function on_change(x){
    //on focus - render white line
    if(x == 1){
        document.getElementById('pass_field').style.borderBottomColor = "white";
        document.getElementById('show_btn').style.display = 'inline-block';
    }
    //on changed value change width o password field to the exact number of characters it contains
    /*
    else if(x == 2){
        let value = document.getElementById('pass_field').value;
        let len = value.length;
        document.getElementById('pass_field').style.width = '0 ch'
        document.getElementById('pass_field').style.width = len + 'ch';
        
    }
    */
    //lose focus - remove bottom border
    else if(x == 2){
        document.getElementById('pass_field').style.borderBottomColor = "rgba(255, 255, 255, 0)";
        /*document.getElementById('show_btn').style.display = 'none';*/

        //check if bar is empty, hide button if it is
        let value = document.getElementById('pass_field').value;
        let len = value.length;

        if(len == 0){
            document.getElementById('show_btn').style.display = 'none';
        }
    }   
}

function textAreaSize(){
    /*alert('wtf');*/
    let textarea = document.getElementById('textarea');
    document.getElementById('textarea_field').style.height = "";
    document.getElementById('textarea_field').style.height = document.getElementById('textarea_field').scrollHeight + "px"
}
