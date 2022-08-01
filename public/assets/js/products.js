function setEditForm(res) {
    const product = res.data;
    const modalEdit = new bootstrap.Modal(document.querySelector("#modal-edit"));
    const formEdit = document.querySelector("#form-edit");
    const id = product.id;

    document.querySelector("#edit-name").value = product.name;
    document.querySelector("#edit-code").value = product.code;
    document.querySelector("#edit-type").value = product.type;
    setLensDetail(product.type);
    document.querySelector("#edit-r-sph").value = product.r_sph;
    document.querySelector("#edit-r-cyl").value = product.r_cyl;
    document.querySelector("#edit-r-add").value = product.r_add;
    document.querySelector("#edit-l-sph").value = product.l_sph;
    document.querySelector("#edit-l-cyl").value = product.l_cyl;
    document.querySelector("#edit-l-add").value = product.l_add;
    document.querySelector("#edit-qty").value = product.qty;
    document.querySelector("#edit-minimum-qty").value = product.minimum_qty;
    document.querySelector("#edit-original-price").value = formatRupiah(product.original_price);
    document.querySelector("#edit-selling-price").value = formatRupiah(product.selling_price);
    document.querySelector("#edit-member-price").value = formatRupiah(product.member_price);
    document.querySelector("#edit-wholesale-price").value = formatRupiah(product.wholesale_price);

    if (product.supplier_id == false) {
        document.querySelector("#edit-supplier").options[0].setAttribute("selected", true);
    } else {
        document.querySelector("#edit-supplier").value = product.supplier_id;
    }

    if (product.category_id == false) {
        document.querySelector("#edit-category").options[0].setAttribute("selected", true);
    } else {
        document.querySelector("#edit-category").value = product.category_id;
    }

    formEdit.setAttribute("action", `${baseURL}products/${id}`);

    modalEdit.show();
}
