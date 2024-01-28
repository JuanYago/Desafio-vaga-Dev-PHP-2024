# Desafio Vaga Dev PHP 2024

Software feito para o gerente da associação "Devs do RN", com o objetivo de facilitar a gerência dos associados e suas anuidades

## Sobre o Projeto


Este projeto é uma aplicação PHP que permite:

- Cadastro de associados, com: Nome, E-mail, CPF e Data de filiação.
- Cadastro de anuidades, com: Ano e Valor.
    - Cada ano, o valor da anuidade pode ser diferente. Ex: 2021 = R$90,00 / 2022 = R$100,00 / 2023 = R$110,00.
    - Esse valor deve ser facilmente ajustado pelo gerente.
- Cobrança das anuidades do associado.
    - "Checkout" das anuidade devidas pelo associado, calculando valor devido por anuidade e valor total devido.
    - Considere a Data de filiação para saber quais anuidades são devidas pelo associado.
- "Pagamento" da anuidade de um associado.
    - Para este teste o pagamento será simplesmente uma flag no banco de dados, indicando se a anuidade foi paga ou não.
- O software também deve ser capaz de identificar quais são os associados com pagamento em dia e quais estão em atraso.
    - Para isso considere todo novo associado devedor da anuidade corrente.

O projeto usa PHP puro, sem qualquer framework. Ele também usa MySQL para o armazenamento de dados e CSS para a estilização.


## Pré-requisitos

Antes de começar, você vai precisar ter instalado em sua máquina as seguintes ferramentas:
- [PHP](https://www.php.net/)
- [Servidor Apache](https://httpd.apache.org/) ou similar
- [MySQL](https://www.mysql.com/) ou similar (se o projeto usar banco de dados)

## Como Usar

Para clonar e executar esta aplicação, você vai precisar do [Git](https://git-scm.com) instalado em seu computador. A partir da sua linha de comando:

```bash
# Clone este repositório
$ git clone https://github.com/JuanYago/Desafio-vaga-Dev-PHP-2024.git

# Acesse a pasta do projeto no terminal/cmd
$ cd Desafio-vaga-Dev-PHP-2024

