<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title><?php if(isset($page_title)) echo $page_title; ?> | User authenication system</title>
    <script type="text/javascript" src="css/paper-full.js"></script>
    <script type="text/paperscript" canvas="myCanvas">
    
    ////////////////////////////////////////////////////////////////////////////////
    // Interface

    var values = {
        fixLength: false,
        fixAngle: false,
        showCircle: false,
        showAngleLength: true,
        showCoordinates: false
    };

    ////////////////////////////////////////////////////////////////////////////////
    // Vector

    var vectorStart, vector, vectorPrevious;
    var vectorItem, items, dashedItems;

    function processVector(event, drag) {
        vector = event.point - vectorStart;
        if (vectorPrevious) {
            if (values.fixLength && values.fixAngle) {
                vector = vectorPrevious;
            } else if (values.fixLength) {
                vector.length = vectorPrevious.length;
            } else if (values.fixAngle) {
                vector = vector.project(vectorPrevious);
            }
        }
        drawVector(drag);
    }

    function drawVector(drag) {
        if (items) {
            for (var i = 0, l = items.length; i < l; i++) {
                items[i].remove();
            }
        }
        if (vectorItem)
            vectorItem.remove();
        items = [];
        var arrowVector = vector.normalize(10);
        var end = vectorStart + vector;
        vectorItem = new Group(
            new Path(vectorStart, end),
            new Path(
                end + arrowVector.rotate(135),
                end,
                end + arrowVector.rotate(-135)
            )
        );
        vectorItem.strokeWidth = 0.75;
        vectorItem.strokeColor = '#e4141b';
        // Display:
        dashedItems = [];
        // Draw Circle
        if (values.showCircle) {
            dashedItems.push(new Path.Circle(vectorStart, vector.length));
        }
        // Draw Labels
        if (values.showAngleLength) {
            drawAngle(vectorStart, vector, !drag);
            if (!drag)
                drawLength(vectorStart, end, vector.angle < 0 ? -1 : 1, true);
        }
        var quadrant = vector.quadrant;
        if (values.showCoordinates && !drag) {
            drawLength(vectorStart, vectorStart + [vector.x, 0],
                    [1, 3].indexOf(quadrant) != -1 ? -1 : 1, true, vector.x, 'x: ');
            drawLength(vectorStart, vectorStart + [0, vector.y],
                    [1, 3].indexOf(quadrant) != -1 ? 1 : -1, true, vector.y, 'y: ');
        }
        for (var i = 0, l = dashedItems.length; i < l; i++) {
            var item = dashedItems[i];
            item.strokeColor = 'black';
            item.dashArray = [1, 2];
            items.push(item);
        }
        // Update palette
        values.x = vector.x;
        values.y = vector.y;
        values.length = vector.length;
        values.angle = vector.angle;
    }

    function drawAngle(center, vector, label) {
        var radius = 25, threshold = 10;
        if (vector.length < radius + threshold || Math.abs(vector.angle) < 15)
            return;
        var from = new Point(radius, 0);
        var through = from.rotate(vector.angle / 2);
        var to = from.rotate(vector.angle);
        var end = center + to;
        dashedItems.push(new Path.Line(center,
                center + new Point(radius + threshold, 0)));
        dashedItems.push(new Path.Arc(center + from, center + through, end));
        var arrowVector = to.normalize(7.5).rotate(vector.angle < 0 ? -90 : 90);
        dashedItems.push(new Path([
                end + arrowVector.rotate(135),
                end,
                end + arrowVector.rotate(-135)
        ]));
        if (label) {
            // Angle Label
            var text = new PointText(center
                    + through.normalize(radius + 10) + new Point(0, 3));
            text.content = Math.floor(vector.angle * 100) / 100 + '\xb0';
            items.push(text);
        }
    }

    function drawLength(from, to, sign, label, value, prefix) {
        var lengthSize = 5;
        if ((to - from).length < lengthSize * 4)
            return;
        var vector = to - from;
        var awayVector = vector.normalize(lengthSize).rotate(90 * sign);
        var upVector = vector.normalize(lengthSize).rotate(45 * sign);
        var downVector = upVector.rotate(-90 * sign);
        var lengthVector = vector.normalize(
                vector.length / 2 - lengthSize * Math.SQRT2);
        var line = new Path();
        line.add(from + awayVector);
        line.lineBy(upVector);
        line.lineBy(lengthVector);
        line.lineBy(upVector);
        var middle = line.lastSegment.point;
        line.lineBy(downVector);
        line.lineBy(lengthVector);
        line.lineBy(downVector);
        dashedItems.push(line);
        if (label) {
            // Length Label
            var textAngle = Math.abs(vector.angle) > 90
                    ? textAngle = 180 + vector.angle : vector.angle;
            // Label needs to move away by different amounts based on the
            // vector's quadrant:
            var away = (sign >= 0 ? [1, 4] : [2, 3]).indexOf(vector.quadrant) != -1
                    ? 8 : 0;
            var text = new PointText(middle + awayVector.normalize(away + lengthSize));
            text.rotate(textAngle);
            text.justification = 'center';
            value = value || vector.length;
            text.content = (prefix || '') + Math.floor(value * 1000) / 1000;
            items.push(text);
        }
    }

    ////////////////////////////////////////////////////////////////////////////////
    // Mouse Handling

    var dashItem;

    function onMouseDown(event) {
        var end = vectorStart + vector;
        var create = false;
        if (event.modifiers.shift && vectorItem) {
            vectorStart = end;
            create = true;
        } else if (vector && (event.modifiers.option
                || end && end.getDistance(event.point) < 10)) {
            create = false;
        } else {
            vectorStart = event.point;
        }
        if (create) {
            dashItem = vectorItem;
            vectorItem = null;
        }
        processVector(event, true);
    }

    function onMouseDrag(event) {
        if (!event.modifiers.shift && values.fixLength && values.fixAngle)
            vectorStart = event.point;
        processVector(event, event.modifiers.shift);
    }

    function onMouseUp(event) {
        processVector(event, false);
        if (dashItem) {
            dashItem.dashArray = [1, 2];
            dashItem = null;
        }
        vectorPrevious = vector;
    }
    </script>
</head>
<body>
    <div class="container">
    
                <div class="alert alert-success" role="alert">
                  <h4 class="alert-heading">Отличная работа!</h4>
                     <p>Вы успешно прочитали это важное сообщение. Это пример текста немного длиннее, так что вы увидите, как работают отступы в сообщениях уведомлений.</p>
                        <hr>
                  <p class="mb-0">Когда необходимо, используйте марджины для создания необходимых отступов.</p>
             </div>
        <div class="header">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">
    <img src="css/facebook.png" width="30" height="30" alt="">
  </a>
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="view/p2.php">Link</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>


            
            



        </div>






    






