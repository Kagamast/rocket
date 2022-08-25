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
    --textcolor: rgb(255, 162, 48);
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
let hexChars = "23456789a"
let starChars = "9abcdef"
let dotContainer = document.getElementById("dotContainer");
let objectContainer = document.getElementById("source");
let dotclass = document.getElementsByClassName("dot");
let differenceX = 0;
let differenceY = 0;
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
        for($i = 0; $i < count($objects); $i++){
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
?>

let forces = [];
let randomColor = "#444";

moveRocket(rocket.positionX, rocket.positionY);
function degrees_to_radians(degrees){
  var pi = Math.PI;
  return degrees * (pi/180);
}
function moveRocket(positionX, positionY){
    rocket.id.style.left = positionX -50 + "px";
    rocket.id.style.bottom = positionY -50 + "px";
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
function rotateRocket(distanceX, distanceY){
    if(distanceX >= 0){
        angle = -Math.atan(distanceY / distanceX);
    }else{
        angle = Math.atan(distanceY / -distanceX) + degrees_to_radians(180);
    }
    rocket.id.style.transform = "rotate(" + angle + "rad)";
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


window.addEventListener('mousemove', (e) => {
    if(rocket.status == 0){
        differenceX = e.clientX - rocket.positionX;
        differenceY = window.innerHeight - e.clientY - rocket.positionY;
        rotateRocket(differenceX, differenceY);
    }
});
window.addEventListener('mousedown', (e) => {
    differenceX = e.clientX - rocket.positionX;
    differenceY = window.innerHeight - e.clientY - rocket.positionY;
    if(rocket.status == 0){
        rocket.velocityX = differenceX / 100;
        rocket.velocityY = differenceY / 100;
        startRocket();
    }
    rocket.status = 1;
});
window.addEventListener("keydown", function(event) {
    if(infoboard.visible){
        hideInfoboard();
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
    return false;
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
            displayInfoboard("You died", "press any key to continue")
        }else{
            rotateRocket(rocket.velocityX, rocket.velocityY);
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