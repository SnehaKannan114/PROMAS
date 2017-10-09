function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}

function openSideNav() {
    document.getElementById("mySidenav").style.width = "250px";
    document.getElementById("content").style.marginLeft = "250px";
    document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
}

function closeSideNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("content").style.marginLeft= "0";
    document.body.style.backgroundColor = "white";
}