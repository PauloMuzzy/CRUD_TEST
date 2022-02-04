$(function () {
    var form = document.querySelector('form');
    form.addEventListener('submit', function (event) {
        event.preventDefault();
        const objectDataPost = makeObjectDataPost()
        $.ajax({
            type: "POST",
            url: '../../crud-backend/api/user.php',
            data: JSON.stringify(objectDataPost),
            contentType: "application/json",
            success: function (res) {
                console.log(res)
            }
        })
    });
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

