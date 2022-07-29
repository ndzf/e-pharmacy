function formatRupiah(angka){
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
    split   		= number_string.split(','),
    sisa     		= split[0].length % 3,
    rupiah     		= split[0].substr(0, sisa),
    ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if(ribuan){
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return rupiah;
}

document.addEventListener("DOMContentLoaded", function(e) {
    const formatRupiahElements = document.querySelectorAll(".format-rupiah");
    for (formatRupiahElement of formatRupiahElements) {
        formatRupiahElement.innerText = `Rp. ${formatRupiah(formatRupiahElement.dataset.format)}`;
    }
});

const formatRupiahInputElements = document.querySelectorAll(".format-rupiah-input");
for (formatRupiahInputElement of formatRupiahInputElements) {
    formatRupiahInputElement.addEventListener("keyup", (e) => {
        e.target.value = formatRupiah(e.target.value);
    });
}

function formatRupiahInput(...elements) {
    for (element of elements) {
        const inputElement = document.querySelector(element);
        if (element == null || inputElement == null) {
            return true;
        }

        inputElement.value == formatRupiah(inputElement.value);
    }
}