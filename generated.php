<!DOCTYPE html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0" />
    <title>kagamast</title>
    <link rel="icon" type="image/x-icon" href="favicon.png">
<style>
:root{
    --textcolor: #307cff;
}
#topbar{
    color: var(--textcolor);
    font-family: 'Montserrat', sans-serif;
    position: absolute;
    top: 0%;
    left: 0%;
    background-color: rgb(39, 39, 39);
    height: 100px;
    width: 100%;
    padding: 0;
}
.topthing{
    font-size: 70px;
    color: var(--textcolor);
    font-family: 'Montserrat', sans-serif;
    position: absolute;
    top: 0;
    right: 0;
    background-color: rgb(39, 39, 39);
    height: 100px;
    display: block;
    top: 0;
    margin: 0;
    padding: 5px 20px 0 20px;
    border-radius: 0 0 0 20px;
}
.topthing>span{
    font-size: 50px;
}
body{
    width: 100%;
    height: 100%;
    overflow: hidden;
    background-color: #0e0e0e;
}
.material-symbols-outlined {
  font-variation-settings:
  'FILL' 1,
  'wght' 400,
  'GRAD' 0,
  'opsz' 48
}
#rocket{
    position: absolute;
    width: 100px;
    z-index: 100;
    transform: translate(-50%, 50%);
}
#finish{
    transform: translate(-50%, 50%);
    position: absolute;
    width: 20px;
    height: 100px;
    z-index: 99;
    background-image: linear-gradient(black 50%, white 50%), linear-gradient(white 50%, black 50%);
    background-size: 50% 20px;
    background-repeat: repeat-y;
    background-position: right, left;
}
.dot{
    width: 10px;
    height: 10px;
    position: absolute;
    border-radius: 100%;
    background-color: white;
}
/*#source{
    position: absolute;
    left: 500px;
    bottom: 590px;
    width: 20px;
    height: 20px;
    border-radius: 100%;
    background-color: red;
}*/
.planet{
    z-index: 2;
    position: absolute;
    height: 80px;
    width: 80px;
    margin-bottom: -40px;
    margin-left: -40px;
    background-color: rgb(255, 111, 0);
    background-image: linear-gradient(350deg, transparent 40%, #fff4 40%, #fff4 70%, transparent 70%);
    border-radius: 100%;
}
.star{
    z-index: 2;
    position: absolute;
    height: 100px;
    width: 100px;
    margin-bottom: -50px;
    margin-left: -50px;
    background-color: #fff;
    box-shadow: 0 0 20px white;
    border-radius: 100%;
}
.blackHole{
    z-index: 2;
    position: absolute;
    height: 100px;
    width: 100px;
    margin-bottom: -50px;
    margin-left: -50px;
    background-color: #000;
    box-shadow: 0 0 20px #000;
    border-radius: 100%;
}
#infoboard{
    display: none;
    font-family: monospace;
    font-size: 70px;
    text-align: center;
    position: fixed;
    z-index: 1000;
    background-color: #000d;
    min-width: 100px;
    min-height: 100px;
    left: 50vw;
    top: 50vh;
    transform: translate(-50%, -50%);
    color: white;
    padding: 30px;
    border-radius: 40px;
    animation: slideIn 0.5s ease-out 1s forwards;
    opacity: 0;
}
#infoboard h3, h4{
    margin: 0;
}
.wall{
    z-index: 1;
    position: absolute;
    background-color: #db4d19;
}
@keyframes slideIn {
    from{opacity: 0;}
    to{opacity: 1;}
}
</style>
</head>




<body id="body">
        <p class="topthing" id="maxscore" style="float: right;"><span class="material-symbols-outlined">
            military_tech
            </span>000</p>
<img src="gameImages/rocket.png" alt="rocket" id="rocket">
<div id="finish"></div>
<div id="dotContainer">
</div>
<div id="source">
</div>
<div id="infoboard">
    <h3 id="infoboardTitle"></h3>
    <h4 id="infoboardDescription" style="font-size: 50px;"></h4>
</div>
</body>




<script>
const posXtoPercent = (x) => ((window.innerWidth * 0.9) - x) / (window.innerWidth * 0.9) * -100 + 100;
const posYtoPercent = (y) => (y - (window.innerHeight * 0.1)) / (window.innerHeight * 0.9) * -100 +100;
const posXtoAbsolute = (x) => x * ((window.innerWidth) / 100);
const posYtoAbsolute = (y) => y * ((window.innerHeight) / 100);
let hexChars = "23456789a"
let starChars = "9abcdef"
let dotContainer = document.getElementById("dotContainer");
let objectContainer = document.getElementById("source");
let dotclass = document.getElementsByClassName("dot");
let displayWall = document.getElementsByClassName("wall");
let wallList = [];
let distanceX = 0;
let distanceY = 0;
let angle = 0;
let rocket = {
    size: 11,
    id: document.getElementById('rocket'),
    positionX: 70,
    positionY: window.innerHeight / 2,
    velocityX: 0,
    velocityY: 0,
    status: 0,
}
let finish = {
    id: document.getElementById("finish"),
    height: 100,
    positionX: window.innerWidth - 10,
    positionY: window.innerHeight / 2,
}
let objectRadius = {
    planet: 20,
    star: 25,
    blackHole: 30,
}
let infoboard = {
    id: document.getElementById("infoboard"),
    title: document.getElementById("infoboardTitle"),
    description: document.getElementById("infoboardDescription"),
    visible: false,
}
const gravitySources = []; // size, X, Y, type
<?php
        $objectOrigin = $_GET['objects'];
        $objects = explode("|", $objectOrigin);
        if(count($objects) > 1){
            for($i = 1; $i < count($objects); $i++){
                echo "createCelestialObject(";
                $subObjects[$i] = explode(",", $objects[$i]);
                for($j = 0; $j < count($subObjects[$i]); $j++){
                    if(substr($subObjects[$i][$j], 0, 2) == "ph"){
                        $subObjects[$i][$j] = "window.innerHeight / 100 * " . ltrim($subObjects[$i][$j], "ph");
                    } elseif(substr($subObjects[$i][$j], 0, 2) == "pw"){
                        $subObjects[$i][$j] = "window.innerWidth / 100 * " . ltrim($subObjects[$i][$j], "pw");
                    }
                    echo $subObjects[$i][$j] . ", ";
                }
                echo  "); ";
            }
        }
        $wallOrigin = $_GET['walls'];
        $walls = explode("|", $wallOrigin);
        if(count($walls) > 1){
            for($i = 1; $i < count($walls); $i++){
                echo "buildWall(";
                $subWalls[$i] = explode(",", $walls[$i]);
                for($j = 0; $j < count($subWalls[$i]); $j++){
                    if(substr($subWalls[$i][$j], 0, 2) == "ph"){
                        $subWalls[$i][$j] = "posYtoAbsolute(" . ltrim($subWalls[$i][$j], "ph") . ")";
                    } elseif(substr($subWalls[$i][$j], 0, 2) == "pw"){
                        $subWalls[$i][$j] = "posXtoAbsolute(" . ltrim($subWalls[$i][$j], "pw") . ")";
                    }
                    echo $subWalls[$i][$j];
                    if($j != 3){
                        echo ",";
                    }
                }
                echo  "); ";
            }
        }
?>// ?objects=20,1200,ph50,"blackHole"|1,400,ph50,"planet"|3,800,ph50,"star"
//buildWall(200, 200, 400, 100);
let forces = [];
let randomColor = "#444";

moveRocket(rocket.positionX, rocket.positionY);
moveFinish(finish.positionX, finish.positionY);

function degrees_to_radians(degrees){
  var pi = Math.PI;
  return degrees * (pi/180);
}
function moveRocket(positionX, positionY){
    rocket.id.style.left = positionX + "px";
    rocket.id.style.bottom = positionY + "px";
    switch(rocket.status){
        case 0: rocket.id.src = "gameImages/rocket.png";
            break;
        case 1: rocket.id.src = "gameImages/rocket.png";
            break;
        case 2: rocket.id.src = "gameImages/rocketRunning.gif";
            break;
        case 3: rocket.id.src = "gameImages/rocketStopping.png";
            break;
    }

}
function moveFinish(positionX, positionY){
    finish.id.style.left = positionX + "px";
    finish.id.style.bottom = positionY + "px";
}
function rotateRocket(distanceX, distanceY){
    if(distanceX >= 0){
        angle = -Math.atan(distanceY / distanceX);
    }else{
        angle = Math.atan(distanceY / -distanceX) + degrees_to_radians(180);
    }
    rocket.id.style.transform = "translate(-50%, 50%) rotate(" + angle + "rad)";
}

function createCelestialObject(size, positionX, positionY, type){
    objectContainer.innerHTML += '<div class="' + type + '"></div>';
    document.getElementsByClassName(type)[document.getElementsByClassName(type).length - 1].style.left = positionX +"px";
    document.getElementsByClassName(type)[document.getElementsByClassName(type).length - 1].style.bottom = positionY +"px";
    if(type == "planet"){
        document.getElementsByClassName(type)[document.getElementsByClassName(type).length - 1].style.backgroundColor = "#" + hexChars[Math.floor(Math.random() * hexChars.length)] + hexChars[Math.floor(Math.random() * hexChars.length)] + hexChars[Math.floor(Math.random() * hexChars.length)];
    }
    if(type == "star"){
        let randomKey = Math.floor(Math.random() * hexChars.length);
        let shade = Math.floor(Math.random() * (starChars.length - 1));
        document.getElementsByClassName(type)[document.getElementsByClassName(type).length - 1].style.backgroundColor = "#" + starChars[shade] + starChars[shade] + starChars[starChars.length - (shade +1)];
    }
    gravitySources.push([size, positionX, positionY, type]);
}
function buildWall(positionX1, positionY1, positionX2, positionY2){
    objectContainer.innerHTML += "<div class=\"wall\"></div>";
    left = Math.min(positionX1, positionX2);
    bottom = Math.min(positionY1, positionY2);
    width = Math.max(positionX1, positionX2) - Math.min(positionX1, positionX2);
    height = Math.max(positionY1, positionY2) - Math.min(positionY1, positionY2);
    displayWall[displayWall.length - 1].style.left = left + "px";
    displayWall[displayWall.length - 1].style.bottom = bottom + "px";
    displayWall[displayWall.length - 1].style.width = width + "px";
    displayWall[displayWall.length - 1].style.height = height + "px";
    wallList.push([left, bottom, width, height]);
}


window.addEventListener('mousemove', (e) => {
    if(rocket.status == 0){
        distanceX = e.clientX - rocket.positionX;
        distanceY = window.innerHeight - e.clientY - rocket.positionY;
        rotateRocket(distanceX, distanceY);
    }
});
window.addEventListener('mousedown', (e) => {
    distanceX = e.clientX - rocket.positionX;
    distanceY = window.innerHeight - e.clientY - rocket.positionY;
    if(rocket.status == 0){
        rocket.velocityX = distanceX / 100;
        rocket.velocityY = distanceY / 100;
        startRocket();
    }
    rocket.status = 1;
});
window.addEventListener("keydown", function(event) {
    if(infoboard.visible){
        hideInfoboard();
    }
    if(rocket.status == 4){
        restartGame();
    }
    if ((event.keyCode == 119|| event.keyCode == 87) && rocket.status != 0) {
        rocket.status = 2;
    }else if (event.keyCode == 32 && rocket.status != 0) {
        rocket.status = 3;
    }    
});
window.addEventListener("keyup", function(event) {
    if ((event.keyCode == 119|| event.keyCode == 87) && rocket.status == 2) {
        rocket.status = 1;
    }else if (event.keyCode == 32 && rocket.status == 3) {
        rocket.status = 1;
    }
});

function accountForGravity(velocityX, velocityY, positionX, positionY){
    let distanceX = 0;
    let distanceY = 0;
    let ratio;
    let gravitationalForce;
    if(gravitySources.length > 0){
        for (let i = 0; i < gravitySources.length; ++i) {
            distanceX = positionX - gravitySources[i][1];
            distanceY = positionY - gravitySources[i][2];
            gravitationalForce = 1000 * gravitySources[i][0] / ((distanceX * distanceX + distanceY * distanceY) / 2);
            ratio = gravitationalForce / Math.sqrt(Math.pow(distanceX, 2) + Math.pow(distanceY, 2));
            velocityX -= ratio * distanceX;
            velocityY -= ratio * distanceY;
            //console.log(distanceX);
        }
    }
    return [velocityX, velocityY, ratio * distanceX];
}

function detectColision(shipSize, positionX, positionY, spaceObjects, objectHitRadius){
    for(i = 0; i < spaceObjects.length; ++i){
        let distanceX = positionX - spaceObjects[i][1];
        let distanceY = positionY - spaceObjects[i][2];
        if(Math.sqrt(Math.pow(distanceX, 2) + Math.pow(distanceY, 2)) < shipSize + objectHitRadius[spaceObjects[i][3]]){
            return true;
        }
    }
    for(let i in wallList){
        if(wallList[i][0] < positionX && wallList[i][0] + wallList[i][2] > positionX && wallList[i][1] < positionY && wallList[i][1] + wallList[i][3] > positionY){
            console.log("booom")
            return true;
        }
    }
    // detect hitting sides
    let frame = 400;// how far behind the frame we can go
    if(positionX > window.innerWidth + frame || positionX < - frame || positionY > window.innerHeight + frame || positionY < - frame){
        return true
    }
    return false;
}
function detectWin(){
    distanceX = Math.abs(rocket.positionX - finish.positionX);
    distanceY = Math.abs(rocket.positionY - finish.positionY);
    if(distanceX < 5 && distanceY < 5 + finish.height){
        return true;
    }else{
        return false;
    }
}
function displayInfoboard(title, description){
    infoboard.id.style.display = "block";
    infoboard.title.innerHTML = title;
    infoboard.description.innerHTML = description;
    infoboard.visible = true;
    infoboard.id.classList.add("slideIn")
}
function hideInfoboard(){
    infoboard.id.style.display = "none";
    infoboard.visible = false;
}

function startRocket(){
let dotRepetition = 0;
    const shipRunningInterval = setInterval(function() {
        ++dotRepetition;
        if(rocket.status == 2){
            rocket.velocityX *= 1.02;
            rocket.velocityY *= 1.02;
        }
        if(rocket.status == 3){
            rocket.velocityX *= 0.98;
            rocket.velocityY *= 0.98;
        }

        rocket.positionX += rocket.velocityX;
        rocket.positionY += rocket.velocityY;
        moveRocket(rocket.positionX, rocket.positionY);
        forces = accountForGravity(rocket.velocityX, rocket.velocityY, rocket.positionX, rocket.positionY);
        rocket.velocityX = forces[0];
        rocket.velocityY = forces[1];
        if(detectColision(rocket.size, rocket.positionX, rocket.positionY, gravitySources, objectRadius)){
            clearInterval(shipRunningInterval);
            rocket.id.style.transform = "";
            rocket.id.src= "gameImages/explosion.gif";
            rocket.status = 4;
            displayInfoboard("You died", "press any key to continue");
        }else{
            rotateRocket(rocket.velocityX, rocket.velocityY);
        }
        if(detectWin()){
            rocket.status = 5;
            clearInterval(shipRunningInterval);
            displayInfoboard("You won", "press any key to continue");
        }
        if(dotRepetition > 10){
            dotContainer.innerHTML += "<div class=\"dot\"></div>";
            dotclass[dotclass.length -1].style.left = rocket.positionX + "px";
            dotclass[dotclass.length -1].style.bottom = rocket.positionY + "px";
            dotRepetition = 0;
        }
    }, 20);
}

function restartGame(){
    rocket.positionX = 70;
    rocket.positionY= window.innerHeight / 2;
    rocket.velocityX = 0;
    rocket.velocityY = 0;
    rocket.status = 0;
    moveRocket(rocket.positionX, rocket.positionY);
    dotContainer.innerHTML = "";
}
</script>
</html>