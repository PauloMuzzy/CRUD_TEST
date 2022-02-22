<?php

function validateData($fild, $value)
{
  if ($fild == 'name') {
    if (!isset($value)) {
      throw new Exception('Nome não informado!');
    }
    return addslashes($value);
  }

  if ($fild == 'id') {
    if (!isset($value)) {
      throw new Exception('ID não informado!');
    }
    return addslashes($value);
  }

  if ($fild == 'birthDate') {
    if (!isset($value)) {
      throw new Exception('Data de Nascimento não informado!');
    } elseif (!preg_match("/^[0-9]{4}-[0-1][0-9]-[0-3][0-9]$/", $value)) {
      throw new Exception('Data de Nascimento inválido!');
    }
    return addslashes($value);
  }

  if ($fild == 'cpf') {
    if (!isset($value)) {
      throw new Exception('CPF não informado!');
    }
    $value = preg_replace('/[^0-9]/is', '', $value);
    if (strlen($value) != 11) {
      throw new Exception('CPF inválido!');
    }
    if (preg_match('/(\d)\1{10}/', $value)) {
      throw new Exception('CPF inválido!');
    }
    for ($t = 9; $t < 11; $t++) {
      for ($d = 0, $c = 0; $c < $t; $c++) {
        $d += $value[$c] * (($t + 1) - $c);
      }
      $d = ((10 * $d) % 11) % 10;
      if ($value[$c] != $d) {
        throw new Exception('CPF inválido!');
      }
    }
    return addslashes($value);
  }

  if ($fild == 'doc') {
    if (!isset($value)) {
      throw new Exception('RG não informado!');
    } elseif (preg_match("/^\d{1,2}).?(\d{3}).?(\d{3})-?(\d{1}|X|x$/", $value)) {
      throw new Exception('RG inválido!');
    }
    return addslashes($value);
  }

  if ($fild == 'phone') {
    if (!isset($value)) {
      throw new Exception('Telefone não informado!');
    } elseif (!preg_match("/^\([0-9]{2}\)[0-9]{5}-[0-9]{4}$/", $value)) {
      throw new Exception('Telefone inválido!');
    }
    return addslashes($value);
  }

  if ($fild == 'street') {
    if (!isset($value)) {
      throw new Exception('Rua não informado!');
    }
    return addslashes($value);
  }

  if ($fild == 'number') {
    if (!isset($value)) {
      throw new Exception('Número não informado!');
    }
    return addslashes($value);
  }

  if ($fild == 'district') {
    if (!isset($value)) {
      throw new Exception('Bairro não informado!');
    }
    return addslashes($value);
  }

  if ($fild == 'zipCode') {
    if (!isset($value)) {
      throw new Exception('CEP não informado!');
    } elseif (!preg_match("/^[0-9]{5}-[0-9]{3}$/", $value)) {
      throw new Exception('CEP inválido!');
    }
    return addslashes($value);
  }

  if ($fild == 'city') {
    if (!isset($value)) {
      throw new Exception('Cidade não informado!');
    }
    return addslashes($value);
  }

  if ($fild == 'state') {
    if (!isset($value)) {
      throw new Exception('Estado não informado!');
    }
    return addslashes($value);
  }

  if ($fild == 'email') {
    if (!isset($value)) {
      throw new Exception('E-mail não informado!');
    } elseif (!preg_match("/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/", $value)) {
      throw new Exception('E-mail inválido!');
    }
    return addslashes($value);
  }
}
