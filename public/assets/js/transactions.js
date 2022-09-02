function fillCreateTransactionForm(res, customerRole) {
    console.log(res);
    document.querySelector("#create-product-id").value = res.id;
    document.querySelector("#create-name").value = res.name;

    const createLensDetails = document.querySelector("#create-lens-details");
    if (res.type == "lens") {
        createLensDetails.removeAttribute("hidden", true);
    } else {
        createLensDetails.setAttribute("hidden", true);
    }

    let price = "";
    switch (customerRole) {
        case "customer":
            price = res.selling_price;
            break;
        case "member":
            price = res.member_price;
            break;
        case "reseller":
            price = res.wholesale_price;
            break;
    }

    document.querySelector("#create-product-price").value = formatRupiah(price);

    if (res.lens_type == "progressive") {
        document.querySelector("#progressive-table").removeAttribute("hidden");
        document.querySelector("#regular-table").setAttribute("hidden", true);

        document.querySelector("#create-r-sph").value = res.r_sph;
        document.querySelector("#create-r-cyl").value = res.r_cyl;
        document.querySelector("#create-r-add").value = res.r_add;
        document.querySelector("#create-l-sph").value = res.l_sph;
        document.querySelector("#create-l-cyl").value = res.l_cyl;
        document.querySelector("#create-l-add").value = res.l_add;
    }

    if (res.lens_type == "regular") {
        document.querySelector("#regular-table").removeAttribute("hidden");
        document.querySelector("#progressive-table").setAttribute("hidden", true);

        document.querySelector("#regular-sph").value = res.sph;
        document.querySelector("#regular-cyl").value = res.cyl;
        document.querySelector("#regular-add").value = res.add;
    }

}

function getProductCard(product) {
    let card = "";
    card += `<div class="mb-3">`;
    card += `<div class="card border-0 shadow">`;
    card += `<div class="card-body px-3 py-2">`;
    card += `<div class="product-title text-gray-700 fw-500">${product.product_name}</div>`;
    card += `<div class="product-title text-gray-700 fw-500 d-flex fs-7"><span class="me-1">${product.qty}</span><span class="me-1">@</span><span>Rp. ${formatRupiah(product.product_price)}</span></div>`;
    card += `<div class="footer mt-2" ${(product.type == "general") ? "hidden" : ""}>`;
    card += `<div class="table-responsive">`;
    card += `<table class="table table table-borderless table-dashed">`;
    card += `<thead class="text-gray-500 fw-500 text-uppercase">`;
    card += `<tr>`;
    card += `<th></th>`;
    card += `<th>SPH</th>`;
    card += `<th>CYL</th>`;
    card += `<th>ADD</th>`;
    card += `<th>Axis</th>`;
    card += `</tr>`;
    card += `</thead>`;
    card += `<tbody class="text-gray-700 fw-500">`;
    card += `<tr>`;
    card += `<td class="text-primary">R</td>`;
    card += `<td>${product.r_sph}</td>`;
    card += `<td>${product.r_cyl}</td>`;
    card += `<td>${product.r_add}</td>`;
    card += `<td>${product.r_axis}</td>`;
    card += `</tr>`;
    card += `<tr>`;
    card += `<td class="text-primary">L</td>`;
    card += `<td>${product.l_sph}</td>`;
    card += `<td>${product.l_cyl}</td>`;
    card += `<td>${product.l_add}</td>`;
    card += `<td>${product.l_axis}</td>`;
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


function fillDetails(res) {
    const transaction = res.transaction;
    const payments = res.payments;
    const transactionDetails = res.transactionDetails;

    document.getElementById("detail-date").value = transaction.formattedDate;
    document.getElementById("detail-customer").value = transaction.customer;
    document.getElementById("detail-user").value = transaction.user;
    document.getElementById("detail-status").value = transaction.status;
    document.getElementById("detail-discount").value = transaction.discount;
    document.getElementById("detail-grand-total").value = formatRupiah(transaction.grand_total);
    document.getElementById("detail-payment-status").value = transaction.payment_status;

    let productCards = "";
    transactionDetails.forEach(product => {
        productCards += getProductCard(product);
    });

    let paymentCards = "";
    payments.forEach(payment => {
        paymentCards += getPaymentCard(payment);
    });

    document.getElementById("details-products").innerHTML = productCards;
    document.getElementById("details-payments").innerHTML = paymentCards;
}

function fillCreatePayment(res) {
    const transaction = res.transaction;
    const payments = res.payments;

    document.querySelector("#create-payment-transaction-id").value = transaction.id;
    document.querySelector("#create-payment-grand-total").value = formatRupiah(transaction.grand_total);

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

        document.querySelector("#payments-history-title").append(titleEl);

        // document.querySelector("#create-payment-nominal").setAttribute("max", (parseInt(transaction.grand_total) - parseInt(currentNominal)));
    }

    const modalCreatePayment = new bootstrap.Modal(document.querySelector("#modal-create-payment"));
    modalCreatePayment.show();
}