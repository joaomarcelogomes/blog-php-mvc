/**
 * classe responsável pela validação de formulários html
 */
class Form {

  /**
   * método responsável por validar se os campos estão preenchidos
   * @param {string} id
   * @param {array} fields
   */
  static validate(id, ...fields) {
    //variável contadora
    var i = 0;
    //iteração por todos os inputs da classe form-group
    $('.form-group > ' + fields.join(',')).each(function() {
      //caso algum dos inputs esteja vazio, aumenta o contador;
      if($(this).val() == "") {
        i++;
      }
     });
     //caso o contador seja maior que 0, ou seja, algum input esteja vazio, lança um alerta
     if(i > 0) {
       return alert("Preencha todos os campos antes de continuar");;
     }
     //caso o contador seja menor que 0, ou seja, nenhum input esteja vazio, envia um alerta de confirmação e o form
     alert("Registrado com sucesso!");
     return $(`#${id}`).submit();
  }

  /**
   * método responsável pela validação de senha;
   * @param {string} formId
   */
  static validatePassword(formId) {
    //novo array onde serão inseridas as senhas;
    var pass = [];
    //iteração pelos inputs de senha
    $('.form-group > input[type=password]').each(function() {
        //adição das senhas no array previamente criado;
        pass.push($(this).val());
     });
     //executa um reduce, onde, caso os valores sejam vazios, retorna 'empty', caso contrário retorna true ou false para coincidencia de senhas.
     const equals = pass.reduce((acc, x) => {
       if(acc == "" || x == "") {
         return 'empty';
       }
       return acc == x;
     });
     //caso equals seja true, retorna o método de validação padrão, caso não, lança um alerta.
     return equals ? this.validate(formId,'input') : alert("As senhas não coincidem");
  }

}
