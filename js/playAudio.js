let tracks = document.querySelectorAll(".track");

for (let i = 0; i < tracks.length; i++)
{
    var isPlayed = false;
    tracks[i].querySelector(".play").addEventListener("click", function()
    {
        if (isPlayed === true)
        {   
            allAudioStop();
            isPlayed = false;
            tracks[i].querySelector("audio").pause();
            tracks[i].querySelector(".play").style.backgroundImage = 'url("./img/icons/play.svg")';
            tracks[i].querySelector(".play").style.opacity = "0.7";
            tracks[i].querySelector("p").style.color = "rgba(0, 0, 0, 0.7)";
        }
        else
        {
            allAudioStop();
            isPlayed = true;
            tracks[i].querySelector("audio").play();
            tracks[i].querySelector(".play").style.backgroundImage = 'url("./img/icons/pause.svg")';
            tracks[i].querySelector(".play").style.opacity = "1";
            tracks[i].querySelector("p").style.color = "rgba(0, 0, 0, 1)";
        }
    });
}

function allAudioStop()
{
    let items = document.querySelectorAll(".track");
    for (let i = 0; i < items.length; i++)
    {
        items[i].querySelector("audio").pause();
        items[i].querySelector(".play").style.backgroundImage = 'url("./img/icons/play.svg")';
        tracks[i].querySelector(".play").style.opacity = "0.7";
        tracks[i].querySelector("p").style.color = "rgba(0, 0, 0, 0.7)";
    }
}

let listHR;
listHR = document.querySelectorAll(".audio-list hr");
listHR[listHR.length-1].remove();
listHR = document.querySelectorAll(".your-list hr");
listHR[listHR.length-1].remove();