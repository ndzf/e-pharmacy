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

function fillPurchaseDetailModal(res) {
    document.querySelector("#detail-name").value = res.product;
    document.querySelector("#detail-type").value = res.type;
    document.querySelector("#detail-price").value = formatRupiah(res.price);
    document.querySelector("#detail-qty").value = res.qty;

    // Lens Details
    document.querySelector("#detail-r-sph").textContent = res.r_sph;
    document.querySelector("#detail-r-cyl").textContent = res.r_cyl;
    document.querySelector("#detail-r-add").textContent = res.r_add;

    document.querySelector("#detail-l-sph").textContent = res.l_sph;
    document.querySelector("#detail-l-cyl").textContent = res.l_cyl;
    document.querySelector("#detail-l-add").textContent = res.l_add;

    const lensTypeDetailsEl = document.querySelector("#lens-type-details");
    (res.type == "general") ? lensTypeDetailsEl.setAttribute("hidden", true) : lensTypeDetailsEl.removeAttribute("hidden");
}

function getProductCard(product) {
    let card = "";
    card += `<div class="mb-3">`;
    card += `<div class="card border-0 shadow">`;
    card += `<div class="card-body px-3 py-2">`;
    card += `<div class="product-title text-gray-700 fw-500">${product.product_name}</div>`;
    card += `<div class="product-title text-gray-700 fw-500 d-flex fs-7"><span class="me-1">${product.qty}</span><span class="me-1">@</span><span>Rp. ${formatRupiah(product.price)}</span></div>`;
    card += `<div class="footer mt-2" ${(product.type == "general") ? "hidden" : ""}>`;
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
    card += `</div>`;

    return card;
}

function getPaymentCard(payment, border = false) {
    let card = "";
    card += `<div class="mb-3">`;
    card += `<div class="card ${(border == true) ? "" : "border-0 shadow"}">`;
    card += `<div class="card-body px-3 py-2">`;
    card += `<div class="product-title text-gray-700 fw-500">Rp. ${formatRupiah(payment.nominal)}</div>`;
    card += `</div>`;
    card += `</div>`;
    card += `</div>`;

    return card;
}

function fillPurchase(res) {
    const purchase = res.purchase;
    const payments = res.payments;
    const purchaseDetails = res.purchaseDetails;

    document.getElementById("detail-date").value = purchase.formattedDate;
    document.getElementById("detail-user").value = purchase.user;
    document.getElementById("detail-status").value = purchase.status;
    document.getElementById("detail-discount").value = purchase.discount;
    document.getElementById("detail-grand-total").value = formatRupiah(purchase.grand_total);
    document.getElementById("detail-payment-status").value = purchase.payment_status;

    let productCards = "";
    purchaseDetails.forEach(product => {
        productCards += getProductCard(product);
    });

    console.dir(purchaseDetails);

    let paymentCards = "";
    payments.forEach(payment => {
        paymentCards += getPaymentCard(payment);
    });
    
    document.getElementById("details-products").innerHTML = productCards;
    document.getElementById("details-payments").innerHTML = paymentCards;
}

function fillCreatePayment(res) {
    const purchase = res.purchase;
    const payments = res.payments;

    document.querySelector("#create-payment-purchase-id").value = purchase.id;
    document.querySelector("#create-payment-grand-total").value = formatRupiah(purchase.grand_total);

    if (payments) {
        let paymentCards = "";
        let currentNominal = 0;
        payments.forEach(payment => {
            paymentCards += getPaymentCard(payment, true);
            currentNominal += payment.nominal;
        });
        document.querySelector("#payments-history").innerHTML = paymentCards;

        const titleEl = document.createElement("h5");
        titleEl.classList.add("text-gray-600", "fw-500", "mb-3");
        const title = document.createTextNode("Riwayat Pembayaran");
        titleEl.append(title);

        document.querySelector("#payments-history-title").innerHTML= "";
        document.querySelector("#payments-history-title").append(titleEl);

        // document.querySelector("#create-payment-nominal").setAttribute("max", (parseInt(transaction.grand_total) - parseInt(currentNominal)));
    }

    const modalCreatePayment = new bootstrap.Modal(document.querySelector("#modal-create-payment"));
    modalCreatePayment.show();
}