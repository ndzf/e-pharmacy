function resetSelectedOptions(el, selectedTop) {

    const options = document.querySelector(`${el}`).options;

    if (options == null) {
        return true;
    }

    for (option of options) {
        option.removeAttribute("selected");
    }

    if (selectedTop == true) {
        options[0].setAttribute("selected", true);
    }

}

function clearValidation(...elements) {
    for (formID of elements) {
        const form = document.querySelector(`${formID}`);
        if (form == null) {
            return true;
        }

        const inputElements = Array.from(form);
        if (inputElements == null) {
            return true;
        }

        for (inputElement of inputElements) {
            if (inputElement.name != "_method") {
                inputElement.value = "";
            }
            if (inputElement.classList.contains("is-invalid")) {
                inputElement.classList.remove("is-invalid");
            }
        }
    }
}