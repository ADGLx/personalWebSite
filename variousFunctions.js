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

      document.getElementById("deleteE").value = id;
      
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


//-------------------------This is for the TODOs List--------------------------------
function showToDoOnLoad()
{
  
  if(sessionStorage.getItem("currentToDoList") !=null)
  {
  //  showToDoList(sessionStorage.getItem("currentToDoList"));
  }
}

function showToDoList(typeOfListID)
{

  if(sessionStorage.getItem("currentToDoList") == typeOfListID && sessionStorage.getItem("showToDos") == "true")
  {
    document.getElementById("addTodosTable").innerHTML = "";
    sessionStorage.setItem("showToDos", false);

     //Change the back icon on the title
  document.getElementById("icon"+typeOfListID).className = "fas fa-chevron-down"; 

  //Change back the border too
  document.getElementById("color"+typeOfListID).style.border= "";


    return;
  }
  


  var http = new XMLHttpRequest();
  http.onreadystatechange = function() 
    {
     
    if(http.readyState === 4) 
    {
      if(http.status === 200) 
      {
        var queryString = http.responseText;
        let output = queryString.split("|");
        //Add the table elements here 
        let htmlOuput ="<tbody>";

        var amtOfRows = Math.floor(output.length + 1/4);
        amtOfRows++;

        //Now find the positions of which

        for (let i = 0; i < output.length; i++) 
        {
          if((i +1)%4==1)
          htmlOuput +="<tr>";

          //Print the actual thing
          if(output[i]!=null && output[i]!=" " &&  output[i]!="")
          htmlOuput += "<td align='middle' valign='middle'> <i class='far fa-circle fa-xs'></i> &nbsp;"+output[i] +"  </td>"

          if(i +1%4==0)
          htmlOuput +="</tr>";

          //Prints the extra stuff
          if(i==(output.length-1))
          {
            htmlOuput += "<td colspan=4 align='middle' valign='middle'> <i class='far fa-circle fa-xs'></i> &nbsp;" + 
            "<input type='text' id='todoSender' name='name' style='width:80%'><button type='button' class='btn btn-outline-light btn-sm' onclick='sendToDoToDataBase("+typeOfListID+")'> <i  class='fas fa-check-square fa-lg'></i></button>  </td>"; //This is the button
            //put in the ID the best
          }
        
        }

        //Adding the input field to the next one

        htmlOuput += "</tbody>";
        //Setting a session variable for the last active ToDoList
        sessionStorage.setItem("currentToDoList", typeOfListID);
        sessionStorage.setItem("showToDos", "true");

        document.getElementById("addTodosTable").innerHTML = htmlOuput;
            
        changeCellColor(typeOfListID);
        selectToDoType(typeOfListID);

        
      } else {
            alert('Error Code: ' +  http.status);
            alert('Error Message: ' + http.statusText);
      }
    }
    } 
    http.open('GET', "/includes/queryToDos.php?"+"typeOfToDo="+typeOfListID, true);
    http.send();
   // alert(typeOfListID);
  
}

function changeCellColor(id)
{
  
  var color = document.getElementById("color"+id).style.backgroundColor;
  var el = document.getElementById("addTodosTable");

  var allTD = el.getElementsByTagName("td");

  for (let index = 0; index < allTD.length; index++) {
    const element = allTD[index];
    element.style.backgroundColor = color;

    //changing the width too
    element.style.width = 100/allTD.length +"%"; //This evens the width

  }
    
  
}

function sendToDoToDataBase(typeID)
{
  //alert("sending! " + document.getElementById("todoSender").value);

  let textToSend = document.getElementById("todoSender").value;
  
  var http = new XMLHttpRequest();
    http.open('GET', "/includes/submitToDo.php?"+"name="+textToSend +"&"+"type="+typeID, true);
    http.send();


    //Now just refresh the results realquick
    showToDoList(typeID);
}

function selectToDoType(id)
{
 
  //First set all the other ones to the down one 
   var allChildren = document.getElementById("todoTypeParent").getElementsByTagName("i");

   for (let index = 0; index < allChildren.length; index++) {
     const element = allChildren[index];
     
      element.className = "fas fa-chevron-down"; 

     
   }

   var allCellChildren = document.getElementById("todoTypeParent").getElementsByTagName("th");
   for (let index = 0; index < allCellChildren.length; index++) 
   {
    const element = allCellChildren[index];
    
     element.style.border = "";

    
  }
    //Change the icon on the title
  document.getElementById("icon"+id).className = "fas fa-chevron-up"; 

    //Change the border of the cell
    document.getElementById("color"+id).style.borderTop = "5px solid white";
    document.getElementById("color"+id).style.borderLeft = "5px solid white";
    document.getElementById("color"+id).style.borderRight = "5px solid white";
}

