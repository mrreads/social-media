class AudioControlPanel
{
    constructor() 
    {
        this.audioControlInfo = document.querySelector('.infoTrack');
        this.audioControlPrevious = document.querySelector('.previousTrack');
        this.audioControlNext = document.querySelector('.nextTrack');
        this.audioControlVolume = document.querySelector('.rangeVolume');
        this.audioControlLenght = document.querySelector('.trackLenght');
        this.audioCurrentTime = document.querySelector('.trackCurrent');

        this.audioControlVolume.addEventListener('change', () =>
        {
            if (audioTemp)
            {
                audioTemp.volume = +this.audioControlVolume.value * 0.01;
                globalVolume = +this.audioControlVolume.value;
            }
        });

        this.audioControlLenght.addEventListener('change', () =>
        {
            if (audioTemp)
            {
                audioTemp.currentTime = +this.audioControlLenght.value;
            }
        });

        setInterval(() => {
            if (audioTemp)
            {
                this.minutes = Math.floor(audioTemp.currentTime / 60)
                this.second = Math.floor(audioTemp.currentTime % 60)

                this.second = (this.second < 10) ? `0${this.second}` : this.second;

                this.audioCurrentTime.textContent = `${this.minutes} : ${this.second}`;

                this.audioControlLenght.value = +audioTemp.currentTime;
            }
        }, 1000)
    }

    changeVolume(val)
    {
        this.audioControlVolume.disabled = false;
        this.audioControlVolume.value = +val;
        audioTemp.volume = +val * 0.01;
    }

    updateTrack(elem)
    {
        this.audioControlInfo.textContent = elem.querySelector('.track-name').textContent;
        this.audioControlLenght.max = +audioTemp.duration;
        this.audioControlLenght.disabled = false;
    }
}

let globalVolume = 100;
let audioControll = new AudioControlPanel();

let tracks = document.querySelectorAll(".track");
let isPlayed = false;
let audioTemp;

let playedAudioId;

let previousAudioElem;

tracks.forEach((trackElem) =>
{
    let track = trackElem.querySelector('.play');
    track.addEventListener('click', (e) =>
    {
        // кликнули по треку, который не играет
        if (track.dataset.active == 'false')
        {
            // включи кликнули по треку, который играл ДО этого
            if (playedAudioId == track.dataset.id)
            {
                audioTemp.play();
                audioControll.changeVolume(+globalVolume);
                changeTrackStatus(track.dataset.id, '');
            }
            else
            {
                // останавливаем музыку, если играет
                if (previousAudioElem)
                {
                    audioTemp.pause();
                }

                fetch(`./../php/getAudio.php?id=${track.dataset.id}`)
                .then(response => response.json())
                .then(data => 
                {
                    
                    audioTemp = new Audio("data:audio/wav;base64," + data);
                    audioTemp.addEventListener('loadeddata', () =>
                    {
                        audioTemp.play();
                
                        changeTrackStatus(track.dataset.id, playedAudioId);
    
                        playedAudioId = track.dataset.id;
                        previousAudioElem = track;
                        
                        audioControll.changeVolume(+globalVolume);
                        audioControll.updateTrack(trackElem);
                    })
  
                });
            }
        }
        else 
        {
            // кликнули по треку, который играет
            audioTemp.pause();
            changeTrackStatus('', track.dataset.id);
        }
    })
});

function changeTrackStatus(id, previous)
{   
    if (id)
    {
        newTracks = document.querySelectorAll(`.track > .play[data-id='${id}']`);
        newTracks.forEach(t => 
        {
            t.dataset.active = 'true';
            t.classList.add('pause');
        });
    }


    previousTracks = document.querySelectorAll(`.track > .play[data-id='${previous}']`);
    if (previousTracks)
    {
        previousTracks.forEach(t => 
        {
            t.dataset.active = 'false';
            t.classList.remove('pause');
        });
    }
}

let listHR;
listHR = document.querySelectorAll(".audio-list hr");
listHR[listHR.length-1].remove();
listHR = document.querySelectorAll(".your-list hr");
listHR[listHR.length-1].remove();