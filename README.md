Código fonte desenvolvido na aulas: [Acessar as aulas](https://www.youtube.com/watch?v=ButD2QVZprE&list=PLmY5AEiqDWwB29FbhTfTh86Zr0yjeFBwO).<br>
Como criar um CRUD com Laravel 12 e Tailwind, ou seja, cadastrar, listar, editar e apagar.<br>

## Requisitos

* PHP 8.2 ou superior - Conferir a versão: php -v
* Composer - Conferir a instalação: composer --version
* Node.js 22 ou superior - Conferir a versão: node -v
* GIT - Conferir a instalação: git -v

## Como rodar o projeto baixado

Baixar os arquivos do GitHub.
```
git clone <repositorio_url> .
```
```
git clone https://github.com/celkecursos/tutorial-como-usar-laravel-12.git .
```

- Duplicar o arquivo ".env.example" e renomear para ".env".

Alterar no arquivo .env as credenciais do banco de dados.
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco_de_dados
DB_USERNAME=usuario_do_banco_de_dados
DB_PASSWORD=senha_do_usuario_do_banco_de_dados
```

- Para a funcionalidade enviar e-mail funcionar, necessário alterar as credenciais do servidor de envio de e-mail no arquivo .env.
- Utilizar o servidor fake durante o desenvolvimento: [Acessar envio gratuito de e-mail](https://mailtrap.io?ref=celke)
- Utilizar o servidor Iagente no ambiente de produção: [Acessar envio gratuito de e-mail](https://login.iagente.com.br/solicitacao-conta-smtp/origin/celke)
- Configurar DNS da Iagente na [Hostinger](https://www.hostinger.com.br/referral?REFERRALCODE=1CESARNICOL13): [Acessar o tutorial](https://celke.com.br/artigo/como-configurar-o-dns-da-iagente-na-vps-da-hostinger)
```
# MAIL_MAILER=smtp
# MAIL_SCHEME=null
# MAIL_HOST=smart.iagentesmtp.com.br
# MAIL_PORT=587
# MAIL_USERNAME=nome-do-usuario-na-iagente
# MAIL_PASSWORD=senha-do-usuario-na-iagente
# MAIL_FROM_ADDRESS="colocar-email-remetente@meu-dominio.com.br"
# MAIL_FROM_NAME="${APP_NAME}"
```

Instalar as dependências do PHP
```
composer install
```

Instalar as dependências do Node.js.
```
npm install
```

Gerar a chave para o arquivo .env.
```
php artisan key:generate
```

Executar as migration para criar a base de dados e as tabelas.
```
php artisan migrate
```

Iniciar o projeto criado com Laravel.
```
php artisan serve
```

Executar as bibliotecas Node.js.
```
npm run dev
```

Acessar o conteúdo padrão do Laravel
```
http://127.0.0.1:8000
```

# Fazer o deploy do projeto criado com Laravel 12 na Hostinger

- Ganhe 20% de desconto adicional na Hostinger: https://www.hostinger.com.br/referral?REFERRALCODE=1CESARNICOL13

- Cupom para ganhar 10% de desconto na Hostinger: celke

- Configuração básica da VPS da Hostinger: https://celke.com.br/artigo/configuracoes-basicas-de-uma-vps-na-hostinger

## Conectar o PC ao servidor com SSH

Criar chave SSH (chave pública e privada).
```
ssh-keygen -t rsa -b 4096 -C "seu-email@exemplo.com"
```
```
ssh-keygen -t rsa -b 4096 -C "cesar@celke.com.br"
```

- Senha usada na aula, não utilizar a mesma: 58C8s3#7fX5x

Local que é criado a chave pública.
```
C:\Users\SeuUsuario\.ssh\
```
```
C:\Users\cesar/.ssh/
```

Exibir o conteúdo da chave pública.
```
cat ~/.ssh/id_rsa.pub
```

Acessar o servidor com SSH.
```
ssh root@93.127.210.72
```

Se gerar o erro "The authenticity of host 'github.com (xx.xxx.xx.xxx)' can't be established.".<br>
Isso é uma medida de segurança para evitar ataques de "man-in-the-middle".<br>

Digite yes quando for solicitado.
```
Are you sure you want to continue connecting (yes/no/[fingerprint])? yes
```

Remover os arquivos do servidor.
```
rm -rf /home/user/htdocs/endereco-do-servidor/{*,.*}
```
```
rm -rf /home/user/htdocs/srv566492.hstgr.cloud/{*,.*}
```

## Conectar Servidor ao GitHub

Gerar a chave SSH no servidor.
```
ssh-keygen -t rsa -b 4096 -C "cesar@celke.com.br"
```

Imprimir a chave pública gerada.
```
cat ~/.ssh/id_rsa.pub
```

- No GitHub, acessar Settings (Configurações) do seu repositório ou da sua conta, em seguida, vá para SSH and GPG keys e clique em New SSH key.<br>
Cole a chave pública no campo fornecido e salve.

Verificar a conexão com o GitHub.
```
ssh -T git@github.com
```

- Se gerar o erro "The authenticity of host 'github.com (xx.xxx.xx.xxx)' can't be established.".
- Isso é uma medida de segurança para evitar ataques de "man-in-the-middle".

Digite yes quando for solicitado.
```
Are you sure you want to continue connecting (yes/no/[fingerprint])? yes
```

Verificar a conexão novamente.
```
ssh -T git@github.com
```

Mensagem de conexão realizada com sucesso.<br>
Hi nome-usuario! You've successfully authenticated, but GitHub does not provide shell access.<br>

Usar o terminal conectado ao servidor. Primeiro acessar o diretório do projeto no servidor.
```
cd /home/user/htdocs/srv566492.hstgr.cloud
```

Baixar os arquivos do Git.
```
git clone <repository_url> .
```

Duplicar o arquivo ".env.example" e renomear para ".env".
```
cp .env.example .env
```

Abrir o arquivo ".env" e alterar as variaveis de ambiente.
```
nano .env
```

- Ctrl + O e enter para salvar.
- Ctrl + X para sair.

Alterar os dados nas variáveis de ambiente no arquivo .env. Para ver os erros durante o deploy, deixar o valor "local" na variável APP_ENV.
```
APP_NAME=Celke
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_TIMEZONE=America/Sao_Paulo
APP_URL=https://srv566492.hstgr.cloud 
```

- Criar o banco de dados MySQL no servidor.

Alterar as credenciais do banco de dados nas variaveis de ambiente no arquivo .env.
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=celke
DB_USERNAME=root
DB_PASSWORD=
```

Instalar as dependências do PHP.
```
composer install
```

Executar as migration para criar as tabelas.
```
php artisan migrate
```

Instalar as dependências do Node.js.
```
npm run build
```

Quando gerar o erro "sh: 1: vite: not found", necessário instalar o Vite. Executar e Etapa 1, Etapa 2 e Etapa 3.
```
npm install
```

Etapa 1 - Verificar se o Vite está instalado.
```
npx vite --version
```

Etapa 2 - Gerar a build. Compilar o código-fonte do projeto.
```
npm run build
```

Etapa 3 - Remover o diretório "node_modules".

Reiniciar Nginx.
```
sudo systemctl restart nginx
```

Limpar cache.
```
php artisan config:clear
```

Gerar a chave para arquivo .env.
```
php artisan key:generate
```

Alterar a propriedade do diretório.
```
sudo chown -R user:user /home/user/htdocs/srv566492.hstgr.cloud
```

Verificar as vulnerabilidades.
```
npm audit
```

Corrigir automaticamente todas as vulnerabilidades.
```
npm audit fix
```

Atualizar manualmente a dependência.
```
npm install axios@latest
```

- Para a funcionalidade enviar e-mail funcionar, necessário alterar as credenciais do servidor de envio de e-mail no arquivo .env.
- Utilizar o servidor fake durante o desenvolvimento: [Acessar envio gratuito de e-mail](https://mailtrap.io?ref=celke)
- Utilizar o servidor Iagente no ambiente de produção: [Acessar envio gratuito de e-mail](https://login.iagente.com.br/solicitacao-conta-smtp/origin/celke)
- Configurar DNS da Iagente na [Hostinger](https://www.hostinger.com.br/referral?REFERRALCODE=1CESARNICOL13): [Acessar o tutorial](https://celke.com.br/artigo/como-configurar-o-dns-da-iagente-na-vps-da-hostinger)
```
# MAIL_MAILER=smtp
# MAIL_SCHEME=null
# MAIL_HOST=smart.iagentesmtp.com.br
# MAIL_PORT=587
# MAIL_USERNAME=nome-do-usuario-na-iagente
# MAIL_PASSWORD=senha-do-usuario-na-iagente
# MAIL_FROM_ADDRESS="colocar-email-remetente@meu-dominio.com.br"
# MAIL_FROM_NAME="${APP_NAME}"
```

## Instalar o Node.js no servidor.

Atualizar a lista de pacotes disponíveis.
```
sudo apt update
```

Adicionar no repositório o Node.js 22.x.
```
curl -fsSL https://deb.nodesource.com/setup_22.x | sudo -E bash -
```

Instalar o Node.js. -y automatizar a instalação de pacotes sem solicitar a confirmação manual do usuário.
```
sudo apt install -y nodejs
```

Reiniciar Nginx.
```
sudo systemctl restart nginx
```

Limpar cache.
```
php artisan config:clear
```

Remover o Node.js.
```
sudo apt remove nodejs
```

## Sequência para criar o projeto

Criar o projeto com Laravel
```
composer create-project laravel/laravel .
```

Iniciar o projeto criado com Laravel.
```
php artisan serve
```

Acessar o conteúdo padrão do Laravel
```
http://127.0.0.1:8000
```

Criar a Controller.
```
php artisan make:controller NomeController
```
```
php artisan make:controller UserController
```

Criar a View.
```
php artisan make:view nome
```
```
php artisan make:view users/create
```

Executar as migration para criar a base de dados e as tabelas.
```
php artisan migrate
```

Instalar as dependências do Node.js.
```
npm install
```

Executar as bibliotecas Node.js.
```
npm run dev
```

Criar um arquivo Request com validações do formulário.
```
php artisan make:request NomeDoRequest
```
```
php artisan make:request UserRequest
```

Traduzir para português [Módulo pt-BR](https://github.com/lucascudo/laravel-pt-BR-localization).

Instalar a biblioteca para apresentar o alerta personalizado.
```
npm install sweetalert2
```

Instalar a biblioteca para gerar PDF.
```
composer require barryvdh/laravel-dompdf
```

Gerar a classe para enviar e-mail.
```
php artisan make:mail NomeDaClasse
```
```
php artisan make:mail UserPdfMail
```

## Como enviar o projeto para o GitHub.

Inicializar um novo repositorio GIT.
```
git init
```

Adicionar todos os arquivos modificados na área de preparação.
```
git add .
```

Commit registra as alterações feitas nos arquivos que foram adicionados na área de preparação.
```
git commit -m "Base do projeto"
```

Verificar em qual branch está.
```
git branch
```

Renomear a branch atual no GIT para main.
```
git branch -M main
```

Adicionar um repositório remoto ao repositório local.
```
git remote add origin https://github.com/celkecursos/tutorial-como-usar-laravel-12.git
```

Enviar os commits locais para um repositório remoto.
```
git push -u origin main
```

## Autor

Este projeto foi desenvolvido por [Cesar Szpak](https://github.com/cesarszpak) e está hospedado no repositório da organização [Celke](https://github.com/celkecursos).

## Licença

Este projeto está licenciado sob a licença MIT - veja o arquivo [LICENSE](LICENSE.txt) para mais detalhes.