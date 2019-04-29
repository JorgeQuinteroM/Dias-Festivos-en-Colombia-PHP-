# Días Festivos en Colombia

Libreria para hallar todos los días festivos en Colombia en cualquier año para PHP. 

## Uso

```php
//LIBRERIA

include ('Festivos.php');

//OBJETOS

$ClaseDiasFestivosColombia = new DiasFestivosColombia;

//HALLANDO LOS FESTIVOS PARA EL AÑO 2019

$vector_festivos_en_colombia = $ClaseDiasFestivosColombia->HallarFestivosEnAño(2019);

```

## Respuesta

Las fechas son dadas en formato mm/dd/YYYY, para el año 2019, el codigo arroja el siguiente resultado: 


* 01/01/2019
* 01/07/2019
* 03/25/2019
* 04/14/2019
* 04/18/2019
* 04/19/2019
* 04/21/2019
* 05/01/2019
* 06/03/2019
* 06/24/2019
* 07/01/2019
* 07/01/2019
* 07/20/2019
* 08/07/2019
* 08/19/2019
* 10/14/2019
* 11/04/2019
* 11/11/2019
* 12/08/2019
* 12/25/2019
