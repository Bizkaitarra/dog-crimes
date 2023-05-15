# Dog Crimes
Proyecto personal para resolver el juego Dog crimes.

Manual de instrucciones: https://www.manualpdf.es/thinkfun/dog-crimes/manual?p=2

El juego se basa en colocar unos perros a una alfombra o mesa y descubrir qué perro está
sentado delante del crimen sucedido.

Para ello se cuenta con unas cartas con pistas que siguiéndolas nos llevan a una única solución.

El proyecto actualmente 3 partes:

* Core: Dominio del juego que permite crear un juego y validar el cumplimiento de la colocación de los perros
* Web: Interfaz web que permite posicionar los perros y realiza una llamada para comprobar si se cumplen las reglas
* Comando: Al igual que en web se pueden posicionar los perros y va indicando si se cumplen las reglas

Por otro lado, de manera ilustrativa en este momento únicamente se dispone de un juego, la tarjeta 1, la cual está incompleta.

## Instalación

* Instalar docker y make.
* Ejecutar las instrucciones siguientes:

````shell
make build
make composer-install
make start
````

## Testing

El objetivo del proyecto es practicar y por tanto se están usando dos librerías de testing
sin tener un criterio en cuanto a su uso para un tipo de test concreto.

Se trata de un proyecto con una gran carga de parte de dominio para poder practicar "sin ruido"
y se esta testeando la parte de dominio omitiendo otro tipo de testing

````shell
make test-behat
make test-phpunit
````

## Juego en modo comando

Para jugar al juego en modo comando se puede usar la instrucción de make "play" 

````shell
make play
````

Luego siguiendo las instrucciones podremos posicionar los perros.

