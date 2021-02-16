//temporixador que idica el tiempo de espera 
function timer(){  
    var t=setTimeout("timer()",1000);  
    document.getElementById('contador').innerHTML = 'Por favor espere '+i--+" segundos";  
    if (i==-1){
        document.getElementById('contador').innerHTML = 'Intentelo de nuevo';  
        clearTimeout(t);  
    }  
}  
i=5;  