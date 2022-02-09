const menuHamburguer = document.querySelector('#menu-hamburguer');
const navbarMenu = document.querySelector('.navbar-menu');
const navbarSearch = document.querySelector('.navbar-search');
const distritoChuquis = document.querySelector('#distritoChuquis');
const tingoMaria= document.querySelector('#tingomaria');

if(distritoChuquis && tingoMaria){
    distritoChuquis.addEventListener('click', ()=> ocultarSubmenu('.navbar-menu-list-submenu'));
    tingoMaria.addEventListener('click', ()=> ocultarSubmenu('.less'));
}

if(menuHamburguer){
menuHamburguer.addEventListener('click', ()=>{
    navbarMenu.classList.toggle('navbar-menu-actived');
    navbarSearch.classList.toggle('navbar-search-actived');
})
}
function ocultarSubmenu(distrito){
    const distritoChuquisMenu = document.querySelector(distrito);
   
    if(!distritoChuquisMenu.classList.contains('navbar-menu-list-submenu-actived')){
        distritoChuquisMenu.classList.add('navbar-menu-list-submenu-actived');
        distritoChuquisMenu.style.display = 'block';
    }else{
        distritoChuquisMenu.classList.remove('navbar-menu-list-submenu-actived');
        distritoChuquisMenu.style.display = 'none';  
    }
}




// distritoChuquis.addEventListener('mouseover', ()=>{
//     
    
// })

