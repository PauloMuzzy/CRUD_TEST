$(function () {
    checkLocalStorage()
    function onClickButtonRegisterAddress() {
        var dataIdBtn = $(this).attr('data-id')
        $('#btnRegisterAddressModal').click(async function () {
            const street = document.getElementById('streetRegisterModal').value
            const number = document.getElementById('numberRegisterModal').value
            const district = document.getElementById('districtRegisterModal').value
            const zipCode = document.getElementById('zipCodeRegisterModal').value
            const city = document.getElementById('cityRegisterModal').value
            const state = document.getElementById('stateRegisterModal').value
            const response = await $.ajax({
                url: '/crud-backend/api/address.php',
                method: 'POST',
                data: JSON.stringify({
                    idCustomer: dataIdBtn,
                    street: street,
                    number: number,
                    district: district,
                    zipCode: zipCode,
                    city: city,
                    state: state
                }),
                contentType: "application/json",
                dataType: "json",
            })
            if (response == true) {
                $('#toast-body-success').html('Endereço cadastrado com sucesso!')
                $('#toastSuccess').toast('show')
                setTimeout(() => { location.reload() }, 2000);
            } else {
                $('#toast-body-error').html('OPS! Algo deu errado, tente novamente!')
                $('#toastError').toast('show')
                setTimeout(() => { location.reload() }, 2000);
            }
        })
    }

    async function onClickButtonUpdateAddress() {
        const dataIdBtn = $(this).attr('data-id');
        const response = await $.ajax({
            url: '/crud-backend/api/address.php?id=' + dataIdBtn,
            method: 'GET',
            contentType: "application/json",
            dataType: "json",
        })
        $('#idUpdateModal').val(response[0].id)
        $('#streetUpdateModal').val(response[0].street)
        $('#numberUpdateModal').val(response[0].number)
        $('#districtUpdateModal').val(response[0].district)
        $('#zipCodeUpdateModal').val(response[0].zip_code)
        $('#cityUpdateModal').val(response[0].city)
        $('#stateUpdateModal').val(response[0].state)

        $('#btnUpdateAddressModal').click(async function () {
            const id = document.getElementById('idUpdateModal').value
            const street = document.getElementById('streetUpdateModal').value
            const number = document.getElementById('numberUpdateModal').value
            const district = document.getElementById('districtUpdateModal').value
            const zipCode = document.getElementById('zipCodeUpdateModal').value
            const city = document.getElementById('cityUpdateModal').value
            const state = document.getElementById('stateUpdateModal').value

            const response = await $.ajax({
                url: '/crud-backend/api/address.php',
                method: 'PUT',
                data: JSON.stringify({
                    id: id,
                    street: street,
                    number: number,
                    district: district,
                    zipCode: zipCode,
                    city: city,
                    state: state
                }),
                contentType: "application/json",
                dataType: "json",
            })
            if (response == true) {
                $('#toast-body-success').html('Endereço alterado com sucesso!')
                $('#toastSuccess').toast('show')
                setTimeout(() => { location.reload() }, 2000);
            } else {
                $('#toast-body-error').html('OPS! Algo deu errado, tente novamente!')
                $('#toastError').toast('show')
                setTimeout(() => { location.reload() }, 2000);
            }
        })
    }

    async function onClickButtonDeleteAddress() {
        const dataIdBtn = $(this).attr('data-id')
        const response = await $.ajax({
            url: '/crud-backend/api/address.php',
            type: 'DELETE',
            data: JSON.stringify({
                id: dataIdBtn
            }),
            contentType: "application/json",
            dataType: "json",
        })
        if (response == true) {
            $('#toast-body-success').html('Endereço apagado com sucesso!')
            $('#toastSuccess').toast('show')
            setTimeout(() => { location.reload() }, 2000);
        } else {
            $('#toast-body-error').html('OPS! Algo deu errado, tente novamente!')
            $('#toastError').toast('show')
            setTimeout(() => { location.reload() }, 2000);
        }
    }

    async function onClickButtonListAddress() {
        const idBtnUpdate = $(this).attr('data-id')
        const response = await $.ajax({
            url: '/crud-backend/api/address.php?idCustomer=' + idBtnUpdate,
            method: 'GET',
            contentType: "application/json",
            dataType: "json",
        })
        const trListAddress = response.map((address) => {
            const { id, street, number, district, zip_code, city, state } = address;
            return (`
                <tr>
                    <th class="thAddress" scope="col">${street}</th>
                    <th class="thAddress" scope="col">${number}</th>
                    <th class="thAddress" scope="col">${district}</th>
                    <th class="thAddress" scope="col">${zip_code}</th>
                    <th class="thAddress" scope="col">${city}</th>
                    <th class="thAddress" scope="col">${state}</th>
                    <td><button data-id="${id}" class="btn btn-warning addressUpdate">EDITAR</button></td>
                    <td><button data-id="${id}" class="btn btn-danger addressDelete">APAGAR</button></td>
                </tr>
            `)
        })
        $("#trListAddress tr").remove()
        $("#trListAddress").append(trListAddress)
        $('#streetRegisterCustomer').val('')
        $('#numberRegisterCustomer').val('')
        $('#districtRegisterCustomer').val('')
        $('#zipCodeRegisterCustomer').val('')
        $('#cityRegisterCustomer').val('')
        $('#stateRegisterCustomer').val('')
        $('.addressUpdate').click(onClickButtonUpdateAddress)
        $('.addressDelete').click(onClickButtonDeleteAddress)
    }

    async function listCustomer() {
        const response = await $.ajax({
            url: '/crud-backend/api/customer.php',
            method: 'GET',
            contentType: "application/json",
            dataType: "json",
        })
        const trListCustomer = response.map((customer) => {
            const { id, name } = customer
            return (`
                <tr>
                    <td>${name}</td>
                    <td><button data-id="${id}" class="btn btn-warning address" data-bs-toggle="modal" data-bs-target="#listAddressModal">ABRIR</button></td>
                    <td><button data-id="${id}" class="btn btn-primary registerAddress" data-bs-toggle="modal" data-bs-target="#registerAddressModal">CADASTRAR</button></td>
                </tr>
            `)
        })
        $("#trListCustomer").append(trListCustomer)
        $('.address').click(onClickButtonListAddress)
        $('.registerAddress').click(onClickButtonRegisterAddress)
    }
    listCustomer()
})