<?php

/**
 * 1° ler o json
 * 2° for para ler a lista de dados
 * 3° gerar token de acesso
 * 4 ° fazer requisção para api enviando dados
 * 5° validar retorno
 */


    /**
     * gerando o token url, e json no body com login e senha
     */
    $resToken = post('/api/Security/Login', ["Login"=>'' ,"Senha"=>'']);


    if(isset($resToken['http_code']))
    {
        //validar se é 200 ,ou 201
        //percorrer a lista e montar o json e tratar retorno

        var_dump($resToken['http_code']);

    }else{
        echo "Erro na geração do token".PHP_EOL;
        exit;
    }




/**
 * @param $endPoint url de requisição
 * @param $jsonData json no body da requisição
 * @param false $token token gerado na autenticação
 * @return array
 * @throws Exception
 *
 */

function post($endPoint,$jsonData,$token=false)
{
    try {

        $res = [];

        if($token){
            $headers 	= 'Authorization: Bearer ' . $token;
        }else{
            $headers = null;
        }

        if(is_array($jsonData)){
            $jsonData = json_encode($jsonData);
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $endPoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $jsonData,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                $headers
            ),
        ));

        $response = curl_exec($curl);

         $res['http_code'] =  curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        $res['retorno'] = $response;

        return $res;

    }catch(Exception $e){
        throw new Exception("Erro no método POST");
    }
}