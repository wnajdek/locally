document.querySelectorAll('.tile-button').forEach(btn => btn.addEventListener('click', function() {
    const id = this.parentElement.getAttribute('id');
    window.location.href = 'market/' + id;
}));