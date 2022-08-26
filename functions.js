
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
  function generateNumber(key){
      let content = "<path d=\"";
      content += key[0] == "y" ? "M 1 1 L 2 0 L 6 0 L 7 1 L 6 2 L 2 2 Z " : "";
      content += key[1] == "y" ? "M 7 1 L 8 2 L 8 6 L 7 7 L 6 6 L 6 2 Z " : "";
      content += key[2] == "y" ? "M 7 7 L 8 8 L 8 12 L 7 13 L 6 12 L 6 8 L 7 7 " : "";
      content += key[3] == "y" ? "M 7 13 L 6 14 L 2 14 L 1 13 L 2 12 L 6 12 Z " : "";
      content += key[4] == "y" ? "M 1 13 L 0 12 L 0 8 L 1 7 L 2 8 L 2 12 Z " : "";
      content += key[5] == "y" ? "M 1 7 L 0 6 L 0 2 L 1 1 L 2 2 L 2 6 Z " : "";
      content += key[6] == "y" ? "M 7 7 L 6 8 L 2 8 L 1 7 L 2 6 L 6 6 Z" : "";
      content += "\" fill=\"var(--counter-color)\"/>";
      return content
  }
  function win(minutesSpent, secondsSpent){
      alignNumbers(minutesSpent, secondsSpent);
      document.getElementById("winscreen").style.display = "block"
  }
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
function alignNumbers(targetMinutes, targetSeconds){
    try{
        clearInterval(aligningNumbers);
    }catch{}
    let digit = [
        parseInt(targetMinutes / 10),
        parseInt(targetMinutes % 10),
        parseInt(targetSeconds / 10),
        parseInt(targetSeconds % 10),
    ];
    let seconds = 0;
    let minutes = 0;
    const aligningNumbers = setInterval(function(){
        if(seconds > 59){
            seconds = 0;
            ++minutes;
        }
        sevenDigit[0].innerHTML = generateNumber(sevenSegment[parseInt(minutes / 10)]);
        sevenDigit[1].innerHTML = generateNumber(sevenSegment[parseInt(minutes % 10)]);
        sevenDigit[2].innerHTML = generateNumber(sevenSegment[parseInt(seconds / 10)]);
        sevenDigit[3].innerHTML = generateNumber(sevenSegment[parseInt(seconds % 10)]);
        ++seconds;
        if(minutes > 59){
            sevenDigit[0].innerHTML = generateNumber("nnnyyyn");
            sevenDigit[1].innerHTML = generateNumber("yyyyyyn");
            sevenDigit[2].innerHTML = generateNumber("yyynyyn");
            sevenDigit[3].innerHTML = generateNumber("ynyyyyn");
            clearInterval(aligningNumbers);
        }
        if(minutes == targetMinutes && seconds == targetSeconds){
            clearInterval(aligningNumbers);
        }
    }, 4)
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
            win(time.minutes, time.seconds)
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
function moveTime(){
    if(time.seconds < 58){
        ++time.seconds;
    }else{
        time.seconds = 0;
        ++time.minutes;
    }
}