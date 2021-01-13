const buttonsPlayer = document.getElementsByClassName('player');

for (let i=0; i<buttonsPlayer.length; i++) {
    buttonsPlayer[i].addEventListener('click', (event) => {
        resetButtonsPlayer();
        buttonsPlayer[i].classList.add('active');
    })
}

function resetButtonsPlayer(){
    for (let i=0; i<buttonsPlayer.length; i++) {
        buttonsPlayer[i].classList.remove('active');
        }
}


const buttonsAvatar = document.getElementsByClassName('avatar');

for (let i=0; i<buttonsAvatar.length; i++) {
    buttonsAvatar[i].addEventListener('click', (event) => {
        resetButtonsAvatar();
        buttonsAvatar[i].classList.add('active');
    })
}

function resetButtonsAvatar(){
    for (let i=0; i<buttonsAvatar.length; i++) {
        buttonsAvatar[i].classList.remove('active');
    }
}