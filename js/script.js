

var button = document.querySelector('button');

    // Abrir o modal ao clicar no botão
    button.addEventListener('click', function() {
      var cost = document.getElementById("result").getAttribute('name');
      var productsCheckedArray = new Array();
      var allProductsChecked = document.querySelectorAll('input[type="checkbox"]:checked');

      for(i=0; i < allProductsChecked.length;i++){
        productsCheckedArray.push(allProductsChecked[i].getAttribute('id'));
      }

      // inicia a instância do checkout
      var checkout = new PagarMeCheckout.Checkout({
        encryption_key: 'ek_test_SzGMCxdZVHg7CMdwoT4buFaQIE4gtb',
        success: function(data) {
          console.log(data);

          //envia todos os dados necessários para o servidor via ajax
          var allItemsInformation = [cost, data.token, productsCheckedArray];
          var xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if(this.responseText  !== "Transação não finalizada"){
                  window.location = "templates/success.html";
                }
                else{
                  window.location = "templates/fail.html";
                }
            }
          };
          xhttp.open("POST", "functions.php?allData=" + allItemsInformation, true);
          xhttp.send();

          //Executa o loader
          document.getElementById("container").style.display = "none";
          document.getElementById("loader").style.display = "block";
          document.getElementById("loader-text").style.display = "block";
        },
        error: function(err) {
          console.log(err);
        },
        close: function() {
          console.log('The modal has been closed.');
        }
      });

      // Obs.: é necessário passar os valores boolean como string
      checkout.open({
        amount: cost,
        buttonText: 'Pagar',
        buttonClass: 'botao-pagamento',
        customerData: 'false',
        createToken: 'true',
        paymentMethods: 'credit_card',
        customer: {
          external_id: '#123456789',
          name: 'Fulano',
          type: 'individual',
          country: 'br',
          email: 'fulano@email.com',
          documents: [
            {
              type: 'cpf',
              number: '71404665560',
            },
          ],
          phone_numbers: ['+5511999998888', '+5511888889999'],
          birthday: '1985-01-01'
        },
        billing: {
          name: 'Ciclano de Tal',
          address: {
            country: 'br',
            state: 'SP',
            city: 'São Paulo',
            neighborhood: 'Fulanos bairro',
            street: 'Rua dos fulanos',
            street_number: '123',
            zipcode: '05170060'
          }
        },
          items: [
            {
              id: '1',
              title: 'Fantasia',
              unit_price: 0,
              quantity: 1,
              tangible: true
            }
          ]
    });
});

