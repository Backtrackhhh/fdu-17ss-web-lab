const countries = [
        { name: "Canada", continent: "North America", cities: ["Calgary","Montreal","Toronto"], photos: ["canada1.jpg","canada2.jpg","canada3.jpg"] },
        { name: "United States", continent: "North America", cities: ["Boston","Chicago","New York","Seattle","Washington"], photos: ["us1.jpg","us2.jpg"] },
        { name: "Italy", continent: "Europe", cities: ["Florence","Milan","Naples","Rome"], photos: ["italy1.jpg","italy2.jpg","italy3.jpg","italy4.jpg","italy5.jpg","italy6.jpg"] },
        { name: "Spain", continent: "Europe", cities: ["Almeria","Barcelona","Madrid"], photos: ["spain1.jpg","spain2.jpg"] }
    ];
    window.onload=function () {
    var container = document.getElementsByClassName("flex-container");
    container[0].innerHTML = '<div class="item"></div>'+'<div class="item"></div>'+'<div class="item"></div>'+'<div class="item"></div>';
    var items=document.getElementsByClassName("item");
    for(let i=0;i<4;i++){
        let country = '<h2>'+countries[i].name+'</h2>';
        country += '<p>'+countries[i].continent+'</p>';
        let address = '<h3>Cities</h3>';
        for(let j=0;j<countries[i].cities.length;j++){
            address += '<p>'+countries[i].cities[j]+'</p>';
        }
        country += '<div class="inner-box">'+address+'</div>';
        let photo = '<h3>Popular Photos</h3>'
        for(let y=0;y<countries[i].photos.length;y++){
            let src = "images/"+countries[i].photos[y];
            photo += '<img class="photo" src='+src+'>';
        }
        country += '<div class="inner-box">'+photo+'</div>';
        country += '<button>Visit</button>';
        items[i].innerHTML=country;
    }
};
