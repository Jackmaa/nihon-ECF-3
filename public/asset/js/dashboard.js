function openPopup(popupId) {
    document.getElementById('overlay').style.display = 'block';
    document.getElementById(popupId).style.display = 'block';
}

function closePopup(popupId) {
    document.getElementById('overlay').style.display = 'none';
    document.getElementById(popupId).style.display = 'none';
}