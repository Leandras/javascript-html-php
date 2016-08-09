var score = 0;
var crash = false;

window.onload = function(){
window.addEventListener("keydown", keyboardInput, false);
window.addEventListener("keypressed", keyboardInput, false);
window.addEventListener("keyup", keyboardInput, false);

var div; 
var canvas;
var ctx;
var width;
var height;
var numberOfObjects;
var snakeHead,snakeBody,wisdom_scroll,mirror_scroll,greed_scroll,laziness_scroll,voracity_scroll;
var divPontszam = document.getElementById('pontszam');

var keypressedNumber = 0;
var snake = {
   positionX : 0,
   positionY : 0,
   size : [10,10]
  }

var snakeBodyParts = {"parts" : []};

var obsticles = {"obsticle" : []};

var objects = {"scrolls" : [
	{
		"name" : "wisdom",
		"possibility" : 80,
		"imagesrc" : "src/wisdom_scroll.png",
    "init" : true
	},
	{
		"name" : "mirror",
		"possibility" : 4,
		"imagesrc" : "src/mirror_scroll.png",
    "init" : false
	},
  {
    "name" : "translate",
    "possibility" : 4,
    "imagesrc" : "src/translate_scroll.png",
    "init" : false
  },
	{
		"name" : "greed",
		"possibility" : 4,
		"imagesrc" : "src/greed_scroll.png",
    "init" : false
	},
	{
		"name" : "laziness",
		"possibility" : 4,
		"imagesrc" : "src/laziness_scroll.png",
    "init" : false
	},
	{
		"name" : "voracity",
		"possibility" : 4,
		"imagesrc" : "src/voracity_scroll.png",
    "init" : false
	}
]};

//}

  document.querySelector('#createCanvas').onclick = init;

  function init(){
  	if(checkInput() === 4){
  	  initCanvas();
  	  loaded();
  	 }
  }


function checkInput(){
  if(document.querySelector('#canvasWidth').value < 1 || document.querySelector('#canvasWidth').value > 1000){
  	alert("A pálya szélessége nem megfelelő. Csak 1-1000 közötti szám lehet!");
  	return 1;
  }else if (document.querySelector('#canvasHeight').value < 1 || document.querySelector('#canvasHeight').value > 1000){
  	alert("A pálya magassága nem megfelelő. Csak 1-1000 közötti szám lehet!");
  	return 2;
  }else if(document.querySelector('#objectNumber').value < 1 || document.querySelector('#objectNumber').value > 6){
  	alert("A pályán lévő megjelenő objektumok száma nem megfelelő. Csak 1-6 közötti szám lehet!");
  	return 3;
  }else{
  	return 4;
  }
}

function initCanvas(){
	objectOnTheField = false;
    if(document.getElementById("canvas") != null){
      div.removeChild(canvas);
      document.body.removeChild(div);
      width = document.querySelector('#canvasWidth').value;
	    height = document.querySelector('#canvasHeight').value;
      numberOfObjects = document.querySelector('#objectNumber').value;
	    setUpCanvas();
	    keypressedNumber = 0;

    }else{
	  width = document.querySelector('#canvasWidth').value;
	  height = document.querySelector('#canvasHeight').value;
    numberOfObjects = document.querySelector('#objectNumber').value;
	  setUpCanvas(width,height);
	}
  }

  //Canvas generálása
  function setUpCanvas() {
  	div = document.createElement("canvasDiv");
  	document.body.appendChild(div);
    canvas = document.createElement("canvas");
    canvas.id = "canvas";
    canvas.width = width;
    canvas.height = height;
    canvas.style = "border:1px solid #000000";
    if (canvas.getContext){
      initImages();
      ctx = canvas.getContext('2d');
      ctx.clearRect(0,0,width,height);
      if(document.getElementById("obsticlesRadio").checked){
        createObstacles();
      }
      spawnScroll();
      drawSnake();
      ctx.strokeRect(0,0,width,height);
    } else {
      console.log("Nem támogatott!");
    }
    div.appendChild(canvas);
  }

  //Képek betöltése
  function initImages(){
  	snakeHead = new Image();
  	snakeHead.src = "src/head_right.png";
  	snakeBody = new Image();
  	snakeBody.src = "src/body.png";
  	wisdom_scroll = new Image();
  	wisdom_scroll.src = objects.scrolls[0].imagesrc;
  	mirror_scroll = new Image();
	  mirror_scroll.src = objects.scrolls[1].imagesrc;
    translate_scroll = new Image();
    translate_scroll.src = objects.scrolls[2].imagesrc;
	  greed_scroll = new Image();
	  greed_scroll.src = objects.scrolls[3].imagesrc;
	  laziness_scroll = new Image();
	  laziness_scroll.src = objects.scrolls[4].imagesrc;
	  voracity_scroll = new Image();
	  voracity_scroll.src = objects.scrolls[5].imagesrc;
  }

  function checkSnakePosition(){
  	return snake.positionX + " " + snake.positionY;
  }
  
  //Tereptárgy obejktumok generálása
  function createObstacles(){
    for(var i = 0; i < 5; i++){
      obsticles["obsticle"].push({
        "positionX" : 0,
        "positionY" : 0
      });  
    }
    //console.log(obsticles["obsticle"].length);
    for(var i = 0; i < obsticles["obsticle"].length; i++){
      drawObstacle(i);
      //console.log(i);
    }
    
  }

  //Tereptárgyak pozicíójának rekurzív ellenőrzése, hogy ne rajzolja egymásra őket
  function drawObstacle(obsticleId){
    var obX = Math.random() * (width - 10) + 10;
    var obY = Math.random() * (height - 10) + 10;
    if(checkObsticle(obX,obY)){
      drawObstacle(obsticleId);
    }else{
      obsticles.obsticle[obsticleId].positionX = obX;
      obsticles.obsticle[obsticleId].positionY = obY;
      ctx.drawImage(snakeBody, obsticles.obsticle[obsticleId].positionX, obsticles.obsticle[obsticleId].positionY, 10, 10);
    }
  }

  /***************FPS******************/
  var objectOnTheField = false;
  function loaded(){
  	mainloop();
  }

  var speed = 10; 
  var countDown = 50; //Lustaság és mohóság scrollok esetén az 5 másodperces visszaszámláló
  var speedChanged = false; //Lustaság és mohóság scrollok esetén ellenőrzni az állapotot
  var crash = false;
  
  function mainloop() {
  	setTimeout(function(){
  	window.requestAnimationFrame(mainloop);
  	if (rightKeys() && insideField()){
      if(checkObsticle(snakeCurrentPosition[0], snakeCurrentPosition[1]) && !crash){
        score = snakeBodyParts["parts"].length;
        divPontszam.innerHTML = score;
          clearInterval(mainloop);
          crash = true;
      }
  		updateSnake();
  		if(!objectOnTheField){
  		  spawnScroll();
  		}
  		if(pickUpScroll()){
  		  ctx.clearRect(scrollPosition[0], scrollPosition[1], 10, 10);
  		  objectOnTheField = false;

  		}
  	}else{
  		if(!insideField()){
        score = snakeBodyParts["parts"].length;
          divPontszam.innerHTML = score;
         // clearInterval(mainloop);
      }
  	}
    if(speedChanged){
      countDown--;
      if(countDown === 0){
        speedChanged = false;
        countDown = 50;
        speed = 10; 
      }
    }
  	},1000 / speed);
  }

 
  
  var snakeCurrentPosition = [0,0]; //A "sárkány" fejének az X és Y pozíciója
  
  //Canvas készítésekor a "sárkány" kezdőpozíciójának megrajzolása
  function drawSnake(){
  	snakeCurrentPosition[0] = 30; //snake kezdeti X pozíciója
  	snakeCurrentPosition[1] = (height/2); //snake kezdeti Y pozíciója
  	ctx.drawImage(snakeHead,snakeCurrentPosition[0],snakeCurrentPosition[1],10,10);

  }
  
  //"Sárkány" feje alapján az irány kiválasztása és pozíciók átadása a test rajzolására
  function updateSnake(){
    var snakeOldPosition = [0,0];
  	if(!objectOnTheField){
  		spawnScroll();
  	}if(!crash){
  		if(keypressedNumber === 37 && insideField()){
  			ctx.clearRect(snakeCurrentPosition[0],snakeCurrentPosition[1],10,10);
  			snakeHead.src = "src/head_left.png";
        snakeOldPosition[0] = snakeCurrentPosition[0];
        snakeOldPosition[1] = snakeCurrentPosition[1];
  			snakeCurrentPosition[0] = snakeCurrentPosition[0]-10;
  			ctx.drawImage(snakeHead,snakeCurrentPosition[0], snakeCurrentPosition[1],10,10);
        updateSnakeBody(snakeOldPosition[0],snakeOldPosition[1]);
  		}else if(keypressedNumber === 38 && insideField()){
  			ctx.clearRect(snakeCurrentPosition[0], snakeCurrentPosition[1], 10, 10);
  			snakeHead.src = "src/head_up.png";
  			snakeOldPosition[1] = snakeCurrentPosition[1];
        snakeOldPosition[0] = snakeCurrentPosition[0];
  			snakeCurrentPosition[1] -= 10;
  			ctx.drawImage(snakeHead, snakeCurrentPosition[0],snakeCurrentPosition[1], 10, 10);
        updateSnakeBody(snakeOldPosition[0],snakeOldPosition[1]);
  		}else if(keypressedNumber === 39 && insideField()){
  			ctx.clearRect(snakeCurrentPosition[0], snakeCurrentPosition[1], 10, 10);
  			snakeHead.src = "src/head_right.png";
        snakeOldPosition[0] = snakeCurrentPosition[0];
        snakeOldPosition[1] = snakeCurrentPosition[1];
  			snakeCurrentPosition[0] += 10;
  			ctx.drawImage(snakeHead, snakeCurrentPosition[0], snakeCurrentPosition[1], 10, 10);
        updateSnakeBody(snakeOldPosition[0],snakeOldPosition[1]);
  		}else if(keypressedNumber === 40 && insideField()){
  			ctx.clearRect(snakeCurrentPosition[0],snakeCurrentPosition[1], 10, 10);
  			snakeHead.src = "src/head_down.png";
        snakeOldPosition[0] = snakeCurrentPosition[0];
  			snakeOldPosition[1] = snakeCurrentPosition[1];
  			snakeCurrentPosition[1] += 10;
  			ctx.drawImage(snakeHead, snakeCurrentPosition[0], snakeCurrentPosition[1], 10, 10);
        updateSnakeBody(snakeOldPosition[0],snakeOldPosition[1]);
  		}
    }
    /*Tekercs felvételekor az események
      0--> Bölcsesség tekercs, 4 egységgel nő a test
      1--> Tükör tekercs, irányítás felcserélése
      2--> Fordítás tekercs, kígyó feje farka helyett
      3--> Mohóság tekercse, 5 másodpercig 1,5-szörösre nő a sebesség
      4--> Lustaság tekerecs, 5 másodpercig 1/5-re csökken a sebesség
      5--> Falánkság tekercse, 10 egységgel nő a test
    */
  	if(pickUpScroll()){
      if(scrollEffect === 0){
  		for(var i = 0; i < 4; ++i){
  			snakeBodyParts["parts"].push({
          "name" : "body",
          "imagesrc" : "src/body.png",
          "bodyPartPositionX" : 0,
          "bodyPartPositionY" : 0,
          "bodyOldPositionX" : 0,
          "bodyOldPositionY" : 0
        });
    }
    }else if(scrollEffect === 1){
      mirroredControll = true;
    }else if(scrollEffect === 2){
      
    }else if(scrollEffect === 3){
      speed = Math.floor(speed * 1.5);
      speedChanged = true;
    }else if (scrollEffect === 4){
      speed = Math.floor(speed/(1.5));
      speedChanged = true;
    }else if(scrollEffect === 5){
      for(var i = 0; i < 10; ++i){
        snakeBodyParts["parts"].push({
          "name" : "body",
          "imagesrc" : "src/body.png",
          "bodyPartPositionX" : 0, 
          "bodyPartPositionY" : 0,
          "bodyOldPositionX" : 0,
          "bodyOldPositionY" : 0
        });
      }
    }
  	}

  }

  //"Sárkány" fejétől kapott pozíciók alapján a test megrajzolása és helyének frissítése
  function updateSnakeBody(snakeOldPositionX, snakeOldPositionY){
    var oldBodyPosition = [0,0];
  	if(snakeBodyParts["parts"].length > 0){
  	  for(var i = 0; i < snakeBodyParts["parts"].length; i++){
        ctx.clearRect(snakeBodyParts.parts[i].bodyPartPositionX,snakeBodyParts.parts[i].bodyPartPositionY,10,10);
        snakeBodyParts.parts[i].bodyOldPositionX = snakeBodyParts.parts[i].bodyPartPositionX;
        snakeBodyParts.parts[i].bodyOldPositionY = snakeBodyParts.parts[i].bodyPartPositionY;
        if(i > 0){
              snakeBodyParts.parts[i].bodyPartPositionX = snakeBodyParts.parts[i-1].bodyOldPositionX;
              snakeBodyParts.parts[i].bodyPartPositionY = snakeBodyParts.parts[i-1].bodyOldPositionY;
              if(snakeCurrentPosition[0] === snakeBodyParts.parts[i].bodyPartPositionX && snakeCurrentPosition[1] === snakeBodyParts.parts[i].bodyPartPositionY && !crash){
                score = snakeBodyParts["parts"].length;
                divPontszam.innerHTML = score;
                clearInterval(mainloop);
                crash = true;
              }
        }
        if(i < 1){
          snakeBodyParts.parts[0].bodyPartPositionX = snakeOldPositionX;
          snakeBodyParts.parts[0].bodyPartPositionY = snakeOldPositionY; 
        }
        drawSnakeBody(i);        
  	  }
  	}
  }

  function drawSnakeBody(bodyId){
    ctx.drawImage(snakeBody, snakeBodyParts.parts[bodyId].bodyPartPositionX, snakeBodyParts.parts[bodyId].bodyPartPositionY,10,10);
  }

  var scrollPosition = [0,0]; 
  var scrollEffect = 0;

  /*Tekercs készítése. 
    allowedScrolls --> Be lehet állítani hány tekercs jelenhet meg, előfordulások alapján. pl.: 1 tekercs esetén az 'allowedScrolls' 80, tehát csak
    egy, a bölcsesség tekercs jelenhet meg. 2 esetén az 'allowedScrolls' 84, tehát már megjelenhet a tülör tekercse is.
    scrollChance --> Melyik tekercs jelenik meg
    choosenScroll --> A random szám által választott tekercs neve
  */
  function spawnScroll(){
    var allowedScrolls = 76;
    for(var i = 0; i < numberOfObjects; ++i){
      allowedScrolls+=4;
    }
    var scrollChance = Math.floor(Math.random()* (allowedScrolls) + 0);
    var choosenScroll = wisdom_scroll;
    if(scrollChance >=0 && scrollChance <= 80){
      choosenScroll = wisdom_scroll;
      scrollEffect = 0;
    }else if(scrollChance >=81 && scrollChance <= 84){
      choosenScroll = mirror_scroll;
      scrollEffect = 1;
    }else if(scrollChance >=85 && scrollChance <= 88){
      choosenScroll = translate_scroll;
      scrollEffect = 2;
    }else if(scrollChance >=89 && scrollChance <= 92){
      choosenScroll = greed_scroll;
      scrollEffect = 3;
    }else if(scrollChance >=92 && scrollChance <= 96){
      choosenScroll = laziness_scroll;
      scrollEffect = 4;
    }else{
      choosenScroll = voracity_scroll;
      scrollEffect = 5;
    }
    scrollPosition[0] = Math.floor(Math.random() * (width-15)) + 0;
    scrollPosition[1] = Math.floor(Math.random() * (height-15)) + 0;
    //Ellenőrzi, hogy ne tereptárgyra rajzolja a tekercset
    if(checkObsticle(scrollPosition[0],scrollPosition[1])){
      spawnScroll();
    }
  	ctx.drawImage(choosenScroll,scrollPosition[0], scrollPosition[1], 15, 15);
    //Jelzi a programnak hogy a tekercs a pályán van
  	objectOnTheField = true;
  }

  //Tükör tekercs felvétele esetén irányítás megfordítása
  var mirroredControll = false;
  function keyboardInput(e){
    if(mirroredControll){
      if(e.keyCode === 37){
        keypressedNumber = 39
      }else if(e.keyCode === 38){
        keypressedNumber = 40;
      }else if(e.keyCode === 39){
        keypressedNumber =37
      }else if(e.keyCode === 40){
        keypressedNumber = 38;
      }
    }else{
  	  keypressedNumber = e.keyCode;
    }
  }

  //"Sárkány" pozíciójának ellenőrzése, hogy még a játékterületen belül van-e
  function insideField(){
  	return snakeCurrentPosition[0] <= width-10 && snakeCurrentPosition[0] >= 0 && snakeCurrentPosition[1] <= height-10 && snakeCurrentPosition[1] >= 0; 
  }

  //Billentyűk ellenörzése
  function rightKeys(){
  	return (keypressedNumber === 37 || keypressedNumber === 38 || keypressedNumber === 39 || keypressedNumber === 40);
  }

  //Tekercs felvétele
  function pickUpScroll(){
  	if(snakeCurrentPosition[0] > scrollPosition[0]-1 && snakeCurrentPosition[0] < scrollPosition[0] + 21 &&
     snakeCurrentPosition[1] > scrollPosition[1]-1 && snakeCurrentPosition[1] < scrollPosition[1] + 21){
  		ctx.clearRect(scrollPosition[0],scrollPosition[1],15,15);
      bodyDrawn = false;
  		return true;
  	}else{
  		return false;
  	}
  }

  //Tereptárgyal való ütközés ellenőrzése. Másik feladata hogy ellnőtizze ne rajzoljon meglévő terptárgyra tereptárgyat vagy tekercset
  function checkObsticle (positionX, positionY) {
    for(var i = 0; i < obsticles["obsticle"].length; i++){
      if(positionX > obsticles.obsticle[i].positionX-1 && positionY > obsticles.obsticle[i].positionY-1 &&
        positionX < obsticles.obsticle[i].positionX+11 && positionY < obsticles.obsticle[i].positionY+11){
        return true;
      }
    }
  }

}

function sendScore(){
    ajax({
      type: "GET",
      getdata : "score=" + score,
      url: "../modules/ajax_info.php",
      success: function(data){
        console.log("siker");
        console.log(score);
        /*var pontszam = score;
        pontszam.value = score;*/

      },
      error: function(){
        console.log("hiba");
      }
    });
    
  }
