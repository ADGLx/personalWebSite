//This is just a collection of miscellanious functions used across the page


//I will show all the reminder thingies with javascropt 
function showReminderInfoModal(id)
{
    //Getting the data from the server
   // var xhr = new XMLHttpRequest;
   // xhr.open("POST", "/includes/queryReminder.php");

   const xhttp = new XMLHttpRequest();
   xhttp.onload = function() {
    // document.getElementById("demo").innerHTML = this.responseText;
     }
   xhttp.open("GET", "/includes/queryReminder.php", true);
   xhttp.send();
    //Change the contents of the given reminder
    //document.getElementById("classnameE").value ="test";
    console.log("Reminder being displayed: "+ xhttp.responseText);
}