var jsonPets = {
    'dogs':[
        {
            'name':'Cookie',
            'breed':'Chihuahua',
            'sex':'Female',
            'shots':true,
            'age':'2014-7-7',
            'size':'25',
            'licensed':false,
            'neutered':true,
            'owners':'Owners List in Future Release.',
            'notes':'Notes in Future Release.'
        },
        {
            'name':'Brooke',
            'breed':'Jack Russel',
            'sex':'Male',
            'shots':false,
            'age':'2014-7-9',
            'size':'15',
            'licensed':true,
            'neutered':false,
            'owners':'Owners List in Future Release.',
            'notes':'Notes in Future Release.'
        },
        {
            'name':'Peanut',
            'breed':'Terrier',
            'sex':'Female',
            'shots':true,
            'age':'1995-7-3',
            'size':'60',
            'licensed':false,
            'neutered':true,
            'owners':'Owners List in Future Release.',
            'notes':''
        }
    ],
    'cats':[
        {
            'name':'Sasha',
            'breed':'Siamese',
            'sex':'Male',
            'shots':true,
            'age':'2013-5-3',
            'declawed':false,
            'neutered':true,
            'owners':'Owners List in Future Release.',
            'notes':'Notes in Future Release.'
        },
        {
            'name':'Bella',
            'breed':'Russian Blue',
            'sex':'Female',
            'shots':false,
            'age':'2010-4-4',
            'declawed':true,
            'neutered':false,
            'owners':'Owners List in Future Release.',
            'notes':''
        },
        {
            'name':'Nero',
            'breed':'Siamese',
            'sex':'Male',
            'shots':false,
            'age':'2003-5-6',
            'declawed':true,
            'neutered':true,
            'owners':'',
            'notes':'Notes in Future Release.'
        }
    ],
    'exotics':[
        {
            'name':'Toffee',
            'species':'Guinea Pig',
            'sex':'Female',
            'age':'2015-7-1',
            'owners':'Owners List in Future Release.',
            'notes':'Notes in Future Release.'
        },
        {
            'name':'Jack',
            'species':'Parakeet',
            'sex':'Male',
            'age':'2015-10-5',
            'owners':'Owners List in Future Release.',
            'notes':''
        },
        {
            'name':'Roger',
            'species':'Rabbit',
            'sex':'Male',
            'age':'1997-12-5',
            'owners':'',
            'notes':'Notes in Future Release.'
        }
    ]
}
$().ready(buildPage);
function buildPage(){
    buildTable();
    $('th').on('click',sortRows);
    $('.modal-btn').on('click', modalToggle);
}

function buildTable(){
    let species = $('body').attr('id');
    if(species == 'dog'){buildDog();}
    if(species == 'cat'){buildCat();}
    if(species == 'exotic'){buildExotic();}
}

function buildDog(){
    let dogHead = '<tbody><tr><th id="0">Name</th><th id="1">Breed</th><th id="2">Sex</th><th id="3">Shots</th><th id="4" class="numbers">Age</th><th id="5">Size</th><th id="6">Licensed</th><th id="7">Neutered</th><th id="8">Owners</th><th id="9">Notes</th></tr>';
    let dogTable = '';
    let dogModals = '';
    let i = 1;
    for(let dog of jsonPets.dogs){
        let dogDate = new Date(dog.age);
        let dogAge = Math.floor(((Date.now() - dogDate) / 86400000) / 365.25);

        dogTable += `<tr class="tdRow"><td>${dog.name}</td>
        <td>${dog.breed}</td>
        <td>${dog.sex}</td>
        <td>${(dog.shots)?'Yes':'No'}</td>
        <td>${dogAge}</td>`;

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
            dogTable += `<td><button id="own${i}" class="button is-info modal-btn">Owners</button></td>`
        }
        else{
            dogTable += `<td>None</td>`;
        }

        if(dog.notes){
            dogTable += `<td><button id="note${i}" class="button is-info modal-btn">Notes</button></td></tr>`;
        }
        else{
            dogTable += `<td>None</td></tr>`;
        }

        // Modals for any category that requires one, to be put at the bottom of Body
        if(dog.owners){
            dogModals += `<div class="modal" id="own${i}Modal">
            <div class="modal-content">
            <span class="close">&times;</span>
            <p>${dog.owners}</p>
            </div>
            </div>`;
        }
        if(dog.notes){
            dogModals += `<div class="modal" id="note${i}Modal">
            <div class="modal-content">
            <span class="close">&times;</span>
            <p>${dog.notes}</p>
            </div>
            </div>`;
        }
        i++;
    }
    dogTable += `</tbody>`;
    dogTable = dogHead + dogTable;
    $('.table').html(dogTable);
    $('body').append(dogModals);
}

function buildCat(){
    let catHead = '<tbody><tr><th id="0">Name</th><th id="1">Breed</th><th id="2">Sex</th><th id="3">Shots</th><th id="4" class="numbers">Age</th><th id="5">Declawed</th><th id="6">Neutered</th><th id="7">Owners</th><th id="8">Notes</th></tr>';
    let catTable = '';
    let catModals = '';
    let i = 1;

    for(let cat of jsonPets.cats){
        let catDate = new Date(cat.age);
        let catAge = Math.floor(((Date.now() - catDate) / 86400000) / 365.25);
    

        catTable += `<tr class="tdRow"><td>${cat.name}</td>
        <td>${cat.breed}</td>
        <td>${cat.sex}</td>
        <td>${(cat.shots)?'Yes':'No'}</td>
        <td>${catAge}</td>
        <td>${(cat.declawed)?'Yes':'No'}</td>
        <td>${(cat.neutered)?'Yes':'No'}</td>`;

        if(cat.owners){
            catTable += `<td><button id="own${i}" class="button is-info modal-btn">Owners</button></td>`
        }
        else{
            catTable += `<td>None</td>`;
        }
        if(cat.notes){
            catTable += `<td><button id="note${i}" class="button is-info modal-btn">Notes</button></td></tr>`;
        }
        else{
            catTable += `<td>None</td></tr>`;
        }

        if(cat.owners){
            catModals += `<div class="modal" id="own${i}Modal">
            <div class="modal-content">
            <span class="close">&times;</span>
            <p>${cat.owners}</p>
            </div>
            </div>`;
        }
        if(cat.notes){
            catModals += `<div class="modal" id="note${i}Modal">
            <div class="modal-content">
            <span class="close">&times;</span>
            <p>${cat.notes}</p>
            </div>
            </div>`;
        }
        i++;
    }
    catTable += `</tbody>`;
    catTable = catHead + catTable;
    $('.table').html(catTable);
    $('body').append(catModals);
}

function buildExotic(){
    let exoticHead = '<tbody><tr><th id="0">Name</th><th id="1">Species</th><th id="2">Sex</th><th id="3" class="numbers">Age</th><th id="4">Owners</th><th id="5">Notes</th></tr>';
    let exoticTable = '';
    let exoticModals = '';
    let i = 1;
    for(let exotic of jsonPets.exotics){
        let exoDate = new Date(exotic.age);
        let exoAge = Math.floor(((Date.now() - exoDate) / 86400000) / 365.25);

        exoticTable += `<tr class="tdRow"><td>${exotic.name}</td>
        <td>${exotic.species}</td>
        <td>${exotic.sex}</td>
        <td>${exoAge}</td>`;

        if(exotic.owners){
            exoticTable += `<td><button id="own${i}" class="button is-info modal-btn">Owners</button></td>`
        }
        else{
            exoticTable += `<td>None</td>`;
        }
        if(exotic.notes){
            exoticTable += `<td><button id="note${i}" class="button is-info modal-btn">Notes</button></td></tr>`;
        }
        else{
            exoticTable += `<td>None</td></tr>`;
        }

        if(exotic.owners){
            exoticModals += `<div class="modal" id="own${i}Modal">
            <div class="modal-content">
            <span class="close">&times;</span>
            <p>${exotic.owners}</p>
            </div>
            </div>`;
        }
        if(exotic.notes){
            exoticModals += `<div class="modal" id="note${i}Modal">
            <div class="modal-content">
            <span class="close">&times;</span>
            <p>${exotic.notes}</p>
            </div>
            </div>`;
        }
        i++;
    }
    exoticTable += `</tbody>`;
    exoticTable = exoticHead + exoticTable;
    $('.table').html(exoticTable);
    $('body').append(exoticModals);
}

function modalToggle(){
    let buttonID = $(this).attr('id');
    let modal = $(`#${buttonID}Modal`)[0];
    modal.style.display = 'block';
    $(`#${buttonID}Modal .close`).on('click', function(){
        modal.style.display = 'none';
    });
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}

function buildSort(){
}

function reverseRows(){
    let switching, x, y;
    let index = $(this).attr('id');
    switching = true;
    if($(this).attr('class') == 'numbers'){
        while (switching) {
            switching = false;
            let rows = $('.tdRow');
            for (let row in rows) {
                let row2 = parseInt(row) + 1;
                if(row2 == $('.tdRow').length){break;}
                x = rows[row].getElementsByTagName("TD")[index];
                y = rows[row2].getElementsByTagName("TD")[index];
                if (parseInt(x.innerHTML) < parseInt(y.innerHTML)) {
                    rows[row].parentNode.insertBefore(rows[row2], rows[row]);
                    switching = true;
                    break;
                }
            }
        }
    }
    else{
        while (switching) {
            switching = false;
            let rows = $('.tdRow');
            for (let row in rows) {
                let row2 = parseInt(row) + 1;
                if(row2 == $('.tdRow').length){break;}
                x = rows[row].getElementsByTagName("TD")[index];
                y = rows[row2].getElementsByTagName("TD")[index];
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    rows[row].parentNode.insertBefore(rows[row2], rows[row]);
                    switching = true;
                    break;
                }
            }
        }
    }
    $(this).on('click',sortRows);
}


function sortRows(){
    let switching, x, y;
    let index = $(this).attr('id');
    switching = true;
    if($(this).attr('class') == 'numbers'){
        while (switching) {
            switching = false;
            let rows = $('.tdRow');
            for (let row in rows) {
                let row2 = parseInt(row) + 1;
                if(row2 == $('.tdRow').length){break;}
                x = rows[row].getElementsByTagName("TD")[index];
                y = rows[row2].getElementsByTagName("TD")[index];
                if (parseInt(x.innerHTML) > parseInt(y.innerHTML)) {
                    rows[row].parentNode.insertBefore(rows[row2], rows[row]);
                    switching = true;
                    break;
                }
            }
        }
    }
    else{
        while (switching) {
            switching = false;
            let rows = $('.tdRow');
            for (let row in rows) {
                let row2 = parseInt(row) + 1;
                if(row2 == $('.tdRow').length){break;}
                x = rows[row].getElementsByTagName("TD")[index];
                y = rows[row2].getElementsByTagName("TD")[index];
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    rows[row].parentNode.insertBefore(rows[row2], rows[row]);
                    switching = true;
                    break;
                }
            }
        }
    }
    $(this).on('click',reverseRows);
}

