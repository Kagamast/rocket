let gameName = "name in progress";
let maxLevel = 2;
document.title = gameName + "-level " + level;
document.getElementById("levelNumber").innerHTML = "<span class=\"material-symbols-outlined\">military_tech</span>" + parseInt(level / 100) + parseInt((level % 100) / 10) + parseInt(level % 10);
if(level >= maxLevel){
    document.getElementById("nextLevel").setAttribute('onclick','');
    document.getElementById("nextLevel").style.color = "grey";
    document.getElementById("nextLevel").style.border = "10px solid grey";
    document.getElementById("nextLevel").classList.add("disabledButton");
}