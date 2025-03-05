// *********************************
// ***********SEARCH***********
// ********************************* 

let searchForm = document.getElementById('search-form');
let searchInput = document.getElementById('search');
const responseDiv = document.getElementById('search-results');

searchInput.addEventListener('input', function(){

    if(searchInput.value.length <= 3){
        responseDiv.innerHTML = "";

    }
    let formData = new FormData(searchForm);

    fetch('/search', {
        method:"POST",
        body: formData,
    })

    .then((datas) => datas.json())
    .then((datas) => {
        responseDiv.innerHTML = "";
        const ulResults = document.createElement('ul');
        datas.forEach(data => {

            console.log(data);
            //DOM BUILDING
            let li = document.createElement('li');
            let a = document.createElement('a');
            let a2 = document.createElement('a');
            
            //DATAS DISPLAYED IN DOM ELEMENTS
           
            a.textContent = data.name;
            a2.textContent = data.author_name;

            //SET ATTRIBUTES
            a.setAttribute('href', `/manga/${data.id_manga}`);
            a2.setAttribute('href', `/author/${data.id_author}`);

            //APPEND ELEMENTS TO PARENT ELEMENTS
            li.appendChild(a);
            li.appendChild(a2);
            ulResults.appendChild(li);
        })

        responseDiv.appendChild(ulResults);
    })

});