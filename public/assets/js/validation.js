document.addEventListener("DOMContentLoaded", () => {
    const $form = document.querySelector("form");
    const $name = document.querySelector("#firstname");
    const $email = document.querySelector("#youremail");
    const $emailRepeat = document.querySelector("#email-repeat");
    const $password = document.querySelector("#yourpassword");
    const errorN = document.querySelector(".errorN");
    const errorE = document.querySelector(".errorE");
    const errorER = document.querySelector(".errorER");
    const errorP = document.querySelector(".errorP");

    const getValidations = (name, email, emailRepeat, password) => {
        let nameIsValid = false;
        let emailIsValid = false;
        let emailRisValid = false;
        let passwordIsValid = false;

        if ( name!= "" && name.length >= 5 ) {
            nameIsValid = true;
        }

        if (
        email !== "" &&
        /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)
        ) {
        emailIsValid = true;
        }

        if (emailRepeat === email && emailRepeat != "") {
            emailRisValid = true;
        }

        if (password !== "" && password.length > 4) {
        passwordIsValid = true;
        }

        return {
        nameIsValid,
        emailIsValid,
        emailRisValid,
        passwordIsValid,
        };
    };

    $form.addEventListener("submit", (e) => {
        $form.preventDefault();
        const name = $name.value;
        const email = $email.value;
        const emailRepeat = $emailRepeat.value;
        const password = $password.value;
        
        const validations = getValidations(name, email, emailRepeat, password);

        if (!validations.nameIsValid) {
            $name.classList.add("alertE");
            errorN.classList.remove("d-none");
        } else {
            $name.classList.remove("alertE");
            errorN.classList.add("d-none");
        }

        if (!validations.emailIsValid) {
            $email.classList.add("is-invalid");
            errorE.classList.remove("d-none");
        } else {
            $email.classList.remove("is-invalid");
            errorE.classList.add("d-none");
        }
        
        if (!validations.emailRisValid) {
            $emailRepeat.classList.add("is-invalid");
            errorER.classList.remove("d-none");
        } else {
            $emailRepeat.classList.remove("is-invalid");
            errorER.classList.add("d-none");
        }

        if (!validations.passwordIsValid) {
            $password.classList.add("is-invalid");
            errorP.classList.remove("d-none");
        } else {
            $password.classList.remove("is-invalid");
            errorP.classList.add("d-none");
        }
    
        if (validations.emailIsValid && validations.passwordIsValid) {
            $form.submit();
        }
    });

    errorN.classList.add("d-none");
    errorE.classList.add("d-none");
    errorER.classList.add("d-none");
    errorP.classList.add("d-none");
});