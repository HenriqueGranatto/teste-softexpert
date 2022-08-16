$("document").ready(() => {
    listTypes()

    $("#new_type_tax").inputmask({alias: 'currency', sulfix: "% ", radixPoint: '.', groupSeparator: ',', numericInput: true})
    $("#edit_type_tax").inputmask({alias: 'currency', sulfix: "%", radixPoint: '.', groupSeparator: ',', numericInput: true})

    $("#new_type_btn").click(() => $("#new_type_modal").modal("show"))
    $("#new_type_modal_save").click(() => saveNewtype())
    $("#edit_type_modal_save").click(() => editNewtype())
    $("#new_type_modal_cancel").click(() => cleanTypeModalField())
    $("#edit_type_modal_cancel").click(() => cleanTypeModalField())
})

const cleanTypeModalField = async () =>
{
    $("#new_type_name").val("")
    $("#new_type_tax").val("")
    $("#edit_type_name").val("")
    $("#edit_type_tax").val("")
}

const listTypes = async () =>
{
    $('#type_list').DataTable().clear().destroy()

    const types = await getTypeList()
    const DataTable = $("#type_list").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false, "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "language": {"url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"}
    })

    DataTable.buttons().container().appendTo('#type_list_wrapper .col-md-6:eq(0)')

    types.data.map(type => {
        const button = 
        `<div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="type_actions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Ações</button>
            <div class="dropdown-menu" aria-labelledby="type_actions">
                <a class="dropdown-item edit_type_btn btn" onclick="openEditTypeModal(${type.id})">Editar</a>
                <a class="dropdown-item delete_type_btn btn" onclick="deleteType(${type.id})">Excluir</a>
            </div>
        </div>`

        DataTable.row.add([type.name, `${type.tax}%`, button])
    })
}

const saveNewtype = async () =>
{
    Swal.showLoading()

    const request = 
    { 
        method: 'POST',
        body: JSON.stringify({
            "name": $("#new_type_name").val(),
            "tax": Number($("#new_type_tax").val().replace("%", "").replace(",", ""))
        })
    }

    const response =  await (await fetch("http://ec2-15-228-254-161.sa-east-1.compute.amazonaws.com/type", request)).json()

    if(response.status == 201)
    {
        listTypes()
        $("#new_type_modal").modal("hide")
        cleanTypeModalField()
        Swal.fire('Tipo cadastrado com sucesso!', '', 'success')
    }
    else
    {
        Swal.fire('Houve um problema ao cadastrar o tipo de produto', '', 'warning')
    }
}

const openEditTypeModal = async (typeID) =>
{
    const type = (await getTypeInfo(typeID)).data[0]

    $("#edit_type_name").val(type.name)
    $("#edit_type_tax").val(type.tax)
    $("#edit_type_modal_save").attr("data-type", typeID)

    $("#edit_type_modal").modal("show")
}

const editNewtype = async () =>
{
    Swal.showLoading()

    const request = 
    { 
        method: 'PUT',
        body: JSON.stringify({
            "id": Number($("#edit_type_modal_save").data().type),
            "name": $("#edit_type_name").val(),
            "tax": Number($("#edit_type_tax").val().replace("%", "").replace(",", ""))
        })
    }

    const response = await(await fetch("http://ec2-15-228-254-161.sa-east-1.compute.amazonaws.com/type", request)).json()

    if(response.status == 200)
    {
        listTypes()
        $("#edit_type_modal").modal("hide")
        cleanTypeModalField()
        Swal.fire('Tipo alterar com sucesso!', '', 'success')
    }
    else
    {
        Swal.fire('Houve um problema ao alterar o tipo', '', 'warning')
    }
}

const deleteType = async (type) =>
{
    Swal.fire({
        title: 'Tem certeza que deseja excluir o tipo?',
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
                body: JSON.stringify({"id": type})
            }
        
            const response =  await (await fetch("http://ec2-15-228-254-161.sa-east-1.compute.amazonaws.com/type", request)).json()

            if(response.status == 200)
            {
                listTypes()
                Swal.fire('Tipo excluído com sucesso!', '', 'success')
            }
        }
      })
}

const getTypeList = async () =>
{
    const request = { method: 'GET'}
    return await (await fetch("http://ec2-15-228-254-161.sa-east-1.compute.amazonaws.com/type/list", request)).json()
}

const getTypeInfo = async (id) =>
{
    const request = { method: 'POST', body: JSON.stringify({id: id})}
    return await (await fetch("http://ec2-15-228-254-161.sa-east-1.compute.amazonaws.com/find/type", request)).json()
}