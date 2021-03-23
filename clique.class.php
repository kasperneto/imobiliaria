<?php
/**
 * Imobiliaria Class
 *
 * @category  Imobiliaria
 * @package   Imobiliaria
 * @author    Eugenio Kasper <kasper.neto@gmail.com>
 * @copyright Copyright (c) 2010-2017
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @link      https://github.com/kasperneto/imobiliaria/blob/main/composer.json
 * @version   2.9.3
 */

// V($_GET, 'var', '');
// And you can actually drop the last parameter because the default default is an empty string.
function V(&$a, $e, $d = '')
{
  return (isset($a[$e]) ? $a[$e] : $d);
}

function iimagem($arquivo, $dest = NULL, $alt = EK_TITULO, $dummy= '')
{
	if ($dest = NULL) {
		$hhtml = "<img src=\"" .SCRIPT_ROOT. "/". $arquivo . "\" alt=\"" . $alt ."\"/>";
	} else {
		$hhtml = "<a href=\"" .SCRIPT_ROOT. "/". $dest . "\"><img src=\"" .SCRIPT_ROOT."/". $arquivo . "\" alt=\"" . $alt ."\"/></a>";
	}
	return $hhtml;
}

function generateSeoURL($string, $wordLimit = 0){
    $separator = '-';
    
    if($wordLimit != 0){
        $wordArr = explode(' ', $string);
        $string = implode(' ', array_slice($wordArr, 0, $wordLimit));
    }

    $quoteSeparator = preg_quote($separator, '#');

    $trans = array(
        '&.+?;'                    => '',
        '[^\w\d _-]'            => '',
        '\s+'                    => $separator,
        '('.$quoteSeparator.')+'=> $separator
    );

    $string = strip_tags($string);
    foreach ($trans as $key => $val){
        $string = preg_replace('#'.$key.'#i'.(UTF8_ENABLED ? 'u' : ''), $val, $string);
    }

    $string = strtolower($string);

    return trim(trim($string, $separator));
}

class Imovel {
	public function escreve($codigo, $titulo, $extra, $valor, $nota, $dormitorios, $vagas, $area, $foto, $tag1, $tag2, $stamp) {
			return "<!-- IMOVEL -->\n<div class=\"col-lg-4 col-md-6\"> <div class=\"property bg-white m-bottom-30 box-shadow-1 box-shadow-3-hover\"> <div class=\"property-media overlay-wrapper\"> <a href=\"/imovel.php?id=".$codigo."\"><img class=\"full-width\" src=\"/th.php?l=350&a=240&crop=0&path=painel/fotos/".$codigo."/".$foto."\" alt=\"".$titulo."\"><div class=\"media-data\"> <div class=\"position-bottom\"> <p class=\"text-white m-bottom-5\">".$nota."</p><h2 class=\"text-white preco m-bottom-15 text-bold-700\">". self::ajustaValor($valor)."</h2> <div class=\"badge badge-warning pull-left m-right-8 p-top-8 p-right-12 p-bottom-8 p-left-12 rounded-0\">".$tag1."</div><div class=\"badge badge-success pull-left p-top-8 p-right-12 p-bottom-8 p-left-12 rounded-0\">".$tag2."</div></div></div><!--<div class=\"overlay bg-bg opacity-9\"></div>--></a></div><div class=\"property-section p-left-15 p-right-15 border-5 border-solid border-base border-right-0 border-left-0 border-top-0\"> <div class=\"m-top-20 m-bottom-20\"> <h6><a class=\"text-bold-600 text-dark text-base-hover\" href=\"/imovel.php?id=".$codigo."\">".$titulo."</a></h6> <p>".$extra."</p><ul class=\"icon-list list-inline m-bottom-0\"> <li class=\"list-inline-item\"><i class=\"btn btn-base rounded-0 fa fa-bed\"></i>". $dormitorios." dormitórios</li><li class=\"list-inline-item\"><i class=\"btn btn-base rounded-0 fa fa-car\"></i>".$vagas."  vagas</li><li class=\"list-inline-item\"><i class=\"btn btn-base rounded-0 fa fa-expand\"></i> ".$area." m²</li></ul> </div></div><!--<div class=\"bg-light-3 text-size-13 text-muted p-top-15 p-right-15 p-bottom-15 p-left-15\"> <ul class=\"list-unstyled d-flex justify-content-between m-bottom-0\"> <li><i class=\"m-right-4 fa fa-calendar\"></i> ".self::tempo_corrido($stamp)."</li><li><a href=\"my-bookmarked.html\" class=\"text-base\"><i class=\"m-right-4 fa fa-heart-o\"></i> Salvar</a></li></ul> </div>--></div></div>\n<!-- /IMOVEL -->";
	}

	public function ultimos($codigo, $titulo, $extra, $valor, $foto) {
		return "<li><img alt=\"".$titulo."\" class=\"media-img\" src=\"/th.php?l=150&a=130&crop=0&path=painel/fotos/".$codigo."/".$foto."\" alt=\"".$titulo."\"><div class=\"media-content\"><h5 class=\"text-bold-700 text-base\">".self::ajustaValor($valor)."</h5><h6><a class=\"text-dark text-base-hover\" href=\"imovel.php?id=".$codigo."\">".$titulo."</a></h6><p class=\"address\">".$extra."</p></div></li>";
	}

	public function similares($codigo, $titulo, $extra, $valor, $dormitorios, $vagas, $area, $foto, $tag1, $tag2, $stamp) {
			return '<div class="col-md-6"> <div class="property bg-white m-bottom-30 box-shadow-1 box-shadow-3-hover"> <div class="property-media overlay-wrapper"> <img class="full-width" src="/th.php?l=350&a=240&crop=0&path=painel/fotos/'.$codigo.'/'.$foto.'" alt="'.$titulo.'"> <div class="media-data"> <div class="position-bottom"> <div class="badge badge-warning pull-left m-right-8 p-top-8 p-right-12 p-bottom-8 p-left-12 rounded-0">'.$tag1.'</div><div class="badge badge-success pull-left p-top-8 p-right-12 p-bottom-8 p-left-12 rounded-0">'.$tag2.'</div></div></div><div class="overlay bg-bg opacity-9"></div></div><div class="property-section p-left-15 p-right-15"> <div class="m-top-20 m-bottom-20"> <h2 class="text-base text-bold-700 m-top-15">'.self::ajustaValor($valor).'</h2> <h5><a class="text-bold-600 text-dark text-base-hover" href="single-property.html">'.$titulo.'</a></h5> <p>'.$extra.'</p><ul class="icon-list list-inline m-bottom-0"> <li class="list-inline-item"><i class="btn btn-base fa fa-bed"></i>'.$dormitorios.' dormitórios</li><li class="list-inline-item"><i class="btn btn-base fa fa-car"></i> '.$vagas.' vagas</li><li class="list-inline-item"><i class="btn btn-base fa fa-expand"></i>'.$area.' m²</li></ul> </div></div><div class="bg-light-3 text-size-13 text-muted p-top-15 p-right-15 p-bottom-15 p-left-15"> <ul class="list-unstyled d-flex justify-content-between m-bottom-0"> <li><i class="m-right-4 fa fa-calendar"></i>'.self::tempo_corrido($stamp).'</li><li><a href="#"><i class="m-right-4 fa fa-heart-o"></i> Salvar</a></li></ul> </div></div></div>';
	}

	private function ajustaValor($meuvalor){
		if ($meuvalor > 0) {
			return "R$ " . number_format($meuvalor, 2, ',', '.');
		} else {
			return "Consulte o Valor";
		}
	}

	private function tempo_corrido($time) {

	 $now = strtotime(date('m/d/Y H:i:s'));
	 $time = strtotime($time);
	 $diff = $now - $time;

	 $seconds = $diff;
	 $minutes = round($diff / 60);
	 $hours = round($diff / 3600);
	 $days = round($diff / 86400);
	 $weeks = round($diff / 604800);
	 $months = round($diff / 2419200);
	 $years = round($diff / 29030400);

	 if ($seconds <= 60)
	 	 return"1 min atrás";
		 else if ($minutes <= 60) return $minutes==1 ?'1 min atrás':$minutes.' min atrás';
		 else if ($hours <= 24) return $hours==1 ?'1 hrs atrás':$hours.' hrs atrás';
		 else if ($days <= 7) return $days==1 ?'1 dia atras':$days.' dias atrás';
		 else if ($weeks <= 4) return $weeks==1 ?'1 semana atrás':$weeks.' semanas atrás';
		 else if ($months <= 12) return $months == 1 ?'1 mês atrás':$months.' meses atrás';
		 else return $years == 1 ? 'um ano atrás':$years.' anos atrás';
	 }	
}


function alimovel($codigo, $titulo, $extra, $valor, $nota, $dormitorios, $vagas, $area, $foto, $tag1, $tag2) {
	if ($valor > 0) {
		$valor = "R$ " . number_format($valor, 2, ',', '.');
	} else {
		$valor = "Consulte o Valor";
	}

return '<li class="col-lg-4 col-md-6"> <div class="property bg-white m-bottom-30 box-shadow-1 box-shadow-3-hover"> <div class="property-media overlay-wrapper"> <img class="full-width" src="/th.php?l=350&a=240&crop=0&path=painel/fotos/'.$codigo.'/'.$foto.'" alt="'.$titulo.'"> <div class="media-data"> <div class="position-bottom"> <div class="badge badge-base pull-left m-right-8 p-top-8 p-right-12 p-bottom-8 p-left-12 rounded-0">'.$tag1.'</div><div class="badge badge-success pull-left p-top-8 p-right-12 p-bottom-8 p-left-12 rounded-0">'.$tag2.'</div></div></div><div class="overlay bg-bg opacity-9"></div></div><div class="property-section p-left-15 p-right-15"> <div class="m-top-20 m-bottom-20"> <h2 class="text-base text-bold-700 m-top-15">'.$valor.' <small class="text-size-14 text-muted">'.$nota.'</small></h2> <h5><a class="text-bold-600 text-dark text-base-hover" href="single-property.html">'.$titulo.'</a></h5> <p>'.$extra.'</p><ul class="icon-list list-inline m-bottom-0"> <li class="list-inline-item"><i class="btn btn-base fa fa-bed"></i> '.$dormitorios.' dormitórios</li><li class="list-inline-item"><i class="btn btn-base fa fa-tint"></i> '.$vagas.' vagas</li><li class="list-inline-item"><i class="btn btn-base fa fa-expand"></i> '.$area.' m²</li></ul> </div></div><div class="bg-light-3 text-size-13 text-muted p-top-15 p-right-15 p-bottom-15 p-left-15"> <ul class="list-unstyled d-flex justify-content-between m-bottom-0"> <li><i class="m-right-4 fa fa-calendar"></i> 1 day ago</li><li><a href="my-bookmarked.html" class="text-base"><i class="m-right-4 fa fa-heart-o"></i> Salvar</a></li></ul> </div></div></li>';
}



function pr_instagram() {
	return "<svg width=\"30\" height=\"30\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M16,6.16216c3.20414,0,3.58366.01222,4.849.06995a6.64012,6.64012,0,0,1,2.22824.4132,3.97394,3.97394,0,0,1,2.27743,2.27743,6.64009,6.64009,0,0,1,.4132,2.22822c.05773,1.26538.06995,1.6449.06995,4.849s-.01222,3.58366-.06995,4.849a6.64012,6.64012,0,0,1-.4132,2.22824,3.97394,3.97394,0,0,1-2.27743,2.27743,6.64012,6.64012,0,0,1-2.22824.4132c-1.26518.05773-1.64466.06995-4.849.06995s-3.58384-.01222-4.849-.06995a6.64012,6.64012,0,0,1-2.22824-.4132,3.97394,3.97394,0,0,1-2.27743-2.27743,6.64009,6.64009,0,0,1-.4132-2.22822c-.05773-1.26538-.06995-1.6449-.06995-4.849s.01222-3.58366.06995-4.849a6.64012,6.64012,0,0,1,.4132-2.22824A3.97394,3.97394,0,0,1,8.92274,6.64531a6.64009,6.64009,0,0,1,2.22822-.4132c1.26538-.05773,1.6449-.06995,4.849-.06995M16,4c-3.259,0-3.66766.0138-4.94758.0722A8.80773,8.80773,0,0,0,8.13953,4.63,6.136,6.136,0,0,0,4.63,8.13953a8.80773,8.80773,0,0,0-.55779,2.91289C4.0138,12.33234,4,12.741,4,16s.0138,3.66766.0722,4.94758A8.80773,8.80773,0,0,0,4.63,23.86047,6.136,6.136,0,0,0,8.13953,27.37a8.80773,8.80773,0,0,0,2.91289.55779C12.33234,27.98621,12.741,28,16,28s3.66766-.01379,4.94758-.0722A8.80773,8.80773,0,0,0,23.86047,27.37,6.136,6.136,0,0,0,27.37,23.86047a8.80773,8.80773,0,0,0,.55779-2.91289C27.9862,19.66766,28,19.259,28,16s-.0138-3.66766-.0722-4.94758A8.80773,8.80773,0,0,0,27.37,8.13953,6.136,6.136,0,0,0,23.86047,4.63a8.80773,8.80773,0,0,0-2.91289-.55779C19.66766,4.0138,19.259,4,16,4Zm0,5.83784A6.16216,6.16216,0,1,0,22.16216,16,6.16216,6.16216,0,0,0,16,9.83784ZM16,20a4,4,0,1,1,4-4A4,4,0,0,1,16,20ZM22.40563,8.15437a1.44,1.44,0,1,0,1.44,1.44A1.44,1.44,0,0,0,22.40563,8.15437Z\" fill=\"#fff\"/></svg>";
}

function pr_pinterest() {
	return "<svg width=\"30\" height=\"30\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M28,16a12.00826,12.00826,0,0,1-15.55306,11.4649A13.41393,13.41393,0,0,0,13.93843,24.319c.14588-.56144.74756-2.85262.74756-2.85262a3.21172,3.21172,0,0,0,2.75037,1.37792c3.61935,0,6.227-3.32835,6.227-7.464,0-3.96431-3.2351-6.93061-7.39786-6.93061-5.1785,0-7.92881,3.4763-7.92881,7.2617,0,1.76.937,3.95118,2.4358,4.64884.22735.10574.34892.05919.40129-.16049.03974-.16677.24218-.98182.3333-1.3609a.35883.35883,0,0,0-.08325-.34415,4.66806,4.66806,0,0,1-.893-2.73852,5.19418,5.19418,0,0,1,5.41849-5.20767,4.73706,4.73706,0,0,1,5.01246,4.882c0,3.24624-1.63942,5.49513-3.77227,5.49513a1.7423,1.7423,0,0,1-1.777-2.16843,24.17178,24.17178,0,0,0,.99388-3.99545A1.50755,1.50755,0,0,0,14.888,13.07141c-1.2042,0-2.17132,1.24572-2.17132,2.9143a4.33223,4.33223,0,0,0,.359,1.7816s-1.18915,5.0283-1.40715,5.96483a11.52936,11.52936,0,0,0-.04161,3.44608A12.00139,12.00139,0,1,1,28,16Z\" fill=\"#fff\"/></svg>";
}


function pr_facebook() {
	return "<svg width=\"30\" height=\"30\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M27.99993,5.32469v21.3509a1.32468,1.32468,0,0,1-1.32457,1.32461H20.5595V18.7061h3.11971l.46705-3.6221H20.5595V12.77145c0-1.0487.2912-1.76335,1.79509-1.76335l1.918-.00088V7.76765a25.66255,25.66255,0,0,0-2.79492-.14271c-2.76537,0-4.6586,1.688-4.6586,4.78787V15.084H13.69145v3.6221H16.8191v9.2941H5.32455a1.32452,1.32452,0,0,1-1.32462-1.32461V5.32469A1.32442,1.32442,0,0,1,5.32455,4.00007H26.67536A1.32457,1.32457,0,0,1,27.99993,5.32469Z\" fill=\"#fff\"/></svg>";
}

function pr_youtube() {
	return "<svg width=\"30\" height=\"30\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M28.24034,9.81073A3.21021,3.21021,0,0,0,25.9816,7.53732C23.9892,7,16,7,16,7s-7.98921,0-9.9816.53732A3.21021,3.21021,0,0,0,3.75967,9.81073,33.67486,33.67486,0,0,0,3.2258,16a33.6751,33.6751,0,0,0,.53387,6.18928,3.21018,3.21018,0,0,0,2.25874,2.27339C8.0108,25,16,25,16,25s7.98919,0,9.98159-.53734a3.21018,3.21018,0,0,0,2.25874-2.27339A33.67633,33.67633,0,0,0,28.77419,16,33.6761,33.6761,0,0,0,28.24034,9.81073ZM13.3871,19.7987V12.2013l6.67742,3.79882Z\" fill=\"#fff\"/></svg>";

}

function pr_twitter() {
	return "<svg width=\"30\" height=\"30\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M26.32865,10.20428c.01043.22891.01043.45778.01043.6867A15.18194,15.18194,0,0,1,2.99214,23.68808a10.26487,10.26487,0,0,0,1.26929.07283A10.70029,10.70029,0,0,0,10.8889,21.472a5.33486,5.33486,0,0,1-4.9836-3.70387,5.36636,5.36636,0,0,0,2.40336-.09364,5.34632,5.34632,0,0,1-4.2761-5.23331v-.07283a5.39627,5.39627,0,0,0,2.41374.6659A5.35659,5.35659,0,0,1,4.79205,5.90738,15.1498,15.1498,0,0,0,15.78924,11.484a5.89821,5.89821,0,0,1-.13524-1.21727,5.33642,5.33642,0,0,1,9.22847-3.65189,10.61188,10.61188,0,0,0,3.3918-1.2901A5.368,5.368,0,0,1,25.9229,8.27951a10.81127,10.81127,0,0,0,3.06924-.84274A10.868,10.868,0,0,1,26.32865,10.20428Z\" fill=\"#fff\"/></svg>";

}

function pr_whatsapp() {
	return "<svg width=\"30\" height=\"30\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M24.39552,7.5552A11.84119,11.84119,0,0,0,5.76286,21.83936L4.08333,27.974l6.27577-1.64631a11.82686,11.82686,0,0,0,5.65732,1.44094h.00485A11.84352,11.84352,0,0,0,24.39552,7.5552Zm-8.37425,18.214h-.004a9.82365,9.82365,0,0,1-5.00812-1.37153l-.35931-.21316-3.72411.97686.99406-3.631-.234-.37238a9.83953,9.83953,0,1,1,8.33545,4.61117Zm5.39722-7.36933c-.29582-.14806-1.75008-.86356-2.02126-.96235s-.46835-.14806-.66551.14806-.76405.96247-.93669,1.15981c-.17246.19734-.345.22215-.64081.07409a8.08074,8.08074,0,0,1-2.37877-1.46816,8.91445,8.91445,0,0,1-1.6456-2.04926c-.17252-.296-.01834-.45618.12972-.60364.13308-.1326.29583-.34552.44371-.51828a2.01944,2.01944,0,0,0,.29577-.49334.54473.54473,0,0,0-.02464-.51828c-.074-.14807-.6655-1.60412-.912-2.19649-.24013-.57666-.484-.4985-.66556-.50773-.17234-.00851-.36974-.01043-.56689-.01043a1.08675,1.08675,0,0,0-.78881.37022,3.31746,3.31746,0,0,0-1.0353,2.46767,5.75316,5.75316,0,0,0,1.20782,3.05993,13.18546,13.18546,0,0,0,5.05314,4.46658,17.00685,17.00685,0,0,0,1.68629.62306,4.05344,4.05344,0,0,0,1.8632.11713,3.04616,3.04616,0,0,0,1.99657-1.40641,2.47268,2.47268,0,0,0,.17252-1.40666C21.91148,18.622,21.71426,18.54805,21.41849,18.39987Z\" fill=\"#fff\"/></svg>";
}
?>