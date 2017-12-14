# voucher pool
this is the code used for a voucher pool challenge test

## running the project

- clonning and install dependencies
```bash
git clone git@github.com:MichaelKlemersson/voucher-pool.git

cd voucher-pool

composer install

cp .env.example .env # just if the post install don't generate the .env file

docker-compose up -d
```

- after running the commands above you will be able to use the api
with endpoints

    - GET [http://localhost:8080/api/v1/recipients](http://localhost:8080/api/v1/recipients)
    
    - GET [http://localhost:8080/api/v1/offers](http://localhost:8080/api/v1/offers)

    - GET [http://localhost:8080/api/v1/vouchers/from-recipient?email=dummy@mail.com](http://localhost:8080/api/v1/vouchers/from-recipient?email=dummy@mail.com)

    - GET [http://localhost:8080/api/v1/vouchers/check?code=dummycodehere](http://localhost:8080/api/v1/vouchers/check?code=dummycodehere)


> P.S. there is a postman collection **voucher-pool-postman.postman_collection.json** the could be imported test the api


## testing
there are some useful scripts into the **composer.json** file you can just do:
```bash
composer test:all

composer test:unit path/to/testClass

composer testdox
```