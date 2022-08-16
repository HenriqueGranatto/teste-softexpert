$("document").ready(() => {
    listOrder()
})

const listOrder = async () =>
{
    const Order = await getOrderList()

    $('#order_list').DataTable().clear().destroy()

    const DataTable = $("#order_list").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false, "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "language": {"url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"}
    })

    DataTable.buttons().container().appendTo('#order_list_wrapper .col-md-6:eq(0)')

    Order.data.map(order => {
        const button = 
        `<div class="dropdown">
            <button class="btn btn-secondary" type="button" onclick="openOrderProductList(${order.id})">Produtos</button>
        </div>`

        DataTable.row.add([(new Date(order.created)).toLocaleString(), order.amount, `R$ ${order.total_price}`, `R$ ${order.total_tax}`, button])
    })
}

const openOrderProductList = async (orderID) =>
{
    const orderProducts = (await getOrderInfo(orderID)).data.products

    $('#order_products_list').DataTable().clear().destroy()

    const DataTable = $("#order_products_list").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false, "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "language": {"url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"}
    })

    DataTable.buttons().container().appendTo('#order_modal_wrapper .col-md-6:eq(0)')

    orderProducts.map(product => {
        DataTable.row.add([product.name, product.type, product.amount, `${product.tax}%`, `R$ ${product.price}`, `R$ ${product.total_price}`, `R$ ${product.total_tax}`])
    })

    $("#order_modal").modal("show")
}

const getOrderList = async () =>
{
    const request = { method: 'GET'}
    return await (await fetch("http://ec2-15-228-254-161.sa-east-1.compute.amazonaws.com/order/list", request)).json()
}

const getOrderInfo = async (id) =>
{
    const request = { method: 'POST', body: JSON.stringify({id: id})}
    return await (await fetch("http://ec2-15-228-254-161.sa-east-1.compute.amazonaws.com/find/order", request)).json()
}