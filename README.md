# Sistema de Login e Cadastro

Aplicação web em PHP com autenticação de usuários, controle de sessão e proteção de rotas com banco de dados MySQL.

---

## Funcionalidades

- Cadastro de novos usuários
- Login e logout com controle de sessão
- Proteção de páginas para usuários não autenticados
- Redirecionamento automático ao tentar acessar rotas protegidas
- Estrutura modular e organizada

---

## Tecnologias

- PHP 7.4+
- MySQL
- HTML5 / CSS3
- JavaScript

---

## Pré-requisitos

Antes de começar, você precisa ter instalado:

- [PHP](https://www.php.net/) 7.4 ou superior
- [MySQL](https://www.mysql.com/) ou [MariaDB](https://mariadb.org/)
- Servidor local como [XAMPP](https://www.apachefriends.org/) ou similar

---

## Como rodar localmente

**1. Clone o repositório**

```bash
git clone https://github.com/seu-usuario/seu-repositorio.git
cd seu-repositorio
```

**2. Importe o banco de dados**

```bash
mysql -u root -p nome_do_banco < cadastro.sql
```

Ou importe o arquivo `cadastro.sql` pelo phpMyAdmin.

**3. Configure a conexão com o banco**

Abra o arquivo `startSession.php` e edite as credenciais:

```php
$host = 'localhost';
$dbname = 'nome_do_banco';
$user = 'seu_usuario';
$password = 'sua_senha';
```

> Nunca compartilhe suas credenciais reais. Considere usar variáveis de ambiente em produção.

**4. Inicie o servidor**

```bash
php -S localhost:8000
```

Acesse no navegador: [http://localhost:8000](http://localhost:8000)

---

## Estrutura de arquivos

```
├── CSS/                 # Estilos da aplicação
├── JavaScript/          # Scripts do front-end
├── index.php            # Página inicial
├── logIn.php            # Formulário e lógica de login
├── logout.php           # Encerra a sessão do usuário
├── protect.php          # Middleware de proteção de rotas
├── startSession.php     # Inicializa sessão e conexão com o banco
├── user_app.php         # Área restrita do usuário autenticado
├── cadastro.sql         # Estrutura e dados iniciais do banco
└── README.md
```

---

## Como funciona a autenticação

1. O usuário preenche o formulário em `logIn.php`
2. As credenciais são validadas contra o banco de dados
3. Em caso de sucesso, a sessão é iniciada via `startSession.php`
4. Páginas protegidas incluem `protect.php`, que redireciona usuários não autenticados
5. O logout em `logout.php` destrói a sessão e redireciona para o login

---

## Segurança

- Senhas devem verificadas com `password_verify()`
- Proteja o projeto contra SQL Injection usando PDO com prepared statements
- Nunca exponha credenciais de banco de dados no código versionado

---

---

## Autor

Feito por **Giuliana Karime** — sinta-se à vontade para abrir uma issue ou pull request.
