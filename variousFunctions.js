//This is just a collection of miscellanious functions used across the page


//I will show all the reminder thingies with javascropt 
function showReminderInfoModal(id)
{
    //Getting the data from the server
    //Este AJAX esta funcionando
   var objXMLHttpRequest = new XMLHttpRequest();
    objXMLHttpRequest.onreadystatechange = function() {
  if(objXMLHttpRequest.readyState === 4) {
    if(objXMLHttpRequest.status === 200) {
          
      var queryString = objXMLHttpRequest.responseText;

      //I will format the String so it is easy to access the data
      queryString = queryString.split("\n");
      let title = queryString[0];
      let time = queryString[1];
      let date = queryString[2];
      let priority = queryString[3]; //This isnt being used yet
      let notify = queryString[4];
      let description = queryString[5];
      //let color = queryString[6];
      let id = queryString[6];
      
     // alert(queryString);

      //In here I can change the information of the modal
      document.getElementById("titleE").value = title;
      document.getElementById("timeE").value = time;
      document.getElementById("dateE").value = date;
     // document.getElementById("priorityE").value = priority; The priority will be reset
      document.getElementById("notifyE").value = notify;
      
      if(description !="")
      document.getElementById("descriptionE").value = description;
      else
      document.getElementById("descriptionE").value="";
      
      //document.getElementById("colorE").value = color; removed the color
      document.getElementById("reminderPreviewE").className = getPriorityClass(priority);

      document.getElementById("priorityE").value = priority;

      document.getElementById("editR").value = id;
      
    } else {
          alert('Error Code: ' +  objXMLHttpRequest.status);
          alert('Error Message: ' + objXMLHttpRequest.statusText);
    }
  }
}
objXMLHttpRequest.open('GET', "/includes/queryReminder.php?"+"editID="+id, true);
objXMLHttpRequest.send();
}

//This updates the reminder preview
function updateReminderPreviewColor()
{
   var val = document.getElementById("reminderP").value;
    let elementClass = getPriorityClass(val);

   

   document.getElementById("reminderPreview").className = elementClass;
}

//This updates the reminder edit preview
function updateReminderPreviewColorE()
{
  var val = document.getElementById("priorityE").value;
    let elementClass = getPriorityClass(val);

   document.getElementById("reminderPreviewE").className = elementClass;
}

//this gets the priority class
function getPriorityClass(val)
{
  switch (val) {
    case "High":
      return "btn btn-warning";
      
   case "Medium":
     return "btn btn-success";
  
   case "Low":
     return "btn btn-info";
  
    default:
     return "btn btn-light";

  }
}
