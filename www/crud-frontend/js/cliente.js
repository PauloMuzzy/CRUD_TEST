$(function () {

    checkLocalStorage()

    async function onClickButtonUpdate() {
        const idBtnUpdate = $(this).attr('data-id')
        const response = await $.ajax({
            url: '/crud-backend/api/customer.php?id=' + idBtnUpdate,
            method: 'GET',
        })
        $('#nameCustomerModal').val(response[0].name)
        $('#birthDateCustomerModal').val(response[0].birth_date)
        $('#cpfCustomerModal').val(response[0].cpf)
        $('#documentCustomerModal').val(response[0].document)
        $('#telCustomerModal').val(response[0].phone)

        $('#btnUpdateCustomer').click(function (e) {
            e.preventDefault()
            console.log('teste')
            const id = response[0].id
            const name = document.getElementById('nameCustomerModal').value
            const birthDate = document.getElementById('birthDateCustomerModal').value
            const cpf = document.getElementById('cpfCustomerModal').value
            const doc = document.getElementById('documentCustomerModal').value
            const phone = document.getElementById('telCustomerModal').value

            const updateCustomer = async () => {
                const response = await $.ajax({
                    url: '/crud-backend/api/customer.php',
                    type: 'PUT',
                    data: JSON.stringify({
                        id: id,
                        name: name,
                        birthDate: birthDate,
                        cpf: cpf,
                        doc: doc,
                        phone: phone
                    }),
                    contentType: "application/json",
                    dataType: "json",
                })
                if (response == true) {
                    $('#toast-body-success').html('Cliente alterado com sucesso!')
                    $('#toastSuccess').toast('show')
                    setTimeout(() => { location.reload() }, 2000);
                } else {
                    $('#toast-body-error').html('OPS! Algo deu errado, tente novamente!')
                    $('#toastError').toast('show')
                    setTimeout(() => { location.reload() }, 2000);
                }
            }
            updateCustomer()
        })
    }

    async function onClickButtonDelete() {
        const idBtnUpdate = $(this).attr('data-id')
        const response = await $.ajax({
            url: '/crud-backend/api/customer.php?id=' + idBtnUpdate,
            method: 'GET',
        })
        $('#nameCustomerModalDelete').val(response[0].name)
        $('#cpfCustomerModalDelete').val(response[0].cpf)
        $('#btnDeleteCustomer').click(function () {
            const id = response[0].id
            const deleteCustomer = async () => {
                const response = await $.ajax({
                    url: '/crud-backend/api/customer.php',
                    type: 'DELETE',
                    data: JSON.stringify({
                        id: id
                    }),
                    contentType: "application/json",
                    dataType: "json",
                })
                if (response == true) {
                    $('#toast-body-success').html('Cliente apagado com sucesso!')
                    $('#toastSuccess').toast('show')
                    setTimeout(() => { location.reload() }, 2000);
                } else {
                    $('#toast-body-error').html('OPS! Algo deu errado, tente novamente!')
                    $('#toastError').toast('show')
                    setTimeout(() => { location.reload() }, 2000);
                }
            }
            deleteCustomer()
        })
    }

    const listCustomer = async () => {
        await $.ajax({
            url: '/crud-backend/api/customer.php',
            method: 'GET',
        }).then(response => renderHtml(response))
    }
    listCustomer()

    const renderHtml = (response) => {
        const trListCustomer = response.map((cliente) => {
            const { id, name, birth_date, cpf, document, phone } = cliente;

            return (`
                <tr>
                    <td>${name}</td>
                    <td>${birth_date}</td>
                    <td>${cpf}</td>
                    <td>${document}</td>
                    <td>${phone}</td>
                    <td><button type="button" class="btn btn-warning updadeButton" data-id="${id}" data-bs-toggle="modal" data-bs-target="#updateCustomerModal">EDITAR</button></td>
                    <td><button type="button" class="btn btn-danger deleteButton" data-id="${id}" data-bs-toggle="modal" data-bs-target="#deleteCustomerModal">APAGAR</button></td>
                </tr>
            `)
        })
        $("#tbodyCustomers").append(trListCustomer)
        $('.updadeButton').click(onClickButtonUpdate)
        $('.deleteButton').click(onClickButtonDelete)
    }

    $('#btnRegisterCustomer').click(async function (e) {
        e.preventDefault()

        const nameCustomer = document.getElementById('nameRegisterCustomer').value
        const birthDateCustomer = document.getElementById('birthDateRegisterCustomer').value
        const cpfCustomer = document.getElementById('cpfRegisterCustomer').value
        const documentCustomer = document.getElementById('documentRegisterCustomer').value
        const telCustomer = document.getElementById('telRegisterCustomer').value
        const streetAddressCustomer = document.getElementById('streetRegisterCustomer').value
        const numberAddressCustomer = document.getElementById('numberRegisterCustomer').value
        const districtAddressCustomer = document.getElementById('districtRegisterCustomer').value
        const zipCodeAddressCustomer = document.getElementById('zipCodeRegisterCustomer').value
        const cityAddressCustomer = document.getElementById('cityRegisterCustomer').value
        const stateAddressCustomer = document.getElementById('stateRegisterCustomer').value

        const res = await $.ajax({
            url: '/crud-backend/api/customer.php',
            type: 'POST',
            data: JSON.stringify({
                name: nameCustomer,
                birthDate: birthDateCustomer,
                cpf: cpfCustomer,
                doc: documentCustomer,
                phone: telCustomer,
                address: {
                    street: streetAddressCustomer,
                    number: numberAddressCustomer,
                    district: districtAddressCustomer,
                    zipCode: zipCodeAddressCustomer,
                    city: cityAddressCustomer,
                    state: stateAddressCustomer
                }
            }),
            contentType: "application/json",
            dataType: "json",
        })
        if (res == true) {
            $('#toast-body-success').html('Cliente cadastrado com sucesso!')
            $('#toastSuccess').toast('show')
            setTimeout(() => { location.reload() }, 2000);
        } else {
            $('#toast-body-error').html('OPS! Algo deu errado, tente novamente!')
            $('#toastError').toast('show')
            setTimeout(() => { location.reload() }, 2000);
        }
    })
})