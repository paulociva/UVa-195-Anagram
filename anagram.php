<?php

try{
	$arquivo = 'input.txt';
	$linhas = @file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	if ($linhas[0] == count($linhas) - 1) {
		unset($linhas[0]);
		foreach ($linhas as $linha){
			$anagram = new Anagram($linha);
			print_r($anagram->anagramsOfpalavra());
		}
	}else{
		echo "Digito validador de argumentos diferente do numero de argumentos.";
	}
}catch(Exception $e){
	echo "Não foi possivel ler o arquivo.";
}

function anagram_order($a, $b){
	if(strtolower($a) == strtolower($b)){
		return $a>$b;
	}
	return strtolower($a) > strtolower($b);
}

class Anagram
{
	public $palavras = array();
	public $letras = array();
	public $validado = array();
	public $tamanhoPalavra;

	public function __construct($palavra)
	{
		$this->tamanhoPalavra = strlen($palavra);
		for($i = 0; $i < strlen($palavra); $i++) {
			$this->letras[] = $palavra[$i];
		}
		usort($this->letras, "anagram_order");
	}

	public function anagramsOfpalavra()
	{
		foreach($this->letras as $chave => $valor) {
			$this->validado[$chave] = 1;
			$this->permutacao($valor, 0);
			unset($this->validado[$chave]);
		}
		
		return $this->palavras;
	}

	public function permutacao($palavra, $posicao)
	{
		if($posicao >= $this->tamanhoPalavra-1) {
			if(!in_array($palavra, $this->palavras)) {
				$this->palavras[] = $palavra;
			}
			return;
		}

		for($n = 0; $n < $this->tamanhoPalavra; $n++) {
			if(!isset($this->validado[$n])) {
				$this->validado[$n] = 1;
				$this->permutacao($palavra . $this->letras[$n], $posicao+1);
				unset($this->validado[$n]);
			}
		}
	}
}