document.addEventListener("DOMContentLoaded", () => {
    const $filterBar = document.querySelector(".filters");
    const $form = document.querySelector("form");

    $filterBar.addEventListener("click", (e) => {
        if ($form.className.includes("d-none")) {
            $form.classList.remove("d-none");
        } else {
            $form.classList.add("d-none");
        }
    });

    function myFunction(x) {
        if (x.matches) { // If media query matches
            $form.classList.add("d-none");
            $filterBar.classList.remove("d-none");
        } else {
            $form.classList.remove("d-none");
            $filterBar.classList.add("d-none");
        }
      }

    $filterBar.classList.add("d-none");
    var x = window.matchMedia("(max-width: 640px)")
    myFunction(x) // Call listener function at run time
    x.addListener(myFunction) // Attach listener function on state changes
});