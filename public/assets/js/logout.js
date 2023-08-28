document.addEventListener("DOMContentLoaded", () => {
    const $logout = document.querySelector(".logout");

    $logout.addEventListener("click", (e) => {
        console.log(document.cookie);
        // document.cookie = user_token +'=;';
        document.cookie = "user_token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        window.location.reload();
    });
});