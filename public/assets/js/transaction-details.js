
function fillDetailModal(res) {
    console.log(res);
    document.querySelector("#detail-name").value = res.product;
    document.querySelector("#detail-type").value = res.type;
    document.querySelector("#detail-price").value = formatRupiah(res.product_price);
    document.querySelector("#detail-qty").value = res.qty;

    // Lens Details
    if (res.lens_type == "progressive") {
        document.querySelector("#detail-table-progressive").removeAttribute("hidden");
        document.querySelector("#detail-table-regular").setAttribute("hidden", true);

        document.querySelector("#detail-r-sph").textContent = res.r_sph;
        document.querySelector("#detail-r-cyl").textContent = res.r_cyl;
        document.querySelector("#detail-r-add").textContent = res.r_add;
        document.querySelector("#detail-r-axis").textContent = res.r_axis;

        document.querySelector("#detail-l-sph").textContent = res.l_sph;
        document.querySelector("#detail-l-cyl").textContent = res.l_cyl;
        document.querySelector("#detail-l-add").textContent = res.l_add;
        document.querySelector("#detail-l-axis").textContent = res.l_axis;
    }

    if (res.lens_type == "regular") {
        document.querySelector("#detail-table-regular").removeAttribute("hidden");
        document.querySelector("#detail-table-progressive").setAttribute("hidden", true);

        document.querySelector("#detail-sph").textContent = res.sph;
        document.querySelector("#detail-cyl").textContent = res.cyl;
        document.querySelector("#detail-add").textContent = res.add;
        document.querySelector("#detail-axis").textContent = res.axis;
    }

    const lensTypeDetailsEl = document.querySelector("#lens-type-details");
    (res.type == "general") ? lensTypeDetailsEl.setAttribute("hidden", true) : lensTypeDetailsEl.removeAttribute("hidden");
}