
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
/** -------- END TINY MCE INIT -------- **/


/** -------- AUTO COMPLETE -------- **/
const cityInput = document.getElementById("apartment_city")
const datalist = document.createElement("datalist")

datalist.id = "cityList";
cityInput.parentElement.append(datalist);

// Listener on city input
cityInput.addEventListener("input", function() {
    if(cityInput.value.length > 2) {
        fetch(`${apiURL}/${cityInput.value}`)
            .then( response => response.json() )
            .then( json => {
                datalist.innerHTML = '';
                datalist.style.display = 'block';
                for(const option of json) {
                    const optionNode = document.createElement("option");
                    optionNode.value = option.ville_nom;
                    optionNode.innerHTML = `<div class="option-title">${option.ville_nom}</div><div class="option-content">${option.ville_nom_reel} (${option.ville_code_postal})</div>`;
                    datalist.appendChild(optionNode);
                    optionNode.addEventListener('click', function() {
                        cityInput.value = optionNode.value;
                        datalist.style.display = 'none';
                    })
                }
            })
    }
})

cityInput.addEventListener("focusout", function() {
    datalist.style.display = 'none';
})
/** -------- END AUTO COMPLETE -------- **/
