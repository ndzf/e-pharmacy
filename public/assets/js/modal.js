function clearValidation(...forms) {
    for (formId of forms) {
        const formElement = document.querySelector(`#${formId}`);
        if (formElement == null) {
            return false;
        }
        const inputElements = Array.from(formElement);
        if (inputElements == null) {
            return false;
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