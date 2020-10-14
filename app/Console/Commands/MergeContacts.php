<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MergeContacts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:contacts-merge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Merge all contacts with the same e-mail to one';

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
        $mails = \App\Models\Contact::distinct()->pluck('email');
        foreach($mails as $mail){
            echo $mail.":\n";
            $ids = $this->getContactIds($mail);
            // print_r($ids)."\n"."\n";;
            if(count($ids) > 1){
                $this->removeUnnecessaryContacts($ids);
            }
        }
    }

    protected function getContactIds($mail)
    {
        $ids = \App\Models\Contact::where('email',$mail)->orderBy('id', 'desc')->pluck('id')->toArray();
        return $ids;
    }

    protected function removeUnnecessaryContacts($ids)
    {
        $latest = array_shift($ids);
        echo "IDS: ";
        print_r($ids);
        DB::table('contact_customer')->whereIn( 'contact_id',(array)$ids)->update(['contact_id' => $latest]);
        DB::table('contact_supplier')->whereIn( 'contact_id',(array)$ids)->update(['contact_id' => $latest]);
        DB::table('contacts')->whereIn( 'id',$ids)->delete();
        // print_r($contacts);
    }

}
