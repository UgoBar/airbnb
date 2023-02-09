document.addEventListener('DOMContentLoaded', (e) => {
    /** -------- SCROLL SPY NAVBAR -------- **/
    const navbar = document.getElementById('mainNav');
    const avatarButton = document.querySelector('.nav-link.dropdown-toggle')

    window.onscroll = () => {
        let scrollPosition = document.documentElement.scrollTop || document.body.scrollTop;

        if(scrollPosition > 100) {
            navbar.style.backgroundColor = 'rgba(255, 255, 255, 0.7)'
            avatarButton.style.borderColor = 'black'
        } else {
            navbar.style.backgroundColor = 'unset'
            avatarButton.style.borderColor = '#acafb1'

        }
    }
    /** -------- END SCROLL SPY NAVBAR -------- **/


    /** -------- TINY MCE INIT -------- **/
    if(document.querySelector('textarea')) {
        tinymce.init({
            selector: 'textarea',
            height: 300,
            relative_urls: false,
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table paste imagetools wordcount",
                'image code'
            ],
            toolbar: "insertfile undo redo | image code | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        });
    }
    /** -------- END TINY MCE INIT -------- **/


    /** -------- AUTO COMPLETE -------- **/
    if(document.querySelector("#city input")) {
        const cityInput = document.querySelector("#city input")
        const datalist = document.createElement("datalist")

        datalist.id = "cityList";
        cityInput.parentElement.append(datalist);

// Listener on city input
        cityInput.addEventListener("input", function() {
            cityInput.setAttribute('list', 'cityList')
            if(cityInput.value.length > 2) {
                fetch(`${apiURL}/${cityInput.value}`)
                    .then( response => response.json() )
                    .then( json => {
                        datalist.innerHTML = '';
                        for(const option of json) {
                            const optionNode = document.createElement("option");
                            optionNode.value = option.ville_nom;
                            optionNode.innerHTML = `<div class="option-title">${option.ville_nom}</div><div class="option-content">${option.ville_nom_reel} (${option.ville_code_postal})</div>`;
                            datalist.appendChild(optionNode);
                        }
                    })
            }
        })

        document.querySelector('.btn.btn-red').addEventListener('click', () => {
            document.querySelector('form').submit();
        })
    }
    /** -------- END AUTO COMPLETE -------- **/


    /** -------- FORM COLLECTION -------- **/
    // if(document.querySelector('.add_item')) {
    //
    //     // const roomBeds = document.getElementById('roomBeds');
    //     const addBed = document.getElementById('addBed');
    //
    //     function addFormToCollection(roomBedsId) {
    //         const roomBeds = document.getElementById(roomBedsId);
    //         const item = document.createElement('div');
    //
    //         item.innerHTML = roomBeds.dataset.template.replaceAll('__name__', roomBeds.dataset.index);
    //
    //         item.classList.add('collection-item');
    //
    //         roomBeds.appendChild(item);
    //         roomBeds.dataset.index++;
    //
    //         item.querySelector('.remove-item').addEventListener('click', (e) => {
    //             item.remove();
    //         });
    //     }
    //
    //     addBed.addEventListener('click', addFormToCollection);
    // }
    /** -------- END FORM COLLECTION -------- **/
})
