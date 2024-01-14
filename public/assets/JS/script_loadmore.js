const button = document.getElementById('button_load')
const select = document.getElementById('select')
const affichageChargerPlus = document.querySelector('.charger-plus')

const toutes = document.getElementById('toutes')
toutes.addEventListener('click', () => {
    button.setAttribute('data-type', 0)
})

const recherches = document.getElementById('recherches')
recherches.addEventListener('click', () => {
    button.setAttribute('data-type', 1)
})

const propositions = document.getElementById('propositions')
propositions.addEventListener('click', () => {
    button.setAttribute('data-type', 2)
})

button.addEventListener('click', () => {
const type = button.getAttribute('data-type')
const category = document.querySelector('#category')
    fetch(`http://localhost:8000/annonceSearch?page=${button.value}&category=${category.value}&type=${type}`)
        .then(response => response.json())
        .then(data => {
            const currentCard = document.getElementById('newCard')
            if (data.search) {
                data.search.forEach(dat => {
                    currentCard.innerHTML += ` <div class="card_annonce uk-width-1-3 ">
                <div class="card-header_annonce">
                    <div class="card-header-hover_annonce">
                        <img src="${dat.image}" alt="${dat.image_name}" class="card-image_annonce">
                            <a href="/annonces/detail-annonce?id=${dat.id}" class="uk-button card-button_annonce">Voir l'annonce</a>
                    </div>
                </div>
                <div class="card-body_annonce">
                    <h5 class="card-title_annonce"> ${dat.title}</h5>
                    <p class="card-description_annonce">
                        ${dat.description}</p>
                </div>
                <div class="card-footer_annonce">
                    <div class="card-info_annonce">
                        <p class="card-category_annonce">${dat.name} <p hidden="hidden">${dat.nametype}</p>
                        </p>
                        <p class="card-user_annonce">
                            ${dat.username}</p>
                        <p class="card-date-place_annonce"></p>
                            ${dat.published_date}
                            -
                            ${dat.localisation}
                        </p>
                    </div>
                </div>
            </div>
        </div> `

                }) 
                
                if (data.count[0].countads <= (button.value)*2) {                    
                    affichageChargerPlus.style.display = "none"   
                }
            }

        })
        .catch(error => alert("Erreur : " + error));

    button.setAttribute('value', parseInt(button.value) + 1)
        
});

function change_period2_laptop(period){     
    let toutes = document.getElementById("toutes");
    let recherches = document.getElementById("recherches");
    let propositions = document.getElementById("propositions");
    let selector1 = document.getElementById("selector1");
    if(period === "toutes") {       
      selector1.style.left = 0;
      selector1.style.width = toutes.clientWidth + "px";    
      selector1.innerHTML = "Toutes";    
    }else if(period === "recherches"){     
      selector1.style.left = recherches.clientWidth + "px";
      selector1.style.width = recherches.clientWidth + "px";
      selector1.innerHTML = "Recherches";    
    }else{       
      selector1.style.left = toutes.clientWidth + recherches.clientWidth + 1 + "px";
      selector1.style.width = toutes.clientWidth + "px";
      selector1.innerHTML = "Propositions";    
    }   
  }
  
  function change_period2_mobile(period){    
    let toutes = document.getElementById("toutes2");
    let recherches = document.getElementById("recherches2");
    let propositions = document.getElementById("propositions2");
    let selector2 = document.getElementById("selector2");
    if(period === "toutes2"){
      selector2.style.top = 0;
      selector2.style.height = toutes.clientHeight + "px";
      selector2.innerHTML = "Toutes";
    }else if(period === "recherches2"){
      selector2.style.top = recherches.clientHeight + "px";
      selector2.style.height = recherches.clientHeight + "px";
      selector2.innerHTML = "Recherches";
    }else{
      selector2.style.top = toutes.clientHeight + recherches.clientHeight + 1 + "px";
      selector2.style.height = toutes.clientHeight + "px";
      selector2.innerHTML = "Propositions";
    }
    button.setAttribut("data-type", type);
  }