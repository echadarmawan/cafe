let total = 0;
let index = 0;

function tambahItem(){

    let select = document.getElementById('menuSelect');

    if(select.value === ''){
        alert('Pilih menu');
        return;
    }

    let menuId = select.value;
    let menuNama = select.options[select.selectedIndex].text;
    let harga = parseInt(
        select.options[select.selectedIndex].dataset.harga
    );

    let qty = parseInt(
        document.getElementById('qty').value
    );

    let subtotal = harga * qty;

    total += subtotal;

    document.getElementById('grandTotal').innerHTML =
        total.toLocaleString('id-ID');

    document.getElementById('total_pesanan').value =
        total;

    let row = `
        <tr id="row${index}">
            <td>${menuNama}</td>
            <td>${harga.toLocaleString('id-ID')}</td>
            <td>${qty}</td>
            <td>${subtotal.toLocaleString('id-ID')}</td>
            <td>
                <button
                    type="button"
                    class="btn btn-danger btn-sm"
                    onclick="hapusItem(${index}, ${subtotal})">
                    Hapus
                </button>
            </td>
        </tr>
    `;

    document.getElementById('detailBody')
        .insertAdjacentHTML('beforeend', row);

    let hidden = `
        <div id="input${index}">
            <input type="hidden"
                   name="menu_id[]"
                   value="${menuId}">

            <input type="hidden"
                   name="harga[]"
                   value="${harga}">

            <input type="hidden"
                   name="qty[]"
                   value="${qty}">

            <input type="hidden"
                   name="subtotal[]"
                   value="${subtotal}">
        </div>
    `;

    document.getElementById('detailInputs')
        .insertAdjacentHTML('beforeend', hidden);

    index++;
}

function hapusItem(id, subtotal){

    document.getElementById('row'+id).remove();
    document.getElementById('input'+id).remove();

    total -= subtotal;

    document.getElementById('grandTotal').innerHTML =
        total.toLocaleString('id-ID');

    document.getElementById('total_pesanan').value =
        total;
}