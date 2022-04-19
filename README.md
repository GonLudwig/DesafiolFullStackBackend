1- Na utilização do Laravel como BackEnd do desafio como api, eu realizei a criação de uma porta somente para utilização pelo verbo http GET.

2- Para utilização do verbo GET foi criado um controller que por sua vez realiza a utilização de um request personalizado para validar se o parâmetro cnpj foi enviado e se ele possui no mínimo 14 e no máximo 18 caracteres. Para evitar o processamento de todas as tratativas que são realizadas no controller em uma requisição que não cumpra os requisitos mínimos para a tratativa do controller.

3- O controller realiza a utilização de um Helper para validar se o valor recebido no parâmetro corresponde a uma sequência válida de  CNPJ.

4- Caso seja um CNPJ válido o controlador aciona a API externa para consultar o CNPJ.

5- Com base na resposta o controlador realiza mais uma tratativa com base na resposta da API externa para verificar e tratar as respostas. Caso tenha algum erro específico esta mensagem de erro será retornada para o cliente e caso tenha sucesso ele realiza uma verificação para saber qual é a última data de atualização do CNPJ e com isso, junta todas as outras informações da resposta e envia para o cliente.