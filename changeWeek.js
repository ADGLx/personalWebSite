var weekNumber =0;

//This happens on load
function change()
{
    //If it isnt set just set the session storage to 0
    if(sessionStorage.getItem("num") == null)
    {
        var weekNumber =0;
        sessionStorage.setItem("num",weekNumber);
        console.log(weekNumber);
    } else 
    {
        weekNumber = sessionStorage.getItem("num");
        console.log(weekNumber);
    }


    
    
}

function add()
{
    weekNumber = Number(sessionStorage.getItem("num")) + Number(7);
    sessionStorage.setItem("num",weekNumber);
    document.getElementById("plusWeek").value = weekNumber;
}

function remove()
{
    weekNumber = Number(sessionStorage.getItem("num")) - Number(7);
    sessionStorage.setItem("num",weekNumber);
    document.getElementById("minusWeek").value = weekNumber;
}