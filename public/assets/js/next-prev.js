document.addEventListener("DOMContentLoaded", () => {
    const rooms = ["room-1", "room-2", "room-3", "room-4", "room-5"];
    const $gallery = document.querySelector(".gallery-room");
    let index = 0;

    $gallery.style.backgroundImage = `url('./assets/images/rooms/${rooms[index]}.jpg')`;

    const $btn1 = document.querySelector(".previous");
    const $btn2 = document.querySelector(".next");
    

    $btn1.addEventListener("click", (e) => {
        index--;
        if (index < 0){
            index = 4;
        }
        $gallery.style.backgroundImage = `url('./assets/images/rooms/${rooms[index]}.jpg')`;
    });

    $btn2.addEventListener("click", (e) => {
        index++;
        if (index > 4){
            index = 0;
        }
        $gallery.style.backgroundImage = `url('./assets/images/rooms/${rooms[index]}.jpg')`;
    });

});