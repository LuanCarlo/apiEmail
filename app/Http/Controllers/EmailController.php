<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Email;

class EmailController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * função responsavel por criar um novo arquivo com os emails recebidos
     *
     * @return array
     */
    public function salvaEmails(Request $request)
    {

        
        $conteudo = $request->input('emails');

        //cria e ordena um array de emails
        $arrayEmails = Email::sort(Email::filter($conteudo));

        $emailsValidos = implode("\n", $arrayEmails);

        $nomeArquivo = '../resources/arquivos/emails_'.date("Y-m-d-h-i-s").'.txt';
        // Cria arquivo txt
        file_put_contents($nomeArquivo, $emailsValidos);

        
        $retorno = array(
            'success'=>true,
            'msg'=>'emails salvos com sucesso'

        );

        return $retorno;
    }

    /**
     * função responsavel por criar um novo arquivo com os emails recebidos
     *
     * @return void
     */
    public function sendEmails(Request $request)
    {
        
        $subject = $request->input('subject');
        $body = $request->input('body');

        $dir = '../resources/arquivos/';
        $files = scandir($dir);

        $emails = 0;
        $emails_sent = 0;
        $emails_fail = 0;

        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {

                $caminhoArquivo = '../resources/arquivos/'.$file;
                $arquivo = fopen ($caminhoArquivo, 'r');
                while (!feof($arquivo)) {
                    $email = fgets($arquivo);
                    $envio = Email::send($subject, $body, $email);
                    $emails++;

                    if ($envio = 1) {
                        $emails_sent++;
                    } else {
                        $emails_fail++;
                    }
                }
                
                fclose($arquivo);

                $retorno =  array(
                    'emails' => $emails,
                    'emails_sent' => $emails_sent,
                    'emails_fail' => $emails_fail 
                );
            }
        }        

        return json_encode($retorno);
    }

    //
}
