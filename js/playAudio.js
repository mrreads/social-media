let tracks = document.querySelectorAll(".track > .play");
let isPlayed = false;
let audioTemp;

let playedAudioId;

let previousAudioElem;

tracks.forEach((track) =>
{
    track.addEventListener('click', (e) =>
    {
        // кликнули по треку, который не играет
        if (track.dataset.active == 'false')
        {
            // включи кликнули по треку, который играл ДО этого
            if (playedAudioId == track.dataset.id)
            {
                audioTemp.play();
                changeTrackStatus(track.dataset.id, '');
            }
            else
            {
                // останавливаем музыку, если играет
                if (previousAudioElem)
                {
                    console.log('cerf')
                    audioTemp.pause();
                }

                fetch(`./../php/getAudio.php?id=${track.dataset.id}`)
                .then(response => response.json())
                .then(data => 
                {
                    audioTemp = new Audio("data:audio/wav;base64," + data);
                    audioTemp.play();
                });

                changeTrackStatus(track.dataset.id, playedAudioId);
                playedAudioId = track.dataset.id;
                previousAudioElem = track;
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