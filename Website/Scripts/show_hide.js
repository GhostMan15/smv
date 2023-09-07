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