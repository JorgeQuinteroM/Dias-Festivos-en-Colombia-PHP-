```php

class DiasFestivosColombia
{

    /*
        * ES IMPORTANTE RECORDAR QUE EN COLOMBIA EXISTEN TRES TIPOS DE FESTIVOS:
            * FESTIVOS DE FECHA FIJA: INAMOVIBLES, SE MANTIENEN EN ESA FECHA SIEMPRE.
            * FESTIVOS DE SIGUIENTE LUNES: EN CASO DE QUE LA FECHA EN LA QUE CAEN NO SEA UN
              LUNES, SERAN EL SIGUIENTE LUNES.
            * FESTIVOS RESPECTO AL DOMINGO DE RESURECCION: DADO QUE EL DOMINGO DE RESURRECION
              CAMBIA DE FECHA TODOS LOS AÑOS, LOS FESTIVOS QUE DEPENDEN DE ESTE TAMBIEN LO HACEN.

        * ESTA FUNCION CONTIENE TODOS LOS FESTIVOS DE UN AÑO Y EJECUTA LA FUNCION CORRESPONDIENTE
          A CADA FESTIVO, YA SEA QUE SE HALLEN POR FECHA FIJA, SIGUIENTE LUNES O RESPECTO A LA PASCUA.
    */

    function HallarFestivosEnAño($Año)
    {
      $vector_festivos = [];
      //FESTIVOS DE ENERO
      $festivo_primero_enero = '01/01/'.$Año;
      $festivo_reyes_magos = $this->FestivosDeSiguienteLunes(6, 1, $Año);
      //FESTIVOS DE MARZO
      $festivo_dia_san_jose = $this->FestivosDeSiguienteLunes(19, 3, $Año);
      $festivo_domingo_ramos = $this->HallarFestivoRespectoDomingoResurreccion(-7, $Año);
      //FESTIVOS DE ABRIL
      $festivo_jueves_santo = $this->HallarFestivoRespectoDomingoResurreccion(-3, $Año);
      $festivo_viernes_santo = $this->HallarFestivoRespectoDomingoResurreccion(-2, $Año);
      $festivo_domingo_resureccion = $this->HallarFestivoRespectoDomingoResurreccion(+0, $Año);
      //FESTIVOS DE MAYO
      $festivo_dia_trabajo = '05/01/'.$Año;
      $festivo_ascension_jesus = $this->HallarFestivoRespectoDomingoResurreccion(+43, $Año);
      $festivo_corpus_christi = $this->HallarFestivoRespectoDomingoResurreccion(+64, $Año);
      //FESTIVOS DE JUNIO
      $festivo_dia_san_pedro = $this->FestivosDeSiguienteLunes(29, 6, $Año);
      $festivo_sagrado_corazon = $this->HallarFestivoRespectoDomingoResurreccion(+71, $Año);
      //FESTIVOS DE JULIO
      $festivo_veinte_julio = '07/20/'.$Año;
      //FESTIVOS DE AGOSTO
      $festivo_siete_agosto = '08/07/'.$Año;
      $festivo_asuncion_virgen = $this->FestivosDeSiguienteLunes(15, 8, $Año);
      //FESTIVOS DE OCTUBRE
      $festivo_dia_raza = $this->FestivosDeSiguienteLunes(12, 10, $Año);
      //FESTIVOS DE NOVIEMBRE
      $festivo_todos_santos = $this->FestivosDeSiguienteLunes(1, 11, $Año);
      $festivo_independencia_cartagena = $this->FestivosDeSiguienteLunes(11, 11, $Año);
      //FESTIVOS DE DICIEMBRE
      $festivo_ocho_diciembre = '12/08/'.$Año;
      $festivo_veinticinto_diciembre = '12/25/'.$Año;

      $vector_festivos = [$festivo_primero_enero, $festivo_reyes_magos, $festivo_dia_san_jose, $festivo_domingo_ramos, $festivo_jueves_santo, $festivo_viernes_santo, $festivo_domingo_resureccion, $festivo_dia_trabajo, $festivo_ascension_jesus, $festivo_corpus_christi, $festivo_sagrado_corazon, $festivo_dia_san_pedro, $festivo_veinte_julio, $festivo_siete_agosto, $festivo_asuncion_virgen, $festivo_dia_raza, $festivo_todos_santos, $festivo_independencia_cartagena, $festivo_ocho_diciembre, $festivo_veinticinto_diciembre];
      return $vector_festivos;
    }

    /*
        * DADO QUE EXISTEN FESTIVOS QUE SE DAN EL SIGUIENTE LUNES A UNA FECHA DETERMINADA,
          SE CONSTRUYO LA SIGUIENTE FUNCIÓN.
        * INICIALMENTE, SE VERIFICA SI EL DIA PROPORCIONADO EN LOS PARAMETROS DE ENTRADA DE
          LA FECHA ES UN LUNES, EN CASO DE QUE LO SEA, SE TOMA ESTA FECHA, DE LO CONTRARIO,
          SE UTILIZARA LA FUNCION MODIFY PARA ENCONTRAR EL SIGUIENTE LUNES.
    */

    function FestivosDeSiguienteLunes($Dia, $Mes, $Año)
    {
        $ClaseTratamientoDeFechas = new TratamientoFechas;
        $mes_dos_digitos = $ClaseTratamientoDeFechas->Concatenar0Izquierda($Mes);
        $dia_dos_digitos = $ClaseTratamientoDeFechas->Concatenar0Izquierda($Dia);
        $fecha = $mes_dos_digitos.'/'.$dia_dos_digitos.'/'.$Año;
        $nombre_dia = date("D", strtotime($fecha));
        if ($nombre_dia == 'Mon')
        {
            $festivo = $Dia;
            $fecha_festivo = $mes_dos_digitos.'/'.$dia_dos_digitos.'/'.$Año;
        }
        else
        {
            $fecha = DateTime::createFromFormat('m/d/Y', $fecha);
            $fecha->modify('next monday');
            $fecha_festivo = $fecha->format('m/d/Y');
        }
        return $fecha_festivo;
    }

    /*
        * EL DOMINGO DE RESURRECCION VARIA AÑO A AÑO, LA FUNCION EASTER_DAYS DEVUELVE
          LA CANTIDAD DE DIAS ENTRE EL 21 DE MARZO DE CUALQUIER AÑO Y EL DOMINGO DE RESURECCION
          DE DICHO AÑO.
        * PARA HALLAR EL DOMINGO DE RESURECCION, SE DEBEN SUMAR 21 (DEL 21 DE MARZO) MAS LOS DIAS
          HALLADOS ANTERIORMENTE (DIAS ENTRE 21 DE MARZO Y DOMINGO DE RESURECCION) Y RESTARLE 31
          (DIAS QUE TIENE EL MES DE MARZO).
        * SI $DIA_RESURECCION DA UN VALOR MENOR O IGUAL A 0, EL DOMINGO DE RESURECCION
          ESTARA EN MARZO, SI DA MAYOR A 0, EL DOMINGO DE RESURRECION ESTARA EN ABRIL.
        * PARA HALLAR EL DIA DE RESURECCION EN MARZO, SE DEBE SUMAR 31 A LA VARIABLE
          $DIA_RESURECCION (DADO QUE MARZO TIENE 31 DIAS).
        * SI LA VARIABLE $DIA_RESURRECION ES MENOR O IGUAL A 0, SIGNIFICA QUE EL DOMINGO DE
          RESURECCION ESTUVO EN MARZO, Y ES NECESARIO UTILIZAR LA VARIABLE $DIA_RESURRECION_MARZO,
          SI $DIA_RESURECCION ES MAYOR A 0, EL DOMINGO DE RESURRECION ESTUVO EN ABRIL Y SE DEBE UTILIZAR
          $DIA_RESURECCION
    */
    function DomingoResurrecion($Año)
    {
      $dia_resurreccion = 21 + easter_days($Año) - 31;
      $mes = ($dia_resurreccion <= 0 ? '03':'04');
      $dia_resurreccion_marzo = $dia_resurreccion + 31;
      $dia_resurreccion = ($dia_resurreccion <= 0 ? $dia_resurreccion_marzo:$dia_resurreccion);
      $domingo_resurrecion = $mes.'/'.$dia_resurreccion.'/'.$Año;
      return $domingo_resurrecion;
    }

    /*
        * DADO QUE ALGUNOS FESTIVOS SERAN CIERTOS DIAS ANTES O DESPUES DEL DOMINGO DE
          RESURECCION, SE DESARROLLA LA FUNCION PRESENTADA A CONTINUACIÓN. INICIALMENTE,
          SE HALLARA EL DOMINGO DE RESURRECCIÓN DEL AÑO DE INTERES.
        * SEGUIDO A ESTO, SE UTILIZARA LA FUNCION MODIFY PARA SUMARLE O RESTARLE TANTOS
          DIAS COMO DIGA EL PARAMETRO DE LA FUNCION $DIAS_VARIACION.
        * FINALMENTE, SE LE DA FORMAT A LA FECHA Y SE DEVUELVE.
    */
    function HallarFestivoRespectoDomingoResurreccion($DiasVariacion, $Año)
    {
      $domingo_resurrecion = $this->DomingoResurrecion($Año);
      $domingo_resurrecion = DateTime::createFromFormat('m/d/Y', $domingo_resurrecion);
      $festivo = $domingo_resurrecion->modify($DiasVariacion.' day');
      $festivo = $festivo->format('m/d/Y');
      return $festivo;
    }
   
}

```
