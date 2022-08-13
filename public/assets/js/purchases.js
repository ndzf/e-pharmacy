function getSearchProductsCards(product) {
    let card = "";
    card += `<div class="mb-3">`;
    card += `<a href="javascript:void(0)" onclick="addProduct(${product.id})">`;
    card += `<div class="card border-0 shadow">`;
    card += `<div class="card-body px-3 py-2">`;
    card += `<span class="badge badge-light-${(product.type == "general") ? "primary" : "success"} mb-2">${product.type}</span>`;
    card += `<div class="product-title text-gray-700 fw-500 mb-2">${product.name}</div>`;
    card += `<div class="footer" ${(product.type == "general") ? "hidden" : ""}>`;
    card += `<div class="table-responsive">`;
    card += `<table class="table table table-borderless table-dashed">`;
    card += `<thead class="text-gray-500 fw-500 text-uppercase">`;
    card += `<tr>`;
    card += `<th></th>`;
    card += `<th>SPH</th>`;
    card += `<th>CYL</th>`;
    card += `<th>ADD</th>`;
    card += `</tr>`;
    card += `</thead>`;
    card += `<tbody class="text-gray-700 fw-500">`;
    card += `<tr>`;
    card += `<td class="text-primary">R</td>`;
    card += `<td>${product.r_sph}</td>`;
    card += `<td>${product.r_cyl}</td>`;
    card += `<td>${product.r_add}</td>`;
    card += `</tr>`;
    card += `<tr>`;
    card += `<td class="text-primary">L</td>`;
    card += `<td>${product.l_sph}</td>`;
    card += `<td>${product.l_cyl}</td>`;
    card += `<td>${product.l_add}</td>`;
    card += `</tr>`;
    card += `</tbody>`;
    card += `</table>`;
    card += `</div>`;
    card += `</div>`;
    card += `</div>`;
    card += `</div>`;
    card += `</a>`;
    card += `</div>`;

    return card;
}

function fillSearchModal(res) {
    let productCards = "";
    res.forEach(function(product) {
        productCards += getSearchProductsCards(product);
    });
    
    document.querySelector("#search-result").innerHTML = productCards;
}

const searchSpinner = document.querySelector("#search-spinner");

function showSearchSpinner() {
    searchSpinner.removeAttribute("hidden");
}

function hideSearchSpinner() {
    searchSpinner.setAttribute("hidden", true);
}

function getOption(title, price) {
    const option = document.createElement("option");
    option.setAttribute("value", price);
    option.textContent = `${title}: Rp. ${formatRupiah(price)}`;
    return option;
}

function fillAddProduct(res) {
    console.log(res.id);
    document.querySelector("#create-product-name").value = res.name;
    document.querySelector("#create-product-id").value = res.id;
    const createPrice = document.querySelector("#create-price");
    const originalPriceOption = getOption("Harga Asli", res.original_price);
    const sellingPriceOption = getOption("Harga Jual", res.selling_price);
    const memberPriceOption = getOption("Harga Member", res.member_price);
    const wholesalePriceOption = getOption("Harga Grosir", res.wholesale_price);
    createPrice.append(originalPriceOption, sellingPriceOption, memberPriceOption, wholesalePriceOption);

}
