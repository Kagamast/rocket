<!DOCTYPE html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0" />
    <title>kagamast</title>
    <link rel="icon" type="image/x-icon" href="favicon.png">
    <link rel="stylesheet" href="levelStyle.css">
</head>
<style>
.winMenu{
    grid-template-columns: 1fr 1fr;
}
</style>



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
<div id="winscreen">
    <img src="gameImages/youwon.svg" class="winTitle"></img>
    <div class="displayTime">
        <svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 14" class="sevenDigit displayDigit"></svg>
        <svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 14"class="sevenDigit displayDigit"></svg>
        <svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2 14" class="colon displayDigit">
            <path d="M 0 4 L 1 3 L 2 4 L 1 5 Z M 1 9 L 2 10 L 1 11 L 0 10 L 1 9 Z" fill="var(--counter-color)"/>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 14" class="sevenDigit displayDigit"></svg>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 14"class="sevenDigit displayDigit"></svg>
    </div>
    <div class="winMenu">
        <button onclick="window.open('index.html', '_self')" class="material-symbols-outlined">menu</button>
        <button onclick="restartGame(); document.getElementById('winscreen').style.display = 'none'; rocket.status = 0; time.minutes = 0; time.seconds = 0;" class="material-symbols-outlined">replay</button>
    </div>
</body>




<script src="functions.js"></script>
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
let sevenDigit = document.getElementsByClassName("sevenDigit");
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
let time = {
    minutes: 0,
    seconds: 0,
}
let sevenSegment = [
    "yyyyyyn", //0
    "nyynnnn", //1
    "yynyyny", //2
    "yyyynny", //3
    "nyynnyy", //4
    "ynyynyy", //5
    "ynyyyyy", //6
    "yyynnnn", //7
    "yyyyyyy", //8
    "yyyynyy", //9
]
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

setInterval(moveTime, 1000);
</script>
</html>