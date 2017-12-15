[![Maintainability](https://api.codeclimate.com/v1/badges/cbdc7c30b595d13da81a/maintainability)](https://codeclimate.com/github/MichaelKlemersson/voucher-pool/maintainability)

# voucher pool
this is the code used for a voucher pool challenge test

## requirements
**PHP** version >= 7.1

this application is using **docker** to create containers and run the application,
so if you haven't it's not a problem just create a database, run the migrations and update your settings on **.env** file

## running the project

- clonning and install dependencies
```bash
git clone git@github.com:MichaelKlemersson/voucher-pool.git

cd voucher-pool

composer install

cp .env.example .env # just if the post install don't generate the .env file

docker-compose up -d

docker ps # checking if containers are up

docker container exec -it voucherpool-app php artisan migrate
```

- after running the commands above you will be able to use the api
with endpoints

    - GET [http://localhost:8080/api/v1/recipients](http://localhost:8080/api/v1/recipients)
    
    - GET [http://localhost:8080/api/v1/offers](http://localhost:8080/api/v1/offers)

    - GET [http://localhost:8080/api/v1/vouchers/from-recipient?email=dummy@mail.com](http://localhost:8080/api/v1/vouchers/from-recipient?email=dummy@mail.com)

    - GET [http://localhost:8080/api/v1/vouchers/check?code=dummycodehere](http://localhost:8080/api/v1/vouchers/check?code=dummycodehere)

    - POST [http://localhost:8080/api/v1/vouchers/generate](http://localhost:8080/api/v1/vouchers/generate) **see the documentation at apidoc folder to check the required parameters**


> P.S. there is a postman collection **voucher-pool-postman.postman_collection.json** the could be imported test the api


## testing
there are some useful scripts into the **composer.json** file you can just do:
```bash
docker container exec -it voucherpool-app composer test:all

docker container exec -it voucherpool-app composer test:unit path/to/testClass

docker container exec -it voucherpool-app composer testdox
```