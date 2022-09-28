const selectProduct = document.querySelector("#product");
let selectedProduct = "";
const qtyProduct = document.querySelector("#qty");
const addProductBtn = document.querySelector("#add-product");

const listProduct = document.querySelector("#list-product");

const selectVoucher = document.querySelector("#voucher");
let selectedVoucher = "";

const totalPurchaseBeforeDiscount = document.querySelector(
    "#total-purchase-before-discount"
);
const voucherText = document.querySelector("#voucher-text");
const voucherValue = document.querySelector("#voucher-value");
const totalPurchase = document.querySelector("#total-purchase");
const subTotalInput = document.querySelector("#sub-total-input");
const totalInput = document.querySelector("#total-input");
const totalPurchaseInput = document.querySelector("#total-purchase-input");

let totalPrice = 0;
let totalPurchasePrice = 0;
let products = [];

const getTotal = () => {
    const type = voucherText.innerText.split(" ")[2];

    if (totalPurchasePrice !== 0) {
        totalPurchaseBeforeDiscount.innerText = totalPurchasePrice;
        subTotalInput.value = totalPurchasePrice;

        if (type === "Flat") {
            totalPurchase.innerText =
                totalPurchasePrice - parseFloat(voucherValue.innerText);
            totalPurchaseInput.value =
                totalPurchasePrice - parseFloat(voucherValue.innerText);
            totalInput.value = totalPrice - parseFloat(voucherValue.innerText);
        } else if (type === "Percent") {
            totalPurchase.innerText =
                totalPurchasePrice -
                totalPurchasePrice * (parseFloat(voucherValue.innerText) / 100);
            totalPurchaseInput.value =
                totalPurchasePrice -
                totalPurchasePrice * (parseFloat(voucherValue.innerText) / 100);
            totalInput.value =
                totalPrice -
                totalPrice * (parseFloat(voucherValue.innerText) / 100);
        } else {
            totalPurchase.innerText = totalPurchasePrice;
            totalPurchaseInput.value = totalPurchasePrice;
            totalInput.value = totalPrice;
        }
    } else {
        totalPurchaseBeforeDiscount.innerText = 0;
        totalPurchase.innerText = 0;
        subTotalInput.value = 0;
        totalPurchaseInput.value = 0;
        totalInput.value = 0;
    }
};

const setProducts = () => {
    window.localStorage.setItem("products", JSON.stringify(products));
};

const getTransaction = () => {
    if (products.length > 0) {
        products.filter((product) => {
            const { id, name, price, purchase_price, status, qty, subTotal } =
                product;

            axios
                .get(`/api/product/${id}`)
                .then(({ data }) => {
                    if (status === 1) {
                        listProduct.innerHTML += `
                            <li class="list-group-item d-flex p-2" data-id="${id}">
                                <input type="hidden" name="product_id[]" value="${data.id}">
                                <input type="hidden" name="product_qty[]" value="${qty}">
                                <p class="col-md-6 m-0 p-0 text-center">${name}</p>
                                <p class="col-md-1 m-0 p-0 text-center">${qty}</p>
                                <p class="col-md-3 m-0 p-0 text-center">${subTotal}</p>
                                <p class="col-md-2 m-0 p-0 text-center">
                                    <button type="button" class="btn btn-danger btn-circle btn-sm ml-1" onclick="deleteProduct(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </p>
                            </li>
                        `;

                        [...selectProduct.options].forEach((product, i) => {
                            if (product.value == data.id) {
                                selectProduct.options[i].remove();
                            }
                        });

                        totalPrice += price * parseInt(qty);
                        totalPurchasePrice += purchase_price * parseInt(qty);

                        return product;
                    }
                })
                .then(() => {
                    setProducts();
                    getTotal();
                })
                .catch((err) => console.log(err));
        });
    }
};

const getProducts = () => {
    products = JSON.parse(window.localStorage.getItem("products"))
        ? JSON.parse(window.localStorage.getItem("products"))
        : [];

    getTransaction();
};
getProducts();

addProductBtn.addEventListener("click", () => {
    selectedProduct = selectProduct.selectedOptions[0];

    if (
        selectedProduct.value !== "" &&
        qtyProduct.value !== "" &&
        parseInt(qtyProduct.value) > 0
    ) {
        axios
            .get(`/api/product/${selectedProduct.value}`)
            .then(({ data }) => {
                listProduct.innerHTML += `
                    <li class="list-group-item d-flex p-2" data-id="${data.id}">
                        <input type="hidden" name="product_id[]" value="${
                            data.id
                        }">
                        <input type="hidden" name="product_qty[]" value="${
                            qtyProduct.value
                        }">
                        <p class="col-md-6 m-0 p-0 text-center">${data.name}</p>
                        <p class="col-md-1 m-0 p-0 text-center">${
                            qtyProduct.value
                        }</p>
                        <p class="col-md-3 m-0 p-0 text-center">${
                            data.purchase_price * parseInt(qtyProduct.value)
                        }</p>
                        <p class="col-md-2 m-0 p-0 text-center">
                            <button type="button" class="btn btn-danger btn-circle btn-sm ml-1" onclick="deleteProduct(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </p>
                    </li>
                `;

                selectedProduct.remove();

                totalPrice += data.price * parseInt(qtyProduct.value);
                totalPurchasePrice +=
                    data.purchase_price * parseInt(qtyProduct.value);

                products.push({
                    ...data,
                    qty: qtyProduct.value,
                    subTotal: data.price * parseInt(qtyProduct.value),
                    subTotalPurchase:
                        data.purchase_price * parseInt(qtyProduct.value),
                });

                getTotal();
            })
            .catch((err) => console.log(err));
    }
});

const deleteProduct = (e) => {
    const singleProduct = e.parentElement.parentElement;
    const productId = {
        ...singleProduct.dataset,
    }["id"];

    axios
        .get(`/api/product/${productId}`)
        .then(({ data }) => {
            products = products.filter((product) => {
                totalPrice -= product.subTotal;
                totalPurchasePrice -= product.subTotalPurchase;
                return product.id != productId;
            });

            selectProduct.innerHTML += `
                <option value="${data.id}">
                    ${data.name.charAt(0).toUpperCase() + data.name.slice(1)}
                </option>
            `;

            singleProduct.remove();

            getTotal();
        })
        .catch((err) => console.log(err));
};

const loadVoucher = () => {
    selectedVoucher = selectVoucher.selectedOptions[0].value;

    if (selectedVoucher !== "")
        axios
            .get(`/api/voucher/${selectedVoucher}`)
            .then(({ data }) => {
                voucherText.innerText =
                    data.type === 1
                        ? "Voucher | Flat Discount"
                        : "Voucher | Percent Discount";
                voucherValue.innerText = data.disc_value;

                getTotal();
            })
            .catch((err) => console.log(err));
    else {
        console.log("ok");
        voucherText.innerText = "Voucher";
        voucherValue.innerText = "-";

        getTotal();
    }
};
loadVoucher();

selectVoucher.addEventListener("change", () => loadVoucher());
