<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Canvas Photo Frame Preview</title>
  <style>
    body { font-family: Arial; margin: 20px; }
    #main { display: flex; gap: 30px; }
    #preview { border: 5px solid #ccc; background: #fff; }
    #controls { display: flex; flex-direction: column; gap: 15px; }
    input, select { padding: 6px; width: 150px; }
    .frame-thumb { width: 60px; height: 60px; border: 2px solid transparent; margin: 4px; cursor: pointer; }
    .selected { border: 2px solid blue; }
    #frameOptions { display: flex; flex-wrap: wrap; }
    #imageOptions img { width: 60px; height: 60px; margin: 4px; cursor: pointer; }
  </style>
</head>
<body>
  <h2>Canvas Photo Frame Preview</h2>
  <div id="main">
    <canvas id="preview" width="400" height="400"></canvas>
    <div id="controls">
      <div>
        <strong>Step1 - Enter your Photo Width × Height:</strong><br>
        <input type="number" id="width" placeholder="W" value="300" />
        <input type="number" id="height" placeholder="H" value="300" />
      </div>
      <div>
        <strong>Step2 - Choose Photo or Upload:</strong><br>
        <div id="imageOptions">
          <img src="images/nature1.jpg" onclick="setImage(this.src)">
          <img src="images/nature2.jpg" onclick="setImage(this.src)">
          <input type="file" id="uploadImage" />
        </div>
      </div>
      <div>
        <strong>Step3 - Choose your Photo Frame:</strong><br>
        <div id="frameOptions">
          <img src="frames/frame1.png" class="frame-thumb" onclick="selectFrame(this)">
          <img src="frames/frame2.png" class="frame-thumb" onclick="selectFrame(this)">
        </div>
      </div>
    </div>
  </div>
  <script>
    const canvas = document.getElementById("preview");
    const ctx = canvas.getContext("2d");
    let photo = new Image();
    let frame = new Image();
    let matColor = "#e6489e";
    let photoWidth = 300;
    let photoHeight = 300;
    document.getElementById("width").addEventListener("input", (e) => {
      photoWidth = parseInt(e.target.value);
      updateCanvas();
    });
    document.getElementById("height").addEventListener("input", (e) => {
      photoHeight = parseInt(e.target.value);
      updateCanvas();
    });
    document.getElementById("uploadImage").addEventListener("change", function (e) {
      const reader = new FileReader();
      reader.onload = function (event) {
        photo.src = event.target.result;
        photo.onload = updateCanvas;
      };
      reader.readAsDataURL(e.target.files[0]);
    });
    function setImage(src) {
      photo.src = src;
      photo.onload = updateCanvas;
    }
    function selectFrame(elem) {
      document.querySelectorAll(".frame-thumb").forEach(el => el.classList.remove("selected"));
      elem.classList.add("selected");
      frame.src = elem.src;
      frame.onload = updateCanvas;
    }
    function updateCanvas() {
      canvas.width = photoWidth + 100;
      canvas.height = photoHeight + 100;
      const offset = 50;
      ctx.fillStyle = matColor;
      ctx.fillRect(0, 0, canvas.width, canvas.height);
      ctx.drawImage(photo, offset, offset, photoWidth, photoHeight);
      if (frame && frame.complete) {
        ctx.drawImage(frame, 0, 0, canvas.width, canvas.height);
      }
    }
    window.onload = () => {
      setImage("images/nature1.jpg");
      selectFrame(document.querySelector(".frame-thumb"));
    };
  </script>
</body>
</html>