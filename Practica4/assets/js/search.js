let webParams = new URLSearchParams(document.location.search);
let search = webParams.get("search");
getWord(search);

console.log(search);
async function getWord(params) {
    const response = await fetch(`https://api.dictionaryapi.dev/api/v2/entries/en/${params}`);
    const result = await response.json();

    console.log(result[0]);
    console.log(result[0].word)
}