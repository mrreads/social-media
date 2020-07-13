class AudioControlPanel
{
    constructor() 
    {
        this.audioControlInfo = document.querySelector('.infoTrack');
        this.audioControlPrevious = document.querySelector('.previousTrack');
        this.audioControlPause = document.querySelector('.pauseTrack');
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

        this.audioControlPrevious.addEventListener('click', () => 
        {
            if (currentAudioElem.previousElementSibling)
            {
                audioPlay(currentAudioElem.previousElementSibling.querySelector('.play'), currentAudioElem.previousElementSibling);
            }
            
        });

        this.audioControlPause.addEventListener('click', () => 
        {
            if (audioTemp.paused)
            {
                changeTrackStatus(playedAudioId);
                audioTemp.play();
            }
            else
            {
                changeTrackStatus('', playedAudioId)
                audioTemp.pause();
            }
            this.pauseUnpause();
        });

        this.audioControlNext.addEventListener('click', () => 
        {
            if (currentAudioElem.nextElementSibling)
            {
                audioPlay(currentAudioElem.nextElementSibling.querySelector('.play'), currentAudioElem.nextElementSibling);
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

    pauseUnpause()
    {
        if (audioTemp.paused)
        {
            this.audioControlPause.classList.remove('pause');
        }
        else
        {
            this.audioControlPause.classList.add('pause');
        }
    }

    changeVolume(val)
    {
        this.audioControlVolume.disabled = false;
        this.audioControlVolume.value = +val;
        audioTemp.volume = +val * 0.01;
    }

    updateTrack(elem)
    {    
        this.audioControlPause.classList.remove('disable');
        
        this.audioControlInfo.title = elem.querySelector('.track-name').textContent;
        this.audioControlInfo.textContent = elem.querySelector('.track-name').textContent;
        this.audioControlLenght.max = +audioTemp.duration;
        this.audioControlLenght.disabled = false;

        if (currentAudioElem.previousElementSibling && !currentAudioElem.previousElementSibling.classList.contains('track'))
        {   
            this.audioControlPrevious.classList.add('disable')
        }
        else
        {
            if (currentAudioElem.previousElementSibling)
            {
                this.audioControlPrevious.classList.remove('disable');
            }
            else
            {
                this.audioControlPrevious.classList.add('disable')
            }
            
        }

        if (currentAudioElem.nextElementSibling && !currentAudioElem.nextElementSibling.classList.contains('track'))
        {
            this.audioControlNext.classList.add('disable')
        }
        else
        {
            if (currentAudioElem.nextElementSibling)
            {
                this.audioControlNext.classList.remove('disable');
            }
            else
            {
                this.audioControlNext.classList.add('disable')
            }
        }

        if (this.audioControlInfo.textContent.length > 40 || this.audioControlInfo.scrollWidth > this.audioControlInfo.offsetWidth)
        {
            this.audioControlInfo.classList.add('more');
        }
        else
        {
            this.audioControlInfo.classList.remove('more');
        }
    }
}

let globalVolume = 100;
let audioControll = new AudioControlPanel();

let tracks = document.querySelectorAll(".track");
let isPlayed = false;
let audioTemp;

let playedAudioId;

let currentAudioElem;
let previousAudioElem;

function audioPlay(track, trackElem)
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
            audioTemp = new Audio(`./../upload/audio/${track.dataset.file}`);
            audioTemp.addEventListener('loadeddata', () =>
            {
                audioTemp.play();
        
                changeTrackStatus(track.dataset.id, playedAudioId);

                playedAudioId = track.dataset.id;
                previousAudioElem = track;
                currentAudioElem = trackElem;
                audioControll.changeVolume(+globalVolume);
                audioControll.updateTrack(trackElem);
            })
        }
    }
    else 
    {
        // кликнули по треку, который играет
        audioTemp.pause();
        changeTrackStatus('', track.dataset.id);
    }
}


tracks.forEach((trackElem) =>
{
    let track = trackElem.querySelector('.play');
    track.addEventListener('click', (e) =>
    {
        audioPlay(track, trackElem)
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

    audioControll.pauseUnpause();
}