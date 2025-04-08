<?php

    header('Content-Type: application/json; charset=utf-8');

    if( !isset( $_GET['kg'] )  ||  !isset( $_GET['cm'] ) )
    {
	$tomb = array( 'hiba' => "hiányos adatok" ,  'uzenet' => "megadandó paraméterek: kg és cm" ) ;
    }
    else
    {

	$kg   = $_GET['kg'] ;
	$cm   = $_GET['cm'] ;

	$tti  = round( $kg/($cm/100)/($cm/100) , 2 ) ;

	if( $tti < 18)
	{
		$minosítes = "sovány testalkat" ;
		$testkep   = "https://infojegyzet.hu/webszerkesztes/javascript/testtomegindex/body_thin.gif" ;
		$tobblet   =  0  ;
	}
	else if( $tti <= 25)
	{
		$minosítes = "normál testalkat" ;
		$testkep   = "https://infojegyzet.hu/webszerkesztes/javascript/testtomegindex/body_correct.gif" ;
		$tobblet   =  0  ;
	}
	else
	{
		$minosítes = "túlsúlyosság" ;
		$testkep   = "https://infojegyzet.hu/webszerkesztes/javascript/testtomegindex/body_fat.gif" ;
		$tobblet   =  ceil( $kg - 25 * ($cm/100) * ($cm/100) ) ;
	}

	$tomb = array(   'kg'        => $_GET['kg'] ,
	                 'cm'        => $_GET['cm'] ,
	                 'tti'       => $tti        ,
	                 'minosites' => $minosítes  ,
	                 'testkep'   => $testkep    ,
	                 'tobblet'   => $tobblet
	             ) ;

    }

    $json = json_encode( $tomb , JSON_UNESCAPED_UNICODE ) ;

    print $json ;

?>