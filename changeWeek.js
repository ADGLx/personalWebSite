let weekNumber;

//This happens on load
function change()
{
    //If it isnt set just set the session storage to 0
    if(sessionStorage("num") == null)
    {
        sessionStorage.setItem("num",0);
    } else 
    {
        weekNumber = sessionStorage("num");
    }


    
    document.getElementById("plusWeek").value = weekNumber;
}

function add()
{

}
