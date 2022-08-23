const inputType = document.querySelector("#type");

const lensTypeWrapper = value => {
    if (value == "regular") {
        document.querySelector("#lens-type-regular-wrapper").removeAttribute("hidden");
        document.querySelector("#lens-type-progressive-wrapper").setAttribute("hidden", true);
    }
    if (value == "progressive") {
        document.querySelector("#lens-type-regular-wrapper").setAttribute("hidden", true);
        document.querySelector("#lens-type-progressive-wrapper").removeAttribute("hidden");
    }
}

const hideLensTypeWrappers = () => {
    document.querySelector("#lens-type-regular-wrapper").setAttribute("hidden", true);
    document.querySelector("#lens-type-progressive-wrapper").setAttribute("hidden", true);
}

inputType.addEventListener("change", function (e) {

    const value = e.target.value;

    if (value == "lens") {
        document.querySelector("#lens-type-wrapper").removeAttribute("hidden");
        // Check lens type
        const inputLensType = document.querySelector("#lens-type");
        lensTypeWrapper(inputLensType.value);

    } else {
        document.querySelector("#lens-type-wrapper").setAttribute("hidden", true);
        hideLensTypeWrappers();
    }
});

document.querySelector("#lens-type").addEventListener("change", function (e) {
    lensTypeWrapper(e.target.value);
});


inputType.addEventListener("DOMContentLoaded", function (e) {
    const value = e.target.value;

    if (value == "lens") {
        document.querySelector("#lens-type-wrapper").removeAttribute("hidden");
        // Check lens type
        const inputLensType = document.querySelector("#lens-type");
        lensTypeWrapper(inputLensType.value);

    } else {
        document.querySelector("#lens-type-wrapper").setAttribute("hidden", true);
        hideLensTypeWrappers();
    }
})

document.querySelector("#lens-type").addEventListener("DOMContentLoaded", function (e) {
    lensTypeWrapper(e.target.value);
});