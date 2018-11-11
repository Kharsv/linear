$(document).ready(function () {
   
    
    

    var c = document.getElementById("myCanvas");
var ctx = c.getContext("2d");
ctx.moveTo(200,500);
ctx.lineTo(500,500);
ctx.moveTo(200,200);
ctx.lineTo(200,500);
var ctx = c.getContext("2d");
ctx.font = "30px Arial";
ctx.fillText("x", 500, 500);
var ctx = c.getContext("2d");
ctx.font = "30px Arial";
ctx.fillText("(0,0)", 200, 500);

var ctx = c.getContext("2d");
ctx.font = "30px Arial";
ctx.fillText("-(0,1)", 200, 350);

var ctx = c.getContext("2d");
ctx.font = "30px Arial";
ctx.fillText("I(1,0)", 350, 500);

var ctx = c.getContext("2d");
ctx.font = "30px Arial";
ctx.fillText("y", 200, 200);

var nx1 = 50;
var ny1 = 50;
var mx1 = -250;
var my1 = -250;

ctx.moveTo(300,300);
ctx.lineTo(400,400);

ctx.stroke();
    
    // var name = prompt('Введите ваше имя');

    // $('form').submit(function() {
    //     var xhr = new XMLHttpRequest();
    //     xhr.open('POST', 'send_message.php', true);
    //     xhr.setRequestHeader('Content-type', 'application/json');
    //     var data = {
    //         text: $('#text').val(), 
    //         name: name
    //     };
    //     data = JSON.stringify(data);
    //     xhr.send(data);

    //     xhr.onreadystatechange = function() {
    //         if (xhr.readyState != 4) {
    //             return;
    //         }

    //         console.log(xhr.responseText);
    //     }

    //     return false;
    // });

    // setInterval(function() {
    //     var xhr = new XMLHttpRequest();
    //     xhr.open('GET', 'get_messages.php', true);
    //     xhr.setRequestHeader('Content-type', 'application/json');
    //     xhr.send();

    //     xhr.onreadystatechange = function() {
    //         if (xhr.readyState != 4) {
    //             return;
    //         }

    //         var response = JSON.parse(xhr.responseText);
    //         $('.card-body').empty();
    //         response.messages.forEach(function(message) {
    //             $('.card-body').append('<div><h3>'+message.name+'</h3><p>'+message.text+'</p></div>');
    //         });

    //     }
    // }, 500);

    

});

function OpenNav() {
	document.getElementById("mysidenav").style.width = "250px";
		
}
function CloseNav() { 
	document.getElementById("mysidenav").style.width = "0px";
}