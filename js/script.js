
    // Inicialização do Slick Slider para o destaque
    $('.autoplay').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
    });

    // Inicialização do Slick Slider para os produtos
    $('.multiple-items').slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 3,
    });

    const cart = [];
    const products = [
        { id: 1, name: 'Sacola de Algodão', price: 29.90 },
        // Adicione outros produtos conforme necessário
    ];

    // Função para atualizar o carrinho na interface



const botaoCarrinho = document.querySelector('#btnCar')
const containerCarrinho = document.querySelector('.container-cart')
const btnMenu = document.querySelector('#btnMenu')
const linkMenu = document.querySelector('.links-menu')
const ctBtn = document.querySelector('.icons')

botaoCarrinho.addEventListener("click", function(event){
    event.preventDefault()
    containerCarrinho.classList.toggle("show")
})

btnMenu.addEventListener("click", function(event){
    event.preventDefault()
    linkMenu.classList.toggle("show")
})