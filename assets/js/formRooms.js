

let roomNbr = document.querySelectorAll('#rooms section').length;
const rooms = document.getElementById('rooms');

function addRoom() {

    const item = document.createElement('section');

    roomNbr++

    item.classList.add('card', 'item');
    item.innerHTML = `
        <h3 class="mb-4">Chambre <span class="roomNumber">${roomNbr}</span></h3>
    `
    item.innerHTML += rooms.dataset.template.replaceAll('__name__', rooms.dataset.index);
    rooms.appendChild(item);

    rooms.dataset.index++;

    document.querySelectorAll('.add_item').forEach(function(elem) {
        elem.addEventListener('click', addFormToCollection)
    })

    item.querySelector('.remove-item').addEventListener('click', function() {
        roomNbr--;
        item.remove();
    });
}

function addFormToCollection() {

    const collection = this.closest(`div`).nextSibling.nextSibling;
    const item = document.createElement('div');

    item.innerHTML = collection.dataset.template.replaceAll('__name__', collection.dataset.index);
    item.innerHTML += `<a class="btn btn-dark rounded remove-item" href="#"><i class="fa-solid fa-minus"></i></a>`

    item.classList.add('collection-item', 'item');

    collection.appendChild(item);
    collection.dataset.index++;

    item.querySelector('.remove-item').addEventListener('click', removeItem);
}

function removeItem(e) {
    e.preventDefault()
    this.closest('.item').remove();
}

document.querySelectorAll('.remove-item').forEach(function(elem) {
    elem.addEventListener('click', removeItem)
})
document.querySelectorAll('.add_item').forEach(function(elem) {
    elem.addEventListener('click', addFormToCollection)
})
document.getElementById('addRoom').addEventListener('click', addRoom)




