document.addEventListener("DOMContentLoaded", () => {
    const $min_price = document.querySelector("#min-price");
    const $value1 = document.querySelector("#value1");
    const $max_price = document.querySelector("#max-price");
    const $value2 = document.querySelector("#value2");

    $value1.addEventListener("input", (e) => {
        const min_price = e.target.value;

        $min_price.value = min_price;
    });

    $value2.addEventListener("input", (e) => {
        const max_price = e.target.value;

        $max_price.value = max_price;
    });
});