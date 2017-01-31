<?php namespace Xpbox\SmartForm\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Cms\Classes\Theme;
use Xpbox\Smartform\Models\Leads;
use Mail;
use Log;
use Twig;


class Orcamento extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'smartform:orcamento';

    /**
     * @var string The console command description.
     */
    protected $description = 'Cria orçamentos';

    /**
     * Execute the console command.
     * @return void
     */
    public function fire()
    {
        $this->output->writeln('Gerando orçamento');

        $dados = [
            'nome' => $this->argument('nome_contato'),
            'email' => $this->argument('email_contato'),
            'telefone' => $this->argument('telefone_contato'),
            'data' => $this->getCurrentDateFormated(),
        ];
        
        $urlProposta = $this->getLocalFileURL($this->argument('main'));
        $urlFooter = $this->getLocalFileURL($this->argument('footer'));
        $urlHeader = $this->getLocalFileURL($this->argument('header'));
        $urlEmail = $this->getLocalFileURL($this->argument('email'));

        $urlProposta = $this->makeFileTemp($urlProposta, $dados);
        $temp_file = temp_path() . DIRECTORY_SEPARATOR . 'PROPOSTA-' . time() . '.pdf';

        $cmd = sprintf("wkhtmltopdf --no-footer-line --no-header-line --header-html %s --footer-html %s %s %s", 
                        escapeshellarg($urlHeader), 
                        escapeshellarg($urlFooter), 
                        escapeshellarg($urlProposta), 
                        escapeshellarg($temp_file)
                    );
        $handle = popen("$cmd 2>&1", 'r');
        
        while(!feof($handle)) {
            fread($handle, 1024);
        }

        fclose($handle); 
        // shell_exec($cmd);
        $this->output->writeln($cmd);
        
        $emailContent = $this->getEmailContent($urlEmail, $dados);
        Log::error($dados);
        Mail::send(['html'=>$emailContent, 'raw'=>true], [], function ($message) use ($temp_file, $dados) {
            $message->subject("Proposta - Olimpio Contabilidade");
            $message->to($dados['email']);
            
            $message->attach($temp_file);
        });
    }

    private function makeFileTemp($localFileURI, array $args = [])
    {
        $tmpHtmlFile = temp_path() . DIRECTORY_SEPARATOR . 'PROPOSTA-HTML' . time() . '.html';
        $contentParsed = Twig::parse(file_get_contents($localFileURI), $args);
        file_put_contents($tmpHtmlFile, $contentParsed);

        return $tmpHtmlFile;
    }
    private function getLocalFileURL($fileName)
    {
        $activeTheme = Theme::getActiveTheme();

        return 'file://' . themes_path($activeTheme->getDirName()) . 
                DIRECTORY_SEPARATOR . 'propostas' . DIRECTORY_SEPARATOR . ltrim($fileName, '/');
    }

    private function getEmailContent($localFileURI, array $args = [])
    {
        return Twig::parse(file_get_contents($localFileURI), $args);
    }

    private function getCurrentDateFormated()
    {
        $mes = (int) date('m');

        switch ($mes) {
            case 1:
                $mes = 'janeiro';
                break;
            case 2:
                $mes = 'fevereiro';
                break;
            case 2:
                $mes = 'março';
                break;
            case 4:
                $mes = 'abril';
                break;
            case 5:
                $mes = 'maio';
                break;
            case 6:
                $mes = 'junho';
                break;
            case 7:
                $mes = 'julho';
                break;
            case 8:
                $mes = 'agosto';
                break;
            case 9:
                $mes = 'setembro';
                break;
            case 10:
                $mes = 'outubro';
                break;
            case 11:
                $mes = 'novembro';
                break;
            case 12:
                $mes = 'dezembro';
                break;
            default:
                break;
        }

        return date('d') . ' de ' . $mes . ' de ' . date('Y');
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['header', InputArgument::REQUIRED, 'URL da página do header do orçamento'],
            ['footer', InputArgument::REQUIRED, 'URL da página footer do orçamento'],
            ['main', InputArgument::REQUIRED, 'URL da página principal do orçamento'],
            ['email', InputArgument::REQUIRED, 'URL da página HTML com o texto do e-mail'],
            ['email_contato', InputArgument::REQUIRED, 'Nome do contato'],
            ['nome_contato', InputArgument::REQUIRED, 'E-mail do contato'],
            ['telefone_contato', InputArgument::REQUIRED, 'Telefone do contato'],
        ];
    }

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }

}