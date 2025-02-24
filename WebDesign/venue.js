
//KICT Venue 

function showVenue(str) {
    /*
    if(str = "") {
        document.getElementById("tabKICT").innerHTML = ""; 
        return; 
    }
    */
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        document.getElementById("tabVenue").innerHTML = this.responseText; 
    } 
    //create getKICTv.php
    xhttp.open("GET", "getKICTv.php?v="+str, true);
    xhttp.send(); 
}

function newBook(venue,type) {


    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        document.getElementById("tabBook").innerHTML = this.responseText; 
    } 
    //create getKICTv.php
    xhttp.open("GET", "booking.php?type="+type+"&v="+venue, true);
    xhttp.send(); 
}

function deleteVenue(vid, vname, date, time) {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        document.getElementById("tabConfirmDeleted").innerHTML = this.responseText;  
    }

    xhttp.open("GET", "delete.php?vid="+vid+"&vname="+vname+"&date="+date+"&time="+time, true);
    xhttp.send();  
}
