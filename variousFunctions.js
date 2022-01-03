//This is just a collection of miscellanious functions used across the page


//----------------------------Check if mobile device--------------------------
function isMobile()
{
  if(window.innerWidth < 730)
    return 1;
  else 
    return 0;
}

//----------------------------Reminder Edit Functions---------------------------
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

function showToDoTypes()
{
  //Check if it has to be on mobile
  let mobile = isMobile();


  var http = new XMLHttpRequest();
  http.onreadystatechange = function() 
    {
     
    if(http.readyState === 4) 
    {
      if(http.status === 200) 
      {
        var queryString = http.responseText;
        document.getElementById("todoTypeParent").innerHTML = queryString;
      } else {
            alert('Error Code: ' +  http.status);
            alert('Error Message: ' + http.statusText);
      }
    }
    } 
    http.open('GET', "/includes/queryToDoTypes.php?mobile="+mobile, true);
    http.send();
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

        let amtOfRows=4;

        if(isMobile)
        amtOfRows=2;

        //Add the table elements here 
        let htmlOuput ="<tbody>";


        //Now find the positions of which

        for (let i = 0; i < output.length; i++) 
        {
          let nameI = output[i].split("&?")[0];
          let todoID = output[i].split("&?")[1];


          if((i +1)%amtOfRows==1)
          htmlOuput +="<tr>";

          //Print the actual thing
          if(nameI!=null &&nameI!=" " &&  nameI!="")
          htmlOuput += "<td align='left' valign='middle' onmouseover=\"showDeleteTodoIcon('t"+todoID+"')\" onmouseout=\"hideDeleteTodoIcon('t"+todoID+"') \" > <i class='far fa-circle fa-xs'></i> &nbsp;"+nameI +
          " <button type='button'class='btn btn-outline-light btn-sm' id='t"+todoID+"' style='display:none;float:right;' onclick='deleteToDo("+todoID+")'>  <i  class='far fa-trash-alt fa-x'></i></button> </td>"

          if(i +1%amtOfRows==0)
          htmlOuput +="</tr>";

          //Prints the extra stuff
          if(i==(output.length-1))
          {
            htmlOuput += "<td colspan=4 align='middle' valign='middle'> <i class='far fa-circle fa-xs'></i> &nbsp;" + 
            "<input type='text' id='todoSender' name='name' style='width:80%'><button type='button' id='senderButton' class='btn btn-outline-light btn-sm' onclick='sendToDoToDataBase("+typeOfListID+")'> <i  class='fas fa-check-square fa-lg'></i></button>  </td>"; //This is the button
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

        //Trigger it by pressing enter
        var input = document.getElementById("todoSender");
        input.addEventListener("keyup", function(event) {
          if (event.keyCode === 13) {
          event.preventDefault();
           document.getElementById("senderButton").click();
          }
        });

        
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
  
  var color = document.getElementById("color"+id).style.color;
  var el = document.getElementById("addTodosTable");

  var allTD = el.getElementsByTagName("td");

  for (let index = 0; index < allTD.length; index++) {
    const element = allTD[index];
   // element.style.color = color;

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
    //But before change the local storage to keep it from hiding
    sessionStorage.setItem("showToDos","false" );
    showToDoList(typeID);
}

function selectToDoType(id)
{
 
  //First set all the other ones to the down one 
  var color = document.getElementById("color"+id).style.color;
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
    document.getElementById("color"+id).style.borderTop = "5px solid " + color;
    document.getElementById("color"+id).style.borderLeft = "5px solid "+ color;
    document.getElementById("color"+id).style.borderRight = "5px solid "+ color;

    document.getElementById("addTodosTable").style.border = "5px solid " + color;
}

function deleteToDo(id)
{
  var http = new XMLHttpRequest();
  http.open('GET', "/includes/deleteToDo.php?"+"id="+id, true);
  http.send();

  showToDoList(sessionStorage.getItem("currentToDoList"));
}

//Show the trash icon on hover
function showDeleteTodoIcon(objID)
{
  document.getElementById(objID).style.display = "inline";
}

function hideDeleteTodoIcon(objID)
{
  document.getElementById(objID).style.display = "none";
}

//--------------------------------Functions to show the weekly schedule----------------
//This also adds to the current week variable
function showSchedule(add)
{
  let currentWeekNumber = 0;

  if(sessionStorage.getItem("num") ==null)
  {
    sessionStorage.setItem("num", 0);
  }

  if(add == 1)
  {
    currentWeekNumber = Number(sessionStorage.getItem("num")) + Number(1);
    
  } else if (add == -1)
  {
    currentWeekNumber = Number(sessionStorage.getItem("num")) - Number(1);

  } else //If passed something else, ill do a reset
  {
    currentWeekNumber = 0;

  }

  sessionStorage.setItem("num",currentWeekNumber);


  var http = new XMLHttpRequest();
  http.onreadystatechange = function() 
    {
     
    if(http.readyState === 4) 
    {
      if(http.status === 200) 
      {
        var queryString = http.responseText;
        document.getElementById("scheduleTable").innerHTML = queryString;
      } else {
            alert('Error Code: ' +  http.status);
            alert('Error Message: ' + http.statusText);
      }
    }
    } 
    http.open('GET', "/includes/queryWeeklySchedule.php?"+"week="+currentWeekNumber+"&mobile="+isMobile(), true);
    http.send();
}

function showReminderList()
{
  let currentWeekNumber = 0;
  if(sessionStorage.getItem("num") !=null)
  currentWeekNumber = sessionStorage.getItem("num");

  var http = new XMLHttpRequest();
  http.onreadystatechange = function() 
    {
     
    if(http.readyState === 4) 
    {
      if(http.status === 200) 
      {
        var queryString = http.responseText;
        document.getElementById("reminderListTable").innerHTML = queryString;
      } else {
            alert('Error Code: ' +  http.status);
            alert('Error Message: ' + http.statusText);
      }
    }
    } 
    http.open('GET', "/includes/queryReminderList.php?"+"week="+currentWeekNumber+"&mobile="+isMobile(), true);
    http.send();
}