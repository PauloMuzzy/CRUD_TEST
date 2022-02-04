$(() => {

    $('#dropdownMenuButton2').hide()
    $('#dropdownMenuButton3').hide()
    $('#dropdownMenuButton4').hide()
    $('.drop1').hide()
    $('.drop2').hide()
    $('.drop3').hide()
    $('.drop4').hide()

    // const checkLogin = () => {
    //     const userLoggedIn = localStorage.getItem('userLoggedIn')
    //     const userId = localStorage.getItem('userEmail')
    //     if (userLoggedIn) {
    //         const userAccess = getAccess(userId)

    //     } else {
    //         // window.location.href = "http://www.google.pt";
    //     }
    // }

    // const getAccess = (userId) => {
    //     $.ajax({
    //         type: "GET",
    //         url: 'controller.cgi?id=' + userId,
    //         success: (res) => {
    //             return userAccess
    //         }
    //     })
    // }

    // releasesAccess(1);

    // const releasesAccess = (userAccess) => {

    const access = 1;
    switch (access) {
        case 1:
            $('.dropdownMenuButton2').show()
            $('.dropdownMenuButton3').show()
            $('.dropdownMenuButton4').show()
            $('.drop1').show()
            $('.drop2').show()
            $('.drop3').show()
            $('.drop4').show()
            break
        case 2:
            $('.dropdownMenuButton2').show()
            $('.dropdownMenuButton3').show()
            $('.drop1').show()
            $('.drop2').show()
            break
        case 3:
            $('.dropdownMenuButton2').show()
            $('.dropdownMenuButton3').show()
            $('.drop1').show()
            $('.drop2').show()
            $('.drop3').show()
            break
        case 4:
            $('.dropdownMenuButton2').show()
            $('.dropdownMenuButton3').show()
            $('.drop1').show()
            $('.drop2').show()
            $('.drop3').show()
            $('.drop4').show()
            break
    }
    // }

})