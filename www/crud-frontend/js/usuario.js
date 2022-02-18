$(function () {

    checkLocalStorage()

    async function onClickButtonUpdateUserModal(e) {
        e.preventDefault()
        const id = document.getElementById('idUpdateModal').value
        const name = document.getElementById('nameUpdateModal').value
        const email = document.getElementById('emailUpdateModal').value
        const access = document.getElementById('accessUpdateModal').value

        const response = await $.ajax({
            url: '/crud-backend/api/user.php',
            method: 'PUT',
            data: JSON.stringify({
                id: id,
                name: name,
                email: email,
                access: access
            }),
            contentType: "application/json",
            dataType: "json",
        })
        console.log(response)
    }

    async function onClickButtonDeleteUser() {
        const dataIdBtn = $(this).attr('data-id')
        const response = await $.ajax({
            url: '/crud-backend/api/user.php',
            method: 'DELETE',
            data: JSON.stringify({
                id: dataIdBtn
            }),
            contentType: "application/json",
            dataType: "json",
        })
        console.log(response)
    }

    async function onClickButtonUpdateUser() {
        const idBtnUpdate = $(this).attr('data-id')
        const response = await $.ajax({
            url: '/crud-backend/api/user.php?id=' + idBtnUpdate,
            method: 'GET',
            contentType: "application/json",
            dataType: "json",
        })
        $('#idUpdateModal').val(response[0].id)
        $('#nameUpdateModal').val(response[0].name)
        $('#emailUpdateModal').val(response[0].email)
        $('#accessUpdateModal').val(response[0].access)
        $('#btnupdateUserModal').click(onClickButtonUpdateUserModal)
    }

    async function listUser() {
        const response = await $.ajax({
            url: '/crud-backend/api/user.php',
            method: 'GET',
            contentType: "application/json",
            dataType: "json",
        })
        const trListUser = response.map((user) => {
            const { id, name, email, access } = user
            return (`
                <tr>
                    <td>${name}</td>
                    <td>${email}</td>
                    <td>${access}</td>
                    <td>
                        <button data-id="${id}" class="btn btn-warning updateUser" data-bs-toggle="modal" data-bs-target="#listUserModal">EDITAR</button>
                        <button data-id="${id}" class="btn btn-danger deleteUser">APAGAR</button>                    
                    </td>
                </tr>
            `)
        })
        $("#trListUser").append(trListUser)
        $('.updateUser').click(onClickButtonUpdateUser)
        $('.deleteUser').click(onClickButtonDeleteUser)
    }

    listUser()
})


