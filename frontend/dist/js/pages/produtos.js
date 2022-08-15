$("document").ready(() => {
    listProducts()

    $("#new_product_price").inputmask({alias: 'currency', prefix: "R$ ", radixPoint: '.', groupSeparator: ',', numericInput: true})
    $("#edit_product_price").inputmask({alias: 'currency', prefix: "R$ ", radixPoint: '.', groupSeparator: ',', numericInput: true})

    $("#new_product_btn").click(() => openNewProductModal())
    $("#new_product_modal_save").click(() => saveNewProduct())
    $("#edit_product_modal_save").click(() => editNewProduct())
    $("#new_product_modal_cancel").click(() => cleanProductModalField())
    $("#edit_product_modal_cancel").click(() => cleanProductModalField())
})

const cleanProductModalField = async () =>
{
    $("#new_product_name").val("")
    $("#new_product_price").val("")
    $("#new_product_type").val("")
    $("#edit_product_name").val("")
    $("#edit_product_price").val("")
    $("#edit_product_type").val("")
}

const listProducts = async () =>
{
    $('#product_list').DataTable().clear().destroy()

    const products = await getProductList()
    const DataTable = $("#product_list").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false, "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "language": {"url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"}
    })

    DataTable.buttons().container().appendTo('#product_list_wrapper .col-md-6:eq(0)')

    products.data.map(product => {
        const button = 
        `<div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="product_actions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Ações</button>
            <div class="dropdown-menu" aria-labelledby="product_actions">
                <a class="dropdown-item edit_product_btn btn" onclick="openEditProductModal(${product.id})">Editar</a>
                <a class="dropdown-item delete_product_btn btn" onclick="deleteProduct(${product.id})">Excluir</a>
            </div>
        </div>`

        DataTable.row.add([product.name, product.type, `R$ ${product.price}`, `${product.tax}%`, button])
    })
}

const openNewProductModal = async () =>
{
    const options = []
    const typeList = await getTypeList()

    if(typeList.status != 200 || typeList.data.length < 1)
        return Swal.fire('É necessário ter um tipo cadastrado para poder cadastrar um produto', '', 'warning')

    typeList.data.map((type, index) => {
        if(index == 0)
            options.push({id: type.id, text: type.name, selected: true})
        else
            options.push({id: type.id, text: type.name, selected: false})
    })

    $('.select2bs4').select2({theme: 'bootstrap4', data: options})
    $("#new_product_modal").modal("show")
}

const saveNewProduct = async () =>
{
    Swal.showLoading()

    const request = 
    { 
        method: 'POST',
        body: JSON.stringify({
            "name": $("#new_product_name").val(),
            "type": Number($("#new_product_type").val()),
            "price": Number($("#new_product_price").val().replace("R$ ", "").replace(",", ""))
        })
    }

    const response =  await (await fetch("http://localhost/product", request)).json()

    if(response.status == 201)
    {
        listProducts()
        $("#new_product_modal").modal("hide")
        cleanProductModalField()
        Swal.fire('Produto cadastrado com sucesso!', '', 'success')
    }
    else
    {
        Swal.fire('Houve um problema ao cadastrar o produto', '', 'warning')
    }
}

const openEditProductModal = async (productID) =>
{
    const options = []
    const typeList = await getTypeList()
    const product = (await getProductInfo(productID)).data[0]

    if(typeList.status != 200 || typeList.data.length < 1)
        return Swal.fire('É necessário ter um tipo cadastrado para poder editar um produto', '', 'warning')

    typeList.data.map((type, index) => {
        if(type.id == product.type || index == 0)
            options.push({id: type.id, text: type.name, selected: true})
        else
            options.push({id: type.id, text: type.name, selected: false})
    })

    $("#edit_product_name").val(product.name)
    $("#edit_product_price").val(product.price)
    $("#edit_product_modal_save").attr("data-product", productID)

    $('.select2bs4').select2({theme: 'bootstrap4', data: options})
    $("#edit_product_modal").modal("show")
}

const editNewProduct = async () =>
{
    Swal.showLoading()

    const request = 
    { 
        method: 'PUT',
        body: JSON.stringify({
            "id": Number($("#edit_product_modal_save").data().product),
            "name": $("#edit_product_name").val(),
            "type": Number($("#edit_product_type").val()),
            "price": Number($("#edit_product_price").val().replace("R$ ", "").replace(",", ""))
        })
    }

    const response = await(await fetch("http://localhost/product", request)).json()

    if(response.status == 200)
    {
        listProducts()
        $("#edit_product_modal").modal("hide")
        cleanProductModalField()
        Swal.fire('Produto alterar com sucesso!', '', 'success')
    }
    else
    {
        Swal.fire('Houve um problema ao alterar o produto', '', 'warning')
    }
}

const deleteProduct = async (product) =>
{
    Swal.fire({
        title: 'Tem certeza que deseja excluir o produto?',
        showConfirmButton: false,
        icon: 'warning',
        showDenyButton: true,
        showCancelButton: true,
        denyButtonText: `Sim, excluir!`,
        cancelButtonText: `Não, cancelar!`,
      }).then(async (result) => {
        if (result.isDenied)
        {
            const request = 
            { 
                method: 'DELETE',
                body: JSON.stringify({"id": product})
            }
        
            const response =  await (await fetch("http://localhost/product", request)).json()

            if(response.status == 200)
            {
                listProducts()
                Swal.fire('Produto excluído com sucesso!', '', 'success')
            }
        }
      })
}

const getProductList = async () =>
{
    const request = { method: 'GET'}
    return await (await fetch("http://localhost/product/list", request)).json()
}

const getProductInfo = async (id) =>
{
    const request = { method: 'POST', body: JSON.stringify({id: id})}
    return await (await fetch("http://localhost/find/product", request)).json()
}

const getTypeList = async () =>
{
    const request = { method: 'GET'}
    return await (await fetch("http://localhost/type/list", request)).json()
}