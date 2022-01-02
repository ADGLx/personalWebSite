//Here save all the functions to handle the month, year, etc

let currentWeek; //This contains the current week

function showCalendar()
{
    currentWeek = getThisWeekAsArray();

    printTableToHTML(currentWeek);

}

function getThisWeekAsArray()
{
    //First get the dates of the current Monday
    let today = new Date();
        
    //This gets the first day of that week
    const firstMonday = new Date(today.getFullYear(),today.getMonth(), today.getDate() - (today.getDay() -1));
    //Get the Monday of this week and the sunday
    const returnWeek = [];

    for(let x =0; x< 7; x++)
    {
        returnWeek[x] = new Date(today.getFullYear(), today.getMonth(), firstMonday.getDate() + x);
    }

    return returnWeek;
}

function goFowardOneWeek()
{
    const tempWeek = currentWeek;
    for(let x = 0; x<7;x++)
    {
        tempWeek[x].setDate(tempWeek[x].getDate()+7);
    }

    printTableToHTML(tempWeek);

}

function goBackwardOneWeek()
{
    const tempWeek = currentWeek;
    for(let x = 0; x<7;x++)
    {
        tempWeek[x].setDate(tempWeek[x].getDate()-7);
    }

    printTableToHTML(tempWeek);
}

function printTableToHTML(week)
{
    //First print the head with the current dates
    for( let i=0; i<7; i++)
    {
        document.getElementById("d"+i).innerHTML = dayAsString(week[i].getDay()) + "<br>(" + week[i].getDate()+"/"+ (week[i].getMonth()+1)+"/"+week[i].getFullYear() +")";
    }

    //In here I should display the rest of the content
}

function dayAsString( number)
{
    //This converts the usual 0 for sunday in getDay() to my 0 for monday
    switch(number)
    {
        case 1:
            return "Monday";
            break;
        
        case 2:
            return "Tuesday";
            break;

        case 3:
            return "Wednesday";
            break;    

        case 4:
            return "Thursday";
            break; 

        case 5:
            return "Friday";
            break; 

        case 6:
            return "Saturday";
            break; 

        case 0:
            return "Sunday";
            break; 
       
            default:
            return "Invalid Number"
            break;
    }
}