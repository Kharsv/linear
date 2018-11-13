<div class="main">


<br>

<br>
<canvas id="myCanvas" width="800" height="600" style="border:1px solid #000000;">
Your browser does not support the HTML5 canvas tag.
</canvas>

<div>
  Точка начала отрезка
  <label>X:</label>
  <input type="number" id="x1" />
  <label>Y:</label>
  <input type="number" id="y1" />
  <br>
  Точка конца отрезка
  <label>X:</label>
  <input type="number" id="x2" />
  <label>Y:</label>
  <input type="number" id="y2" />
  <br>
  <button id="add">Add</button>
  <button id="update">Update</button>
</div>
<div id="points"></div>

  <div class="alert alert-success" role="alert">
                  <h4 class="alert-heading">Отличная работа!</h4>
                  

                     <p>Вы успешно прочитали это важное сообщение. Это пример текста немного длиннее, так что вы увидите, как работают отступы в сообщениях уведомлений.</p>
                        <hr>
                  <p class="mb-0">Когда необходимо, используйте марджины для создания необходимых отступов.</p>
             </div>

<canvas id="myCanvas-1" width="1000" height="400"></canvas>
<!-- Form structure inspired by GraphSketch.com -->
<table><tr>
<td style="vertical-align:top"><form id="equations">
  <h4>Put your functions here:</h4><br>
  f(x) <input type="text" name="f1" value="1"><br>
  <input type="button" value="Graph" id="graphNow">
  </form></td>
  <td width="100"></td>
<td style="vertical-align:top"><form id="settings">
  <h4>Settings:</h4><br>
  X range: <input type="text" name="xMin" value="-10"> to <input type="text" name="xMax" value="10"><br>
  Y range: <input type="text" name="yMin" value="-10"> to <input type="text" name="yMax" value="10"><br>
  X Tick Distance: <input type="text" name="xTick" value="1"><br>
  Y Tick Distance: <input type="text" name="yTick" value="1"><br>
  Label every: <input type="text" name="xLabelDistance" value="1"> X ticks<br>
  Label every: <input type="text" name="yLabelDistance" value="1"> Y ticks<br>
  Plot Line Width: <input type="text" name="plotLineWidth" value="4"><br>
  Graph Pixel Width: <input type="text" name="canvasWidth" value="1000">
  Graph Pixel Height: <input type="text" name="canvasHeight" value="400">
  
  </form></td>
</tr></table>

</div>
