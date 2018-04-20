<?php

namespace App\Console\Commands;

use App\Models\Board;
use App\Models\Project;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification mails.';

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
        $sended = 0;
        $boards = Board::get();
        $toSend = [];
        foreach ($boards as $board){
            $board->meta = json_decode($board->meta);

            if(isset($board->meta->notification) && $daysBefore = $board->meta->notification > 0){
                $dateAfter = date('Y-m-d', strtotime($daysBefore . ' days'));

                $orm = $board->cards()
                    ->where('deadline', '<=', $dateAfter);

                $cards = $orm->with('user')->get();

                /*if(count($cards)){
                    $orm->update(['is_critical' => 1]);
                }*/

                foreach ($cards as $card){
                    if(! empty($card->project_id)) {
                        $card->board = $board;
                        $toSend[$card->project_id][] = $card;
                    }
                }
            }
        }

        foreach ($toSend as $key => $items){
            $km = null; //person to send mail
            $project = Project::where('id', $key)
                ->where('group_id', '>', 0)
                ->with(['group.usersGroups' => function ($q){
                    $q->with('user', 'role');
                 }])
                ->first();

            if(!isset($project)){
                echo "Prekakujem izbrisan projekt!\n";
                continue;
            }

            if(!isset($project->group)){
                echo "Prekakujem projekt: " . $project->board_name . " ker nima skupine\n";
                continue;
            }

            foreach ($project->group->usersGroups as $usersGroup){
                foreach ($usersGroup->role as $role){
                    if($role->role_id == 3){
                        $km = $usersGroup->user;
                        break;
                    }
                }
                if(isset($km))
                    break;
            }

            if(isset($km->email)){
                $sended++;
                //dd($km->email);
                $mail = $km->email;
                Mail::send('emails.notification', ['project' => $project, 'items' => $items], function ($message) use ($mail)
                {
                    $message->from('scrumban@admin.si', 'Scrumban sistem');

                    $message->to($mail);
                    $message->subject("Obvestilo o poteku roka");

                });

            }
        }

        echo "Poslanih: $sended";
    }
}
