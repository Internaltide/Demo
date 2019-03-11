<?php

namespace App\Exceptions;

use Log;
use RuntimeException;

class ActionException extends RuntimeException
{
    public function getTitle()
    {
        switch($this->code){
            case 10001:
                return '角色創建失敗';
                break;
            case 10002:
                return '使用者指派失敗';
                break;
            case '10003':
                return '角色刪除失敗';
                break;
            case 11001:
                return '角色創建部分成功';
                break;
            default:
                return '執行失敗';
                break;
        }
    }

    public function report()
    {
        if( preg_match('/^10[0-9]+/', $this->code) ){
            Log::channel('notify')->notice($this->getMessage(), ['title' => $this->getTitle()]);
        } else {
            Log::channel('notify')->info($this->getMessage(), ['title' => $this->getTitle()]);
        }
    }
}