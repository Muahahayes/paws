$().ready(callJson);
let displayJson = [];
let jsonPets = [];
let key = '';
let filter = '';
function callJson(){ 
    let species = $('body').attr('id');
    if(species){
        let page = $('.pages').attr('id');
        if(!page){page = 1}
        $.getJSON(`json.php?s=${species}&p=${page}`, function(json){
            buildPage(json);
        });
    }
}

function buildPage(json){
    let species = $('body').attr('id');
    if(!json[10]){ // check if there's not an 11th result, hide forward arrow
        $('#forward').hide();}
    else{ // pop the 11th, so we only display 10
        json.pop();
    }
    if(species == 'dog'){
        jsonPets = _.map(json);
        displayJson = _.map(json);
    }
    if(species == 'cat'){        
        jsonPets = _.map(json);
        displayJson = _.map(json);
    }
    if(species == 'exotic'){
        jsonPets = _.map(json);
        displayJson = _.map(json);
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
    $('.form-control').on('blur', filterTable);
}

function buildDog(){
    let dogHead = `
    <thead>
        <tr>
            <th><div class="col-xs-2 input-sm"><input class="form-control" type="text" placeholder="name"></div></th>
            <th><div class="col-xs-2 input-sm"><input class="form-control" type="text" placeholder="breed"></div></th>
            <th><div class="col-xs-2 input-sm"><input class="form-control" type="text" placeholder="sex"></div></th>
        </tr>
    </thead>
    <thead class="thead-dark">
        <tr>
            <th id="name">Name</th>
            <th id="breed">Breed</th>
            <th id="sex">Sex</th>
            <th id="shots" class="numbers">Shots</th>
            <th id="age" class="numbers">Age</th>
            <th id="weight" class="numbers">Size</th>
            <th id="licensed" class="numbers">Licensed</th>
            <th id="neutered" class="numbers">Neutered</th>
            <th id="owners" class="bools">Owners</th>
            <th id="notes" class="bools">Notes</th>
        </tr>
    </thead><tbody>`;
    let dogTable = '';
    let dogModals = '';
    let i = 1;

    for(let dog of displayJson){
        let dogDate = new Date(dog.birthdate);
        dog.age = Math.floor(((Date.now() - dogDate) / 86400000) / 365.25);

        dogTable += `<tr class="tdRow"><td>${dog.name}</td>
        <td>${dog.breed}</td>
        <td>${dog.sex}</td>
        <td>${(dog.shots == 1)?'Yes':'No'}</td>
        <td>${dog.age}</td>`;

        if(dog.weight < 20){
            dogTable += `<td>S</td>`;
        }
        else if(dog.weight < 50){
            dogTable += `<td>M</td>`;
        }
        else if(dog.weight < 100){
            dogTable += `<td>L</td>`;
        }
        else{
            dogTable += `<td>G</td>`;
        }

        dogTable += `<td>${(dog.licensed == 1)?'Yes':'No'}</td><td>${(dog.neutered == 1)?'Yes':'No'}</td>`;

        if(dog.owners[0]){
            dogTable +=`<td><button type="button" class="btn btn-primary modal-btn" id="own${i}">Owners</button></td>`;
        }
        else{
            dogTable += `<td>None</td>`;
        }

        if(dog.notes[0]){
            dogTable +=`<td><button type="button" class="btn btn-primary modal-btn" id="note${i}">Notes</button></td></tr>`;
        }
        else{
            dogTable += `<td>None</td></tr>`;
        }

        // Modals for any category that requires one, to be put in Modals div
        if(dog.owners[0]){
            let dogOwners = '';
            for(let owner of dog.owners){
                dogOwners += `<p>${owner.fname} ${owner.lname}</p>`;
            }
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
                            ${dogOwners}
                        </div>
                    </div>
                </div>
            </div>`;
        }
        if(dog.notes[0]){
            let dogNotes = '';
            for(let note of dog.notes){
                dogNotes += `<p>${note.vetName} (${note.date})<br>
                            ${note.note}</p>`;
            }
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
                            <p>${dogNotes}</p>
                        </div>
                    </div>
                </div>
            </div>`;
        }
        i++;
    }
    dogTable += `</tbody>`;
    dogTable = dogHead + dogTable;
    $('table').html(dogTable);
    $('.modals').html(dogModals);
}

function buildCat(){
    let catHead = `
    <thead>
        <tr>
            <th><div class="col-xs-2 input-sm"><input class="form-control" type="text" placeholder="name"></div></th>
            <th><div class="col-xs-2 input-sm"><input class="form-control" type="text" placeholder="breed"></div></th>
            <th><div class="col-xs-2 input-sm"><input class="form-control" type="text" placeholder="sex"></div></th>
        </tr>
    </thead>
    <thead class="thead-dark">
        <tr>
            <th id="name">Name</th>
            <th id="breed">Breed</th>
            <th id="sex">Sex</th>
            <th id="shots" class="numbers">Shots</th>
            <th id="age" class="numbers">Age</th>
            <th id="declawed" class="numbers">Declawed</th>
            <th id="neutered" class="numbers">Neutered</th>
            <th id="owners" class="bools">Owners</th>
            <th id="notes" class="bools">Notes</th>
        </tr>
    </thead><tbody>`;
    let catTable = '';
    let catModals = '';
    let i = 1;

    for(let cat of displayJson){
        let catDate = new Date(cat.birthdate);
        cat.age = Math.floor(((Date.now() - catDate) / 86400000) / 365.25);
    
        catTable += `<tr class="tdRow"><td>${cat.name}</td>
        <td>${cat.breed}</td>
        <td>${cat.sex}</td>
        <td>${(cat.shots == 1)?'Yes':'No'}</td>
        <td>${cat.age}</td>
        <td>${(cat.declawed == 1)?'Yes':'No'}</td>
        <td>${(cat.neutered == 1)?'Yes':'No'}</td>`;

        if(cat.owners[0]){
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

        if(cat.owners[0]){
            let catOwners = '';
            for(let owner of cat.owners){
                catOwners += `<p>${owner.fname} ${owner.lname}</p>`;
            }
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
                            ${catOwners}
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
    let exoticHead = `
    <thead>
        <tr>
            <th><div class="col-xs-2 input-sm"><input class="form-control" type="text" placeholder="name"></div></th>
            <th><div class="col-xs-2 input-sm"><input class="form-control" type="text" placeholder="species"></div></th>
            <th><div class="col-xs-2 input-sm"><input class="form-control" type="text" placeholder="sex"></div></th>
        </tr>
    </thead>
    <thead class="thead-dark">
        <tr>
            <th id="name">Name</th>
            <th id="species">Species</th>
            <th id="sex">Sex</th>
            <th id="age" class="numbers">Age</th>
            <th id="neutered" class="numbers">Neutered</th>
            <th id="owners" class="bools">Owners</th>
            <th id="notes" class="bools">Notes</th>
        </tr>
    </thead><tbody>`;
    let exoticTable = '';
    let exoticModals = '';
    let i = 1;
    for(let exotic of displayJson){
        let exoDate = new Date(exotic.birthdate);
        exotic.age = Math.floor(((Date.now() - exoDate) / 86400000) / 365.25);

        exoticTable += `<tr class="tdRow"><td>${exotic.name}</td>
        <td>${exotic.species}</td>
        <td>${exotic.sex}</td>
        <td>${exotic.age}</td>
        <td>${(exotic.neutered == 1)?'Yes':'No'}</td>`;

        if(exotic.owners[0]){
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

        if(exotic.owners[0]){
            let exoticOwners = '';
            for(let owner of exotic.owners){
                exoticOwners += `<p>${owner.fname} ${owner.lname}</p>`;
            }
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
                            ${exoticOwners}
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
    if(!($(this).attr('id'))){return;}
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
    $(`#${key}`).removeClass('sort');
    $('.sort').on('click',sortRows);
    $(`#${key}`).on('click',reverseRows);
    $(`#${key}`).append(`▲`);
}

function reverseRows(){
    if(!($(this).attr('id'))){return;}
    if($(`#${key}`).attr('class').includes('numbers')){
        displayJson.sort(reverseNumbers);
    }
    else if($(`#${key}`).attr('class').includes('bools')){
        displayJson.sort(reverseBools);
    }
    else{
        displayJson.sort(reverseStrings);
    }
    buildTable();
    $('th').addClass('sort');
    $('th').on('click',sortRows);
    $(`#${key}`).append('▼');
}

function filterTable(){
    key = $(this).attr('placeholder');
    filter = $(this).val();
    displayJson = _.filter(jsonPets, filterMap);
    buildTable();
    $('th').on('click',sortRows);
    $('th').addClass('sort');
}

function filterMap(pet){
    return (pet[key].toUpperCase().startsWith(filter.toUpperCase()));
}
