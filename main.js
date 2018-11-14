var points = [];
var X1;
var Y1;
var X2;
var Y2;

$(document).ready(() => {
    $('#add').on('click', () => {
      var xVal = $('#x1').val();
      var yVal = $('#y1').val();
      var x2Val = $('#x2').val();
      var y2Val = $('#y2').val();
    
      if(xVal && yVal) {
        points.push({
          x: xVal, 
          y: yVal
        });
        
        $('#points').append('<div>Отрезок(' + xVal + ', ' + yVal + ')(' + x2Val + ', ' + y2Val + ')</div>');
      }
    });
    
    $('#update').on('click', () => {
      $.ajax({
        type: 'POST',
        url: 'your_url',
        data: points,
        dataType: 'json',
        success: (data) => {
            
          //update stuff with the results or something
  
        }
      });
      var X1 = $('#x1').val();
      var Y1 = $('#y1').val();
      var X2 = $('#x2').val();
      var Y2 = $('#y2').val();

      var c = document.getElementById("myCanvas");
      var ctx = c.getContext("2d");
   

      var nx1 = 1 * X1;
      var ny1 = 1 * Y1;
      var mx1 = 1 * X2;
      var my1 = 1 * Y2;
      
      
     
      ctx.moveTo( 200 + nx1,500 - ny1);
      ctx.lineTo( 200 + mx1,500 - my1);
  

      ctx.stroke();




    });
});




$(document).ready(function () {
   
 
    
// Рисование на холсте 
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




ctx.stroke();
  



// Взято с чата для айякс запросов
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

    // Еще xy


    var canvas = document.getElementById("myCanvas-1");
var cxt = canvas.getContext("2d");

var drawAxes = function(xZero, yZero) {
  cxt.moveTo(0, yZero);
  cxt.lineTo(canvas.width, yZero);
  cxt.stroke();
  cxt.moveTo(xZero, 0);
  cxt.lineTo(xZero, canvas.height);
  cxt.stroke();
};

document.getElementById("graphNow").addEventListener(
  "click",
  function() {
    //Get the user's form input, and put it into nicer variables.
    var equationsForm = document.getElementById("equations");
    var equations = [];
    var i;
    for (i = 0; i < equationsForm.length - 1; i++) {
      //the last element is a button, don't want that!
      //Equations is an array of string, the strings will need to be interpreted as functions later...
      equations.push(equationsForm.elements[i].value);
    }
    var settingsForm = document.getElementById("settings");
    var xMin = eval(settingsForm.elements["xMin"].value);
    var yMin = eval(settingsForm.elements["yMin"].value);

    var xMax = eval(settingsForm.elements["xMax"].value);
    var yMax = eval(settingsForm.elements["yMax"].value);

    var xTick = settingsForm.elements["xTick"].value;
    var yTick = settingsForm.elements["yTick"].value;
    var xLabelDistance = settingsForm.elements["xLabelDistance"].value;
    var yLabelDistance = settingsForm.elements["yLabelDistance"].value;
    var plotLineWidth = settingsForm.elements["plotLineWidth"].value;
    var canvasWidth = settingsForm.elements["canvasWidth"].value;
    var canvasHeight = settingsForm.elements["canvasHeight"].value;

    //Later on, these will need to be sanitized!
    canvas.width = canvasWidth;
    canvas.height = canvasHeight;

    if (xMax <= xMin) {
      console.log("ERROR"); //Fix this once everything's wrapped in a function!
    }
    //Calculate Offset:
    //Draw the axes!
    drawAxes(
      canvas.width / 2 +
        (0 - (xMax + xMin) / 2) * (canvas.width / (xMax - xMin)),
      canvas.height / 2 -
        (0 - (yMax + yMin) / 2) * (canvas.height / (yMax - yMin))
    );

    //Graph the equation on the plot!
    var xVal;
    var yVal;
    var screenX;
    var screenY;
    equations.forEach(function(equation) {
      cxt.beginPath();
      for (i = 0; i < 1001; i++) {
        xVal = xMin + i / 1000 * (xMax - xMin); //Evenly spaces out the x vals among 1001 coords!
        yVal = eval(equation.replace(/x/gi, xVal));
        //So now we have the values in cartesian coordinates, so wee need to change them to screen coordinates
        screenX =
          canvas.width / 2 +
          (xVal - (xMax + xMin) / 2) * (canvas.width / (xMax - xMin));

        screenY =
          canvas.height / 2 -
          (yVal - (yMax + yMin) / 2) * (canvas.height / (yMax - yMin));
        console.log(screenX);
        console.log(screenY);
        if (i == 0) {
          cxt.moveTo(screenX, screenY);
        }
        cxt.lineTo(screenX, screenY);

        cxt.lineWidth = plotLineWidth;
        cxt.strokeStyle = "black";
        cxt.stroke();
      }
    });
  },
  false
);
drawAxes(canvas.width / 2, canvas.height / 2);

function writeMessage(message) {
  cxt.rect(
    canvas.width - 60,
    canvas.height - 30,
    canvas.width - 25,
    canvas.height - 10
  );
  cxt.fillStyle = "white";
  cxt.fill();
  cxt.font = "16pt Calibri";
  cxt.fillStyle = "black";
  cxt.fillText(message, canvas.width - 60, canvas.height - 14);
}

function getMousePos(evt) {
  var rect = canvas.getBoundingClientRect();
  return {
    x: evt.clientX - rect.left,
    y: evt.clientY - rect.top
  };
}

canvas.addEventListener(
  "mousemove",
  function(evt) {
    var mousePos = getMousePos(evt);
    var message = mousePos.x + "," + mousePos.y;
    writeMessage(message);
  },
  false
);

   

});

