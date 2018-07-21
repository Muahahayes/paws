$().ready(callJson);
let displayJson = [];
let jsonPets = [];
let key = "";
function callJson(){
    $.getJSON('paws.json', function(json){ //https://raw.githubusercontent.com/Muahahayes/paws/master/paws.json
        buildPage(json);
    });
}

function buildPage(json){
    let species = $('body').attr('id');
    if(species == 'dog'){
        jsonPets = _.map(json.dogs);
        displayJson = _.map(json.dogs);
    }
    if(species == 'cat'){        
        jsonPets = _.map(json.cats);
        displayJson = _.map(json.cats);
    }
    if(species == 'exotic'){
        jsonPets = _.map(json.exotics);
        displayJson = _.map(json.exotics);
    }
    buildTable();
    $('th').on('click',sortRows);
    $('th').addClass('sort');
}

function buildTable(){
    let species = $('body').attr('id');
    if(species == 'dog'){
        buildDog();
    }
    if(species == 'cat'){
        buildCat();
    }
    if(species == 'exotic'){
        buildExotic();
    }
    $('.modal-btn').on('click', modalToggle);
    
}

function buildDog(){
    let dogHead = '<thead class="thead-dark"><tr><th id="name">Name</th><th id="breed">Breed</th><th id="sex">Sex</th><th id="shots" class="bools">Shots</th><th id="age" class="numbers">Age</th><th id="size" class="numbers">Size</th><th id="licensed" class="bools">Licensed</th><th id="neutered" class="bools">Neutered</th><th id="owners" class="bools">Owners</th><th id="notes" class="bools">Notes</th></tr></thead><tbody>';
    let dogTable = '';
    let dogModals = '';
    let i = 1;
    for(let dog of displayJson){
        let dogDate = new Date(dog.birthday);
        dog.age = Math.floor(((Date.now() - dogDate) / 86400000) / 365.25);

        dogTable += `<tr class="tdRow"><td>${dog.name}</td>
        <td>${dog.breed}</td>
        <td>${dog.sex}</td>
        <td>${(dog.shots)?'Yes':'No'}</td>
        <td>${dog.age}</td>`;

        if(dog.size < 20){
            dogTable += `<td>S</td>`;
        }
        else if(dog.size < 50){
            dogTable += `<td>M</td>`;
        }
        else if(dog.size < 100){
            dogTable += `<td>L</td>`;
        }
        else{
            dogTable += `<td>G</td>`;
        }

        dogTable += `<td>${(dog.licensed)?'Yes':'No'}</td><td>${(dog.neutered)?'Yes':'No'}</td>`;

        if(dog.owners){
            dogTable +=`<td><button type="button" class="btn btn-primary modal-btn" id="own${i}">Owners</button></td>`;
            // `<td><button id="own${i}" class="button is-info modal-btn">Owners</button></td>`
        }
        else{
            dogTable += `<td>None</td>`;
        }

        if(dog.notes){
            dogTable +=`<td><button type="button" class="btn btn-primary modal-btn" id="note${i}">Notes</button></td></tr>`;
            // `<td><button id="note${i}" class="button is-info modal-btn">Notes</button></td></tr>`;
        }
        else{
            dogTable += `<td>None</td></tr>`;
        }

        // Modals for any category that requires one, to be put in Modals div
        if(dog.owners){
            dogModals += `<div class="modal fade" id="own${i}Modal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Owners List</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>${dog.owners}</p>
                        </div>
                    </div>
                </div>
            </div>`;
        }
        if(dog.notes){
            dogModals += `<div class="modal fade" id="note${i}Modal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Notes</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>${dog.notes}</p>
                        </div>
                    </div>
                </div>
            </div>`;
        }
        i++;
    }
    dogTable += `</tbody>`;
    dogTable = dogHead + dogTable;
    $('#table').html(dogTable);
    $('.modals').html(dogModals);
}

function buildCat(){
    let catHead = '<thead class="thead-dark"><tr><th id="name">Name</th><th id="breed">Breed</th><th id="sex">Sex</th><th id="shots" class="bools">Shots</th><th id="age" class="numbers">Age</th><th id="declawed" class="bools">Declawed</th><th id="neutered" class="bools">Neutered</th><th id="owners" class="bools">Owners</th><th id="notes" class="bools">Notes</th></tr></thead><tbody>';
    let catTable = '';
    let catModals = '';
    let i = 1;

    for(let cat of displayJson){
        let catDate = new Date(cat.birthday);
        cat.age = Math.floor(((Date.now() - catDate) / 86400000) / 365.25);
    
        catTable += `<tr class="tdRow"><td>${cat.name}</td>
        <td>${cat.breed}</td>
        <td>${cat.sex}</td>
        <td>${(cat.shots)?'Yes':'No'}</td>
        <td>${cat.age}</td>
        <td>${(cat.declawed)?'Yes':'No'}</td>
        <td>${(cat.neutered)?'Yes':'No'}</td>`;

        if(cat.owners){
            catTable += `<td><button type="button" class="btn btn-primary modal-btn" id="own${i}">Owners</button></td>`;
        }
        else{
            catTable += `<td>None</td>`;
        }
        if(cat.notes){
            catTable += `<td><button type="button" class="btn btn-primary modal-btn" id="note${i}">Notes</button></td></tr>`;
        }
        else{
            catTable += `<td>None</td></tr>`;
        }

        if(cat.owners){
            catModals += `<div class="modal fade" id="own${i}Modal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Owners List</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>${cat.owners}</p>
                        </div>
                    </div>
                </div>
            </div>`;
        }
        if(cat.notes){
            catModals += `<div class="modal fade" id="note${i}Modal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Notes</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>${cat.notes}</p>
                        </div>
                    </div>
                </div>
            </div>`;
        }
        i++;
    }
    catTable += `</tbody>`;
    catTable = catHead + catTable;
    $('#table').html(catTable);
    $('.modals').html(catModals);
}

function buildExotic(){
    let exoticHead = '<thead class="thead-dark"><tr><th id="name">Name</th><th id="species">Species</th><th id="sex">Sex</th><th id="age" class="numbers">Age</th><th id="owners" class="bools">Owners</th><th id="notes" class="bools">Notes</th></tr></thead><tbody>';
    let exoticTable = '';
    let exoticModals = '';
    let i = 1;
    for(let exotic of displayJson){
        let exoDate = new Date(exotic.birthday);
        exotic.age = Math.floor(((Date.now() - exoDate) / 86400000) / 365.25);

        exoticTable += `<tr class="tdRow"><td>${exotic.name}</td>
        <td>${exotic.species}</td>
        <td>${exotic.sex}</td>
        <td>${exotic.age}</td>`;

        if(exotic.owners){
            exoticTable += `<td><button type="button" class="btn btn-primary modal-btn" id="own${i}">Owners</button></td>`;
        }
        else{
            exoticTable += `<td>None</td>`;
        }
        if(exotic.notes){
            exoticTable += `<td><button type="button" class="btn btn-primary modal-btn" id="note${i}">Notes</button></td></tr>`;
        }
        else{
            exoticTable += `<td>None</td></tr>`;
        }

        if(exotic.owners){
            exoticModals += `<div class="modal fade" id="own${i}Modal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Owners List</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>${exotic.owners}</p>
                        </div>
                    </div>
                </div>
            </div>`;
        }
        if(exotic.notes){
            exoticModals += `<div class="modal fade" id="note${i}Modal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Notes</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>${exotic.notes}</p>
                        </div>
                    </div>
                </div>
            </div>`;
        }
        i++;
    }
    exoticTable += `</tbody>`;
    exoticTable = exoticHead + exoticTable;
    $('#table').html(exoticTable);
    $('.modals').html(exoticModals);
}

function modalToggle(){
    let buttonID = $(this).attr('id');
    let modalID = `#${buttonID}Modal`;
    $(modalID).modal('toggle');
}

// function modalToggle(){
//     let buttonID = $(this).attr('id');
//     let modal = $(`#${buttonID}Modal`)[0];
//     modal.style.display = 'block';
//     $(`#${buttonID}Modal .close`).on('click', function(){
//         modal.style.display = 'none';
//     });
//     window.onclick = function(event) {
//         if (event.target == modal) {
//             modal.style.display = 'none';
//         }
//     }
// }

function sortStrings(a,b){
    a = a[key].toLowerCase();
    b = b[key].toLowerCase();
    return (a < b) ? -1 : 1;
}

function sortNumbers(a,b){
    a = a[key];
    b = b[key];
    return a - b;
}

function sortBools(a,b){
    a = a[key];
    b = b[key];
    if(a){return -1}
    if(b){return 1}
    return 0;
}

function reverseStrings(a,b){
    a = a[key].toLowerCase();
    b = b[key].toLowerCase();
    return (a > b) ? -1 : 1;
}

function reverseNumbers(a,b){
    a = a[key];
    b = b[key];
    return b - a;
}

function reverseBools(a,b){
    a = a[key];
    b = b[key];
    if(a){return 1}
    if(b){return -1}
    return 0;
}

function sortRows(){
    key = $(this).attr('id');
    if($(this).attr('class').includes('numbers')){
        displayJson.sort(sortNumbers);
    }
    else if($(this).attr('class').includes('bools')){
        displayJson.sort(sortBools);
    }
    else{
        displayJson.sort(sortStrings);
    }
    buildTable();
    $('th').addClass('sort');
    $('#'+key).removeClass('sort');
    $('.sort').on('click',sortRows);
    $('#'+key).on('click',reverseRows);

}

function reverseRows(){
    if($('#'+key).attr('class').includes('numbers')){
        displayJson.sort(reverseNumbers);
    }
    else if($('#'+key).attr('class').includes('bools')){
        displayJson.sort(reverseBools);
    }
    else{
        displayJson.sort(reverseStrings);
    }
    buildTable();
    $('th').addClass('sort');
    $('th').on('click',sortRows);
}
