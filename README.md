
 docker pull brunowolly/app:1.0
 docker pull brunowolly/db:5.7.22
 docker pull brunowolly/webserver:alpine

docker images


 docker run --name app image
 
 
 docker-compose exec app php artisan key:generate
 docker-compose exec app php artisan db:seed


jwt
localhost:8081/api/auth/login
brunowolly@gmail.com
senha123

copiar accesss_token gerado

na requisição,
escolher type Bearer Token
colar no campo token o token gerado acima

