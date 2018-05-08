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
    for(let x=0;x<4;x++){
        let content = '';
        content += '<h2>'+countries[x].name+'</h2>';
        content += '<p>'+countries[x].continent+'</p>';
        let address = '';
        address += '<h3>Cities</h3>';
        for(let y=0;y<countries[x].cities.length;y++){
            address += '<p>'+countries[x].cities[y]+'</p>';
        }
        content += '<div class="inner-box">'+address+'</div>';
        let photo = '';
        photo += '<h3>Popular Photos</h3>'
        for(let y=0;y<countries[x].photos.length;y++){
            let src = "images/"+countries[x].photos[y];
            photo += '<img class="photo" src='+src+'>';
        }
        content += '<div class="inner-box">'+photo+'</div>';
        content += '<button>Visit</button>';
        items[x].innerHTML=content;
    }
};
