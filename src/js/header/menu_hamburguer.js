const menuHamburguer = document.querySelector('#menu-hamburguer');
const navbarMenu = document.querySelector('.navbar-menu');
const navbarSearch = document.querySelector('.navbar-search');
const distritoChuquis = document.querySelector('#distritoChuquis');
const distritoChuquisMenu = document.querySelector('.navbar-menu-list-submenu');

if(menuHamburguer){
menuHamburguer.addEventListener('click', ()=>{
    navbarMenu.classList.toggle('navbar-menu-actived');
    navbarSearch.classList.toggle('navbar-search-actived');
})
}

if(distritoChuquis){
distritoChuquis.addEventListener('click', ()=>{

 
    if(!distritoChuquisMenu.classList.contains('navbar-menu-list-submenu-actived')){
        distritoChuquisMenu.classList.add('navbar-menu-list-submenu-actived');
        distritoChuquisMenu.style.display = 'block';
    }else{
        distritoChuquisMenu.classList.remove('navbar-menu-list-submenu-actived');
        distritoChuquisMenu.style.display = 'none';  
    }
})
}
// distritoChuquis.addEventListener('mouseover', ()=>{
//     
    
// })

