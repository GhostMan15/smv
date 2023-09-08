//SHOW/HIDE PASSWORD FUNCTION
function click_show_button(){
    let button = document.getElementById('show_btn').innerHTML;
    let password_field = document.getElementById('pass_field');

    //if the password is hidden, make text field show data by changing its type to text
    if(button == 'Show'){
        password_field.type = 'text';
        document.getElementById('show_btn').innerHTML = 'Hide';
    }
    //if the password isnt hidden, hide the pass by changing type back to password
    else{
        password_field.type = 'password';
        document.getElementById('show_btn').innerHTML = 'Show';
    }
}

//DELETE SPACES FROM USERNAMES AND PASSWORDS
function delete_spaces(){
    let username = document.getElementById('user_field').value;
    let password = document.getElementById('pass_field').value;
    let error = document.getElementById('error_login');
    let error_msg = "Your user name / password cannot contain spaces. Spaces have been removed";
    //console.log("username: " + username + "||  password: " + password);
    //let search_flag = new RegExp(" ", "g");
    
    let changed_username = username.replace(/ /g, "");
    let changed_password = password.replace(/ /g, "");

    //compare the changed strings to original values to see if spaces were even deleted
    if(changed_password != password || changed_username != username){
        document.getElementById('user_field').value = changed_username;
        document.getElementById('pass_field').value = changed_password;
        error.innerHTML = error_msg;
    }

    //if nothing was changed, delete previous error message (if there was a space error)
    else{
        if(error.innerHTML == error_msg){
            error.innerHTML = "";
        }
    }
}