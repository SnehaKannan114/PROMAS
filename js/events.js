var conf = getElementById("confpasswd");

conf.onblur = validatePass;

var tabLoader = getElementByClass("tabRegister");
tabLoader.onload = openUserType(event, "Student");