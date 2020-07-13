import 'https://unpkg.com/emoji-picker-element';
        
let emojiPicker = document.querySelector('emoji-picker');
let textArea = document.querySelector('#text-content');
let emojiButton = document.querySelector('.emoji');

emojiButton.addEventListener('click', e =>
{
    emojiPicker.classList.toggle('hide');
});

emojiPicker.addEventListener('emoji-click', event => 
{   
    console.log(event.detail);
    textArea.value += event.detail.emoji.unicode;
});

document.addEventListener('click', e => 
{
    if (e.target.tagName != 'EMOJI-PICKER' && !e.target.classList.contains('emoji'))
    {
        emojiPicker.classList.add('hide');
    }
})