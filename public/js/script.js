//this script is user for the "Edit your profile page",  it hides and displays forms
function displayEditAvatar()
{
	document.getElementById('edit_avatar').style.display = "block";
	document.getElementById('change_password').style.display = "none";
	document.getElementById('delete_account').style.display = "none";
}

function displayChangePassword()
{
	document.getElementById('change_password').style.display = "block";
	document.getElementById('edit_avatar').style.display = "none";
	document.getElementById('delete_account').style.display = "none";
}

function displayDeleteAccount()
{
	document.getElementById('change_password').style.display = "none";
	document.getElementById('edit_avatar').style.display = "none";
	document.getElementById('delete_account').style.display = "block";
	
}