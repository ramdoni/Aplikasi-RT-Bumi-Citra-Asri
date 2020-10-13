<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendRemainder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendRemainder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $msg = "Assalamualaikum Wr. Wb, salam sejahtera untuk kita semua.\n";
        $msg = "Dengan hormat kami informasikan pembayaran iuran warga RT 01 RW 12 atas nama Bapak/Ibu ….. adalah sebagai berikut :";
        $msg = "bagi yang masih memiliki kekurangan, silahkan melakukan pembayaran iuran melalui perwakilan pengurus RT :";
        $msg = "Bapak Mistar C4/5\nBapak Sukma A2/1\nBapak Agung C2/22\nBapak Imam C2/8";
        $msg = "atau dapat juga melalui salah satu rekening dibawah ini :";
    }
}
