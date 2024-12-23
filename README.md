# Melhorias-Urbanas

## Tecnologias Utilizadas
O projeto utiliza as seguintes tecnologias: HTML, CSS, JavaScript, PHP e MySQL.

## Como Configurar e Executar o Projeto

### Pré-requisitos:
Para configurar o projeto, você precisará de:
1. Um servidor local como [XAMPP](https://www.apachefriends.org/) ou [WAMP](https://www.wampserver.com/).
2. Um navegador moderno para acessar o projeto.
3. (Opcional) O Git para clonar o repositório.

### Passos de Configuração
1. **Clone este repositório**:
   Use o comando:
   ```bash
   git clone https://github.com/Luis-Vansan/Melhorias-Urbanas.git
   ```
   ou baixe o repositório como um arquivo `.zip` e extraia os arquivos.

2. **Mova os arquivos para a pasta `htdocs`**:
   Coloque os arquivos extraídos na pasta `htdocs` do XAMPP. Por exemplo: `C:\xampp\htdocs\melhorias-urbanas`.

3. **Configure o banco de dados**:
   - Acesse o [phpMyAdmin](http://localhost/phpmyadmin).
   - Crie um banco de dados chamado `reclameaqui`.
   - Importe o arquivo `reclameaqui.sql` (disponível no repositório).

4. **Edite a configuração de conexão com o banco de dados**:
   No arquivo `conexao.php` , insira as credenciais do seu banco de dados(se precisar):
   ```php
   <?php
   $host = 'localhost';
   $user = 'root';
   $password = '';
   $database = 'reclameaqui';
   ?>
   ```

### Executando o Projeto
1. Inicie o Apache e o MySQL no painel do XAMPP.
2. Acesse o projeto no navegador no seguinte endereço:
   ```
   http://localhost/crud/
   ```

## Funcionalidades
- Cadastro e gerenciamento de melhorias urbanas.
- Comentarios e discusão.
- Visualização de dados.
- Interface amigável e responsiva para facilitar o uso.
