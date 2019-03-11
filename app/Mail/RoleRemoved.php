<?php

namespace App\Mail;

use Storage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RoleRemoved extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->url = route("user.perm");
        $this->onConnection('mailqueue')->onQueue('permManageMails');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->from('permManage@whatsoft.com')
                            ->subject('[Backend Manager Notify] There was an role data has been deleted!!')
                            ->markdown('emails.permission.roleRemoved')
                            ->with([
                                'logs' => $this->getActivityLog()
                            ]);

        /*$mail->attach(storage_path("logs/{$todayActivity}"), [
            'as' => date('Ymd').".log",
            'mime' => 'text/plain',
        ]);*/

        return $mail;
    }

    private function getActivityLog()
    {
        $todayActivity = "activity-" . date('Y-m-d') . ".log";
        $exists = Storage::disk('logs')->exists($todayActivity);
        if( $exists ){
            $logs = explode("\n",Storage::disk('logs')->get($todayActivity));
            foreach($logs as $log){
                $logObj = $this->parseActivityLog($log);
                if( $logObj!==false ){
                    $logset[] = $logObj;
                }
            }
        }

        return (isset($logset)) ? $logset:[
            (object)[
                'date' => '-',
                'time' => '-',
                'delRole' => '-',
                'username' => '-'
            ]
        ];
    }

    // TODO: 解除與Log Format的耦合
    // TODO: 將正則統一在一個類別處理
    private function parseActivityLog($log)
    {
        preg_match('/^\[([0-9]{4}-[0-9]{2}-[0-9]{2})\s+([0-9]{2}:[0-9]{2}:[0-9]{2})\]\s+([.:a-zA-Z]+)\s+([\x{4e00}-\x{9fa5} \S]+)\s+([\{\}\",:\x{4e00}-\x{9fa5} \S]+)$/u',$log,$tmpArr);

        if(sizeof($tmpArr)>=5) $obj =  json_decode($tmpArr[5]);

        if( isset($obj->delRole) ){
            if( !isset($obj->username) ) $obj->username = 'Unknown';
            $obj->date = $tmpArr[1];
            $obj->time = $tmpArr[2];
            return $obj;
        }
        return false;
    }
}
