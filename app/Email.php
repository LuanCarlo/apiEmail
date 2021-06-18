<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    /**
     * função responsavel transformar uma string em um array de emails
     *
     * @return arrays
     */
    public static function filter($emails)
    {
        
        //transforma o texto (lista de emails) em array, e remove itens repetidos
        $arrayEmails = array_unique(explode(" ", $emails));

        foreach ($arrayEmails as $key => $value) {

            //função nativa do php para validar email
            if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
                unset($arrayEmails[$key]);
            }
        }

        return $arrayEmails;
    }


    /**
     * função responsavel por ordenar o array
     *
     * @return void
     */
    public static function sort($arrayEmails)
    {    	
    	asort($arrayEmails);

        return $arrayEmails;
    }

     /**
     * função responsavel por enviar email (simulação) retorna um numero randomio 0 ou 1 
     pra dizer se o email simulado foi enviado ou não
     *
     * @return void
     */
    public static function send($subject, $body, $email)
    {    	
    	$send = array(
    		'to'=>$email,
    		'from'=>'noreply@email.com',
    		'subject'=> $subject,
    		'text'=>$body
    	);

        return rand(0, 1);
    }
}
