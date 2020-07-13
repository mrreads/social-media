import 'https://unpkg.com/emoji-picker-element';
        
let emojiPicker = document.querySelector('emoji-picker');
let postArea = document.querySelector('#post-content');
let emojiButton = document.querySelector('.emoji');

emojiButton.addEventListener('click', e =>
{
    emojiPicker.classList.toggle('hide');
});

emojiPicker.addEventListener('emoji-click', event => 
{   
    postArea.value += event.detail.unicode;
});

document.addEventListener('click', e => 
{
    if (e.target.tagName != 'EMOJI-PICKER' && !e.target.classList.contains('emoji'))
    {
        emojiPicker.classList.add('hide');
    }
})