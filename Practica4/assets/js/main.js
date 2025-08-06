
function searchWord() {
    const word = document.getElementById('searchInput').value.trim();
    if (word) {
        const encodedWord = encodeURIComponent(word);
        window.location.href = `search?search=${encodedWord}`;
    } else {
        alert('Ingrese una palabra');
    }
}