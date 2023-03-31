Simple REST API server providing text encryption and decryption service.

## Endpoints

### POST /encrypt

parameters
 * text
 * password

response
````
{"ciphertext":"upYAR29CYgqPzkp5gclTuA=="}
````

### POST /decrypt

parameters
* ciphertext
* password

response
````
{"text":"hello"}
````

## Usage

### encrypt text
````
curl -X POST -d 'text=hello&password=superSecretPassword' http://localhost:8000/encrypt
````

### decrypt text
````
curl -X POST -d 'ciphertext=QPAy5ccigmxMXxmni9Cgng==&password=superSecretPassword' http://localhost:8000/decrypt
````

## How to run
````
composer install
php -S 0.0.0.0:8000 public/index.php
````

## Installation via docker
````
docker compose build
docker compose up
````

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
