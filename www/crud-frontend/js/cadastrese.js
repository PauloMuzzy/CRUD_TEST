$(function () {

    $('#bntFormRegister').click(function (e) {
        e.preventDefault()
        const objectDataPost = makeObjectDataPost()
        const result = makePost(objectDataPost)
        makeAlert(result)
    })

    const makeObjectDataPost = () => {
        const name = document.getElementById('name').value
        const email = document.getElementById('email').value
        const password = document.getElementById('password').value
        const objectDataPost = {
            name: name,
            email: email,
            password: password
        }
        return objectDataPost
    }

    const makePost = async (objectDataPost) => {
        let result
        try {
            result = await $.ajax({
                url: '../../../crud-backend/api/user.php',
                type: 'POST',
                data: JSON.stringify(objectDataPost),
                contentType: "application/json",
                dataType: "json",
            });
            return result
        } catch (error) {
            console.log(error);
        }
    }

    const makeAlert = (result) => {
        result.then(function (result) {
            if (result == true) {
                $('#toastSuccess').toast('show')
                setTimeout(() => { window.location.href = 'home.html' }, 3000);
            } else {
                $('#toastError').toast('show')
            }
        });
    }

})