let productList = []
let productListFooter = {amount: 0, price: 0, tax: 0, total_tax: 0, total_price: 0}

$("document").ready(() => {
    listProductsList()
    listProductsOptions()
})

const getProductList = async () =>
{
    const request = { method: 'GET'}
    return await (await fetch("http://localhost/product/list", request)).json()
}

const listProductsOptions = async () =>
{
    $('#products').DataTable().clear().destroy()

    const products = await getProductList()
    const DataTable = $("#products").DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": false,
        "autoWidth": false,
        "responsive": true,
        "language": {"url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"}
    })

    products.data.map(product => {
        const option = 
        `
            <div>${product.name}</div><br>
            <div><button class="btn btn-default" onclick="increaseProductToList(${product.id})"><i class="fas fa-plus"></i></button>&nbsp;&nbsp;&nbsp;<button class="btn btn-default" onclick="decreaseProductToList(${product.id})"><i class="fas fa-minus"></i></button></div>
        `

        DataTable.row.add([option])
    })
}

const listProductsList = async () =>
{
    $('#order').DataTable().clear().destroy()

    const DataTable = $("#order").DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": false,
        "autoWidth": false,
        "responsive": true,
        "language": {"url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"}
    })

    productList.map(product => {
        DataTable.row.add([product.name, product.type, product.amount, product.price, product.tax, product.total_tax, product.total_price])
    })

    $("#orderAmount").html(`Quantidade: <b>${productListFooter.amount}<b/>`)
    $("#orderPrice").html(`Preço: <b>R$ ${productListFooter.price}<b/>`)
    $("#orderTax").html(`Imposto: <b>R$ ${productListFooter.tax}<b/>`)
    $("#orderTotalTax").html(`Total em Impostos: <b>R$ ${productListFooter.total_tax}<b/>`)
    $("#orderTotalPrice").html(`Total: <b>R$ ${productListFooter.total_price}<b/>`)
}

const increaseProductToList = async (productID) =>
{
    productIndexOnList = productList.findIndex((product) => product.id == productID)

    if(productIndexOnList < 0)
    {
        const productInfo = (await getProductInfo(productID))

        if(productInfo.status == 200)
        {
            productInfo.data[0]["amount"] = 1
            productInfo.data[0]["tax"] = Number(productInfo.data[0].price * (productInfo.data[0].tax / 100)).toFixed(2)
            productInfo.data[0]["total_price"] = Number(productInfo.data[0].price * productInfo.data[0].amount).toFixed(2)
            productInfo.data[0]["total_tax"] = Number(productInfo.data[0].tax * productInfo.data[0].amount).toFixed(2)

            productList.push(productInfo.data[0])
        }
        else
        {
            Swal.fire('Houve um problema ao buscar os dados do produto!', '', 'warning')
        }
    }
    else
    {
        productList[productIndexOnList].amount += 1
        productList[productIndexOnList].total_price = Number(productList[productIndexOnList].price * productList[productIndexOnList].amount).toFixed(2)
        productList[productIndexOnList].total_tax = Number(productList[productIndexOnList].tax * productList[productIndexOnList].amount).toFixed(2)
    }

    updateProductListFooter()
    listProductsList()
}

const decreaseProductToList = (productID) =>
{
    productIndexOnList = productList.findIndex((product) => product.id == productID)

    if(productIndexOnList >= 0)
    {
        if(productList[productIndexOnList].amount == 1)
        {
            productList.splice(productIndexOnList, 1)
        }
        else
        {
            productList[productIndexOnList].amount -= 1
            productList[productIndexOnList].total_price = Number(productList[productIndexOnList].price * productList[productIndexOnList].amount).toFixed(2)
            productList[productIndexOnList].total_tax = Number(productList[productIndexOnList].tax * productList[productIndexOnList].amount).toFixed(2)
        }
    }

    updateProductListFooter()
    listProductsList()
}

const updateProductListFooter = () =>
{
    result = {amount: 0, price: 0, tax: 0, total_tax: 0, total_price: 0}

    productList.map(product => {
        result.amount += Number(product.amount)
        result.price += Number(product.price)
        result.tax += Number(product.tax)
        result.total_tax += Number(product.total_tax)
        result.total_price += Number(product.total_price)
    })

    productListFooter = result
} 

const getProductInfo = async (id) =>
{
    const request = { method: 'POST', body: JSON.stringify({id: id})}
    return await (await fetch("http://localhost/find/product", request)).json()
}

const saveOrder = async () =>
{
    const request = { method: 'POST', body: JSON.stringify({products: productList})}
    const response = await (await fetch("http://localhost/order", request)).json()

    if(response.status == 201)
    {
        Swal.fire('Pedido cadastrado com sucesso!', '', 'success')
        productList = []
        updateProductListFooter()
        listProductsList()
    }
    else
    {
        Swal.fire('Houve um problema ao cadastrar o pedido', '', 'warning')
    }
}