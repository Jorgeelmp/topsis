# TOPSIS

Plataforma web de recomendação de profissionais autônomos baseada no método
multicritério **TOPSIS**. O projeto é uma aplicação [Laravel](https://laravel.com/)
com SQLite, [Vite](https://vite.dev/) e Tailwind CSS.

## Requisitos

Antes de começar, instale:

- **PHP 8.3 ou superior**, com as extensões `sqlite3`, `pdo_sqlite`, `mbstring`,
  `openssl`, `xml`, `curl` e `fileinfo`;
- **Composer 2**;
- **Node.js 20.19+ ou 22.12+** e npm;
- **Git**.

Confira as versões instaladas:

```bash
php -v
composer --version
node --version
npm --version
git --version
```

## Instalação em qualquer plataforma

Os comandos desta seção devem ser executados a partir da pasta do projeto.
Substitua a URL do clone pela URL usada para obter o repositório, se necessário.

1. Clone o projeto e entre na pasta:

   ```bash
   git clone https://github.com/Jorgeelmp/topsis.git
   cd topsis
   ```

2. Instale as dependências PHP e JavaScript:

   ```bash
   composer install
   npm install
   ```

3. Crie o arquivo de ambiente:

   ```bash
   cp .env.example .env
   ```

   No Windows PowerShell, use:

   ```powershell
   Copy-Item .env.example .env
   ```

4. Gere a chave da aplicação:

   ```bash
   php artisan key:generate
   ```

5. Confira se o `.env` usa SQLite:

   ```dotenv
   DB_CONNECTION=sqlite
   ```

   O projeto já inclui `database/database.sqlite`. Se o arquivo não existir,
   crie-o antes da migração:

   ```bash
   touch database/database.sqlite
   ```

   No Windows PowerShell:

   ```powershell
   New-Item database/database.sqlite -ItemType File
   ```

6. Crie ou atualize as tabelas:

   ```bash
   php artisan migrate
   ```

7. Popule o banco com os dados iniciais:

   ```bash
   php artisan db:seed
   ```

   O seeder cria categorias, critérios, clientes, profissionais, avaliações e
   um usuário administrador para acesso inicial:

   - **E-mail:** `admin@topsis.com`
   - **Senha:** `password`

   Altere essa senha após o primeiro acesso em qualquer ambiente compartilhado
   ou de produção.

8. Compile os assets para uma execução sem hot reload:

   ```bash
   npm run build
   ```

## Linux (Ubuntu/Debian)

1. Atualize os índices e instale as ferramentas básicas:

   ```bash
   sudo apt update
   sudo apt install -y git curl unzip sqlite3
   ```

2. Instale PHP 8.3 ou superior e as extensões exigidas pela aplicação. Em
   distribuições que não oferecem PHP 8.3 no repositório padrão, use uma fonte
   de pacotes confiável para a sua distribuição:

   ```bash
   sudo apt install -y php php-cli php-common php-curl php-mbstring \
     php-sqlite3 php-xml php-zip
   ```

3. Instale o Composer seguindo a
   [documentação oficial](https://getcomposer.org/download/) e o Node.js
   seguindo a [documentação oficial](https://nodejs.org/en/download).

4. Execute os passos da seção [Instalação em qualquer plataforma](#instalação-em-qualquer-plataforma).

## macOS

1. Instale o [Homebrew](https://brew.sh/), caso ainda não esteja instalado:

   ```bash
   /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
   ```

2. Instale Git, PHP, SQLite e Node.js:

   ```bash
   brew install git php sqlite node
   ```

3. Instale o Composer seguindo a
   [documentação oficial](https://getcomposer.org/download/).

4. Execute os passos da seção [Instalação em qualquer plataforma](#instalação-em-qualquer-plataforma).

## Windows

1. Instale:
   - [Git for Windows](https://git-scm.com/download/win);
   - [PHP 8.3+](https://www.php.net/downloads.php), adicionando a pasta do
     PHP ao `PATH`;
   - [Composer](https://getcomposer.org/download/);
   - [Node.js LTS](https://nodejs.org/en/download).

   Como alternativa, no Windows 10/11 com `winget`, instale Git, Node.js e
   Composer assim:

   ```powershell
   winget install --id Git.Git -e
   winget install --id OpenJS.NodeJS.LTS -e
   winget install --id Composer.Composer -e
   ```

   O PHP precisa ser instalado separadamente caso não esteja disponível no
   ambiente. Habilite as extensões `extension=pdo_sqlite` e
   `extension=sqlite3` no `php.ini`.

2. Abra o **PowerShell** ou o **Git Bash**, clone o projeto e execute os passos
   da seção [Instalação em qualquer plataforma](#instalação-em-qualquer-plataforma).

3. Se o `cp` ou `touch` não funcionar, use os equivalentes do PowerShell
   indicados na seção de instalação.

## Executando em desenvolvimento

Depois da instalação, há duas formas de iniciar o projeto.

### Comando recomendado

O script `dev` inicia simultaneamente o servidor Laravel, o worker da fila, os
logs e o Vite:

```bash
composer run dev
```

Abra [http://localhost:8000](http://localhost:8000) no navegador. Para parar
todos os processos, pressione `Ctrl+C`.

### Em terminais separados

Essa opção é útil quando o comando simultâneo não funciona no seu shell ou
quando você quer visualizar cada processo separadamente.

**Terminal 1 — servidor Laravel:**

```bash
php artisan serve
```

**Terminal 2 — Vite:**

```bash
npm run dev
```

Opcionalmente, execute o worker da fila em um terceiro terminal:

```bash
php artisan queue:listen --tries=1 --timeout=0
```

Mantenha os terminais abertos durante o desenvolvimento. O Vite atualiza os
assets automaticamente, enquanto o servidor Laravel fica disponível em
`http://localhost:8000`.

## Comandos úteis

```bash
# Limpar caches da aplicação
php artisan optimize:clear

# Executar a suíte de testes
composer run test

# Recriar o banco local e executar todos os seeders
php artisan migrate:fresh --seed

# Gerar os assets para produção
npm run build
```

## Solução de problemas

- **`php: command not found` ou versão incompatível:** instale PHP 8.3+ e
  confirme que ele está no `PATH` com `php -v`.
- **Erro de extensão SQLite:** habilite `sqlite3` e `pdo_sqlite` no `php.ini`,
  reabra o terminal e confirme com `php -m | grep sqlite` (Linux/macOS) ou
  `php -m | Select-String sqlite` (PowerShell).
- **`composer install` falha:** confirme a versão do PHP e execute
  `composer diagnose`.
- **`npm install` falha por versão do Node:** use Node.js 20.19+ ou 22.12+.
- **Página sem estilos ou JavaScript:** deixe `npm run dev` em execução durante
  o desenvolvimento ou rode `npm run build`.
- **Erro de chave da aplicação:** execute novamente `php artisan key:generate`
  e verifique se o arquivo `.env` existe.
- **Erro de banco:** confirme que `database/database.sqlite` existe, que
  `DB_CONNECTION=sqlite` está definido no `.env` e execute
  `php artisan migrate`.

## Estrutura principal

- `app/`: regras de negócio, modelos e ações Laravel;
- `database/`: migrações e banco SQLite local;
- `resources/`: views Blade, JavaScript e estilos;
- `routes/`: rotas HTTP da aplicação;
- `tests/`: testes automatizados.

## Licença

Este projeto é distribuído sob a licença MIT.
