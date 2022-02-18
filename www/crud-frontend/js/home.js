$(function () {

  $('#makeALogin').show()
  $('#salutation').hide()

  checkStatusHome = () => {
    const userStatus = localStorage.getItem('status')
    const userAccess = localStorage.getItem('access')

    if (userStatus == '1' && userAccess == '2') {
      const userName = localStorage.getItem('name')
      $("#userNameSalutation").html(userName)
      $('#makeALogin').hide()
      $('#salutation').show()
      $('.linkMenuCustomer').show()
      $('.linkMenuAddress').show()
    } else if (userStatus == '1' && userAccess == '1') {
      const userName = localStorage.getItem('name')
      $("#userNameSalutation").html(userName)
      $('#makeALogin').hide()
      $('#salutation').show()
      $('.linkMenuHome').show()

    } else if (userStatus == '1' && userAccess == 'master') {
      const userName = localStorage.getItem('name')
      $("#userNameSalutation").html(userName)
      $('#makeALogin').hide()
      $('#salutation').show()
      $('.linkMenuUser').show()
      $('.linkMenuCustomer').show()
      $('.linkMenuAddress').show()
    }
  }
  checkStatusHome()

  $('#btnFormLogin').click(async function (e) {
    e.preventDefault()
    const email = document.getElementById('emailLogin').value
    const password = document.getElementById('passwordLogin').value
    const res = await $.ajax({
      url: '/crud-backend/api/user.php',
      type: 'POST',
      data: JSON.stringify({
        email: email,
        password: password
      }),
      contentType: "application/json",
      dataType: "json",
    })
    if (res.valid) {
      const { access, name } = res
      $('#toast-body-success').html('Usuário logado!... Bem-Vimdo! =)')
      $('#toastSuccess').toast('show')
      localStorage.setItem('access', access)
      localStorage.setItem('name', name)
      localStorage.setItem('status', '1')
      setTimeout(() => { window.location.href = 'cliente.html' }, 2000);
    } else {
      $('#toast-body-error').html('OPS! Usuário ou senha inválidos.')
      $('#toastError').toast('show')
    }
  })

  checkLocalStorage = () => {
    const userStatus = localStorage.getItem('status')
    const userAccess = localStorage.getItem('access')

    if (userStatus == '1' && userAccess == '2') {
      const userName = localStorage.getItem('name')
      $("#userNameSalutation").html(userName)
      $('#makeALogin').hide()
      $('#salutation').show()
      $('.linkMenuCustomer').show()
      $('.linkMenuAddress').show()
    } else if (userStatus == '1' && userAccess == '1') {
      const userName = localStorage.getItem('name')
      $("#userNameSalutation").html(userName)
      $('#makeALogin').hide()
      $('#salutation').show()
      $('.linkMenuHome').show()
      $('#toast-body-error').html('OPS! Você não tem acesso!')
      $('#toastError').toast('show')
      $('main').hide()
      setTimeout(() => { window.location.href = 'home.html' }, 2000);

    } else if (userStatus == '1' && userAccess == 'master') {
      const userName = localStorage.getItem('name')
      $("#userNameSalutation").html(userName)
      $('#makeALogin').hide()
      $('#salutation').show()
      $('.linkMenuUser').show()
      $('.linkMenuCustomer').show()
      $('.linkMenuAddress').show()

    } else {
      window.location.href = 'home.html'
    }
  }

  $('#exitButton').click(() => {
    localStorage.clear();
    $('#toast-body-success').html('Usuário deslogado com sucesso!')
    $('#toastSuccess').toast('show')
    setTimeout(() => { location.reload() }, 2000);
  })


  //Mascaras
  $('.maskCpf').mask('999.999.999-99');

  //Mascara RG
  var mascaraRg = {
    'translation': {
      A: {
        pattern: /[A-Za-z0-9]/
      }
    }
  };
  $('.maskDocument').mask('99.999.999-A' || '99.999.999-99', mascaraRg);
  $('.maskPhone').mask('(99)99999-9999');
  $('.maskZipCode').mask('99999-999');
})