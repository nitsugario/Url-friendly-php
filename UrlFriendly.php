<?php
/*!
*
* Title: URLs Amigables / friendly URLs
* Name: UrlFriendly.
* Description: Crea o corrige los nombres de URLs amigables para los estándares de Google.
*
* Copyright (c) 2016
* Author: Agustin Rios Reyes.
* Email:  nitsugario@gmail.com
*
* Launch  : Octubre 2016
* Version : 1.0
* Released: Jueves 13 del 2016
*
* Updates:
*  Date:
*  Description update:
*
* Licensed under MIT
* http://www.opensource.org/licenses/mit-license.php
*
*/

class UrlFriendly
{
	/**
     * Convierte todas las entidades HTML a sus caracteres correspondientes.
     * @var boolean
     */
	private $lboDecode = true;
	/**
     * charset a usar si $decode es true.
     * @var string
     */
	private $lstDecodeCharset = 'UTF-8';
	/**
     * comvertir la cadena en minúsculas.
     * @var boolean
     */
    private $lboLowercase = true;
    /**
     * Retira las etiquetas HTML y PHP de la cadena.
     * @var boolean
     */
    private $lboStrip = true;
    /**
     * Longitud máxima de caracteres de una URL.
     * @var int
     */
    private $lnuMaxlength = 70;
    /**
     * Si se alcanza el $lnuMaxlength se profundiza en la cadena quitando la última palabra.
     * @var boolean
     */
    private $lboWholeWord = true;
    /**
     * Permite que un carácter diferente a - pueda ser utilizado como separador.
     * @var string
     */
    private $lstSeparador = '-';
     /**
     * Si se alcanza el $lnuMaxlength se profundiza en la cadena quitando la última palabra.
     * @var boolean
     */
     private $lboEliminaStopWords = false;
     /**
     * Es la cadena que será convertida en una URL valida.
     * @var string
     */
     private $lstTextoUrl = '';
    /**
     * Una tabla de caracteres UTF-8 especiales que se cambiaran.
     * @var array
     */
    private $layTablaEspeciales = array(
        'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj','Ð'=>'Dj','đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'ç'=>'c', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
        'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
        'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
        'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'ü'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
        'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r', 'ğ'=>'g', "'"=> '', 'ı'=>'i', 'ş'=>'s', '&'=>'and', "\r\n"=>'-', "\n"=>'-');
    /**
     * Palabras que pueden ser omitidas en una URL, consideradas stop words.
     * @var array
     *
     */
	private $layStopWords = array( 
		//|---------------------------Artículos------------| 
		'el','la','los','las','un','una','uno','unas','unos',
		//|---------------------------preposiciones--------|
		'a','de','ante','bajo','cabe','con','contra','desde','durante','en','entre','hacia','hasta','mediante','para','por','según','sin','so','sobre','tras','versus','via',
		//|---------------------------pronombres---------------------------|
		'yo','me','mi','nos','nosotros','nosotras','conmigo','te','ti','tu','os','ustedes','vos','vosotras','vosotros','contigo','ella','ellas','ellos','ello','lo','les','se','si',
		'aquellas','aquella','aquellos','aquel','esas','esa','esos','ese','esotra','esotro','esta','estas','estos','este','estotro','estotra','mia','mias','mio','mios','nuestra','nuestras',
		'nuestro','nuestros','suya','suyas','suyo','suyos','tuya','tuyas','tuyo','tuyos','vuestra','vuestras','vuestros','vuestro','algo','alguien','alguna','algunas','alguno','algunos','cualesquiera',
		'cualquiera','demas','mismas','misma','mismo','mismos','muchas','mucha','mucho','muchos','nada','nadie','ninguna','ningunas','ninguno','ningunos','otra','otro','otras','otros','poca','pocas','poco',
		'pocos','quienquier','quienesquiera','quienquiera','tanta','tantas','tanto','tantos','toda','todas','todo','todos','ultima','ultimas','ultimo','ultimos','varios','varias','adonde','como','cual','cuales',
		'cuando','cuanta','cuantas','cuanto','cuantos','donde','que','quien','quienes','cuya','cuyas','cuyo','cuyos');

	public function setDecode          ( $pboDecode           ){ $this->lboDecode           = $pboDecode;          }
	public function setDecodeCharset   ( $pstDecodeCharset    ){ $this->lstDecodeCharset    = $pstDecodeCharset;   }
	public function setLowercase       ( $pboLowercase        ){ $this->lboLowercase        = $pboLowercase;       }
	public function setStrip           ( $pboStrip            ){ $this->lboStrip            = $pboStrip;           }
	public function setMaxlength       ( $pnuMaxlength        ){ $this->lnuMaxlength        = $pnuMaxlength;       }
	public function setWholeWord       ( $pboWholeWord        ){ $this->lboWholeWord        = $pboWholeWord;       }
	public function setSeparador       ( $pstSeparador        ){ $this->lstSeparador        = $pstSeparador;       }
	public function setEliminaStopWords( $pboEliminaStopWords ){ $this->lboEliminaStopWords = $pboEliminaStopWords;}
	public function setTextoUrl        ( $pstTextoUrl         ){ $this->lstTextoUrl         = $pstTextoUrl;        }
	public function setTablaEspeciales ( $payTablaEspeciales = array() ){ $this->layTablaEspeciales  = $payTablaEspeciales; }
	public function setStopWords       ( $payStopWords       = array() ){ $this->layStopWords        = $payStopWords;       }

	/**
	* Método que regresa una URL valida.
	*
	* @param string $lstTextoUrl
	* @return string
	*/
	public function getUrlFriendly()
	{
		return $this->mstCreaUrl( $this->lstTextoUrl );
	}

	/**
	* Método que cambia los caracteres especiales por caracteres válidos para la URL.
	*
	* @param string $pstTextoUrl
	* @return string
	*/
	protected function mstConvierteCaracteres( $pstTextoUrl )
	{
		$lstTexto = html_entity_decode($pstTextoUrl, ENT_QUOTES, $this->lstDecodeCharset);
		$lstTexto = strtr($lstTexto, $this->layTablaEspeciales);
		return $lstTexto;
	}

	/**
	* Método que crea la URL validas, sin omitir los Stop Words
	*
	* @param string $pstTextoUrl
	* @return string
	*/
	protected function mstCreaUrl( $pstTextoUrl )
	{
		$lstSeparador = $this->lstSeparador;
		$lstTextoUrl  = $pstTextoUrl;

		//Eliminar las palabras consideradas stop words
		if( $this->lboEliminaStopWords )
			$lstTextoUrl = $this->mstQuitaStopWordsURL( $lstTextoUrl );
		//Preparamos la cadena sin los caracteres especiales
		if ($this->lboDecode)
			$lstTextoUrl = $this->mstConvierteCaracteres(  $lstTextoUrl );
		//Convierte una cadena a minúsculas
		if ($this->lboLowercase)
			$lstTextoUrl = strtolower( $lstTextoUrl );
		//Retira las etiquetas HTML y PHP de un string
		if ($this->lboStrip)
			$lstTextoUrl = strip_tags( $lstTextoUrl );

		//filtramos solo los caracteres validos.
		$lstTextoUrl = preg_replace("/[^&a-z0-9_\s\-%']/i", '', $lstTextoUrl);
		//los espasios son sustituidos por -
		$lstTextoUrl = str_replace(' ', $lstSeparador, $lstTextoUrl);
		//los giones bajos son sustituidos por -
		$lstTextoUrl = str_replace('_', $lstSeparador, $lstTextoUrl);
		//se valida si son mas de - guntos solo se deja uno
		$lstTextoUrl = trim(preg_replace("/{$lstSeparador}{2,}/", $lstSeparador, $lstTextoUrl), $lstSeparador);

		//validar el tamaño de la cadena 
		if (strlen($lstTextoUrl) > $this->lnuMaxlength)
		{
			$lstTextoUrl = substr($lstTextoUrl, 0, $this->lnuMaxlength);

			if ($this->lboWholeWord)
			{
				$layPalabras      = explode($lstSeparador, $lstTextoUrl);
				$lstTextoUrlTemp  = implode($lstSeparador, array_diff($layPalabras, array(array_pop($layPalabras))));

				if ($lstTextoUrlTemp != '')
				{
					$lstTextoUrl = $lstTextoUrlTemp;
				}
			}
		}

		if ($lstTextoUrl == '')
		{
			return null;
		}

		return $lstTextoUrl;
	}

	/**
	* Método que elimina las palabras Stop Words de la URL, que se indican en $layStopWords.
	*
	* @param string $pstTextoUrl
	* @return string
	*
	*/
	protected function mstQuitaStopWordsURL( $pstTextoUrl )
	{
		$layPalabras      = explode(' ', strtolower($pstTextoUrl) );
		$lstTextoUrlTemp  = implode(' ', array_diff($layPalabras, $this->layStopWords) );

		return $lstTextoUrlTemp;
	}
}
?>