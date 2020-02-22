
# Tutorial para levantar Desafio Veus do Bruno Arruda

## Siga os passos

### Faça o download do projeto em seu console

```git clone https://github.com/brunowolly/veus.git```

### Acesse o diretório do projeto

```cd veus```

### instale e faça update das dependencias

```bash
composer install --no-dev
composer update --no-dev
```

### Em seguida, utilize a imagem do composer para montar os diretórios que você precisará para seu projeto Laravel e evite os custos de instalar o Composer globalmente

```docker run --rm -v $(pwd):/app composer install```

Observação:os comandos que estivem com caminho ~/veus devem ser adaptados para sua pasta local

### Como passo final, defina as permissões no diretório do projeto para que ele seja propriedade do seu usuário não root

```sudo chown -R $USER:$USER ~/veus```

### inciando os containers, criando volumes e conectando as resdes configuradas no docker-compose.yml e Dockerfile

```docker-compose up -d```

### você poderá listar os containers criados com o comando abaixo

```docker ps```

### Gerar a chave para o aplicativo Laravel

```docker-compose exec app php artisan key:generate```

### coloque as configuções em cache para aumentar a velocidade de carregamento do aplicativo

```docker-compose exec app php artisan config:cache```

### crie seu usuário MySql

```docker-compose exec db bash```

### Agora, dentro do container, faça o login na conta root, ao solicitar a senha, utilize veus

```mysql -u root -p```

### execute

```sql
GRANT ALL ON veus.* TO 'veus'@'%' IDENTIFIED BY 'veus';
FLUSH PRIVILEGES;
EXIT;
```

### por fim, saia do container

```exit```

### Agora, precisamos executar o migrate do laravel para criar as tabelas

```docker-compose exec app php artisan migrate```

### Vamos criar o primeiro usuário configurado no seed

```docker-compose exec app php artisan db:seed```

Observação:
Será criado usuário Bruno, com e-mail=brunowolly@gmail.com e senha=senha123. Você precisará disso para gerar token que permitirá acessar a api.

### Gerar nossa chave para jwt

```docker-compose exec app php artisan jwt:secret```

Dentro do Postman
jwt
localhost:8081/api/auth/login

copiar accesss_token gerado

na requisição,
escolher type Bearer Token
colar no campo token o token gerado acima
