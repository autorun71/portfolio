<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public $messInterface = [
        "from" => 0,
        "to" => 0,
        "text" => null,
        "edit_status" => 0,
        "read_status" => 0,
        "show_to" => 1,
        "show_from" => 1,
        "enable" => 1,
    ];

    public function getDialog(Request $request, $check = false)
    {
        $id = $request->id;
        $sendId = $request->send_id;
        $id = (int)$id;
        $dialogs = [];
        if ($id > 0) {

            $mes = new Message();
            $dialog = $mes
                ->where('to', $id)
                ->where('from', $sendId)
                ->orWhere(['to' => $sendId, 'from' => $id])
                ->get();
            $dialog = DB::select(
                "SELECT
                    *
                    FROM `messages`

                    WHERE enable = 1
                        AND (
                            (`to` = {$id} AND `from` = {$sendId})  OR (`to` = {$sendId} AND `from` = {$id})
                            )
                    ORDER BY id asc"
            );


            $user = new User();
            $userInfo = $user->whereId($sendId)->get()->toArray()[0];

            $sender = 2;
            foreach ($dialog as $item) {
                $item = (array)$item;


                if ($item['created_at']) {
                    $dateM = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item['created_at'])->format('Y-m-d');
                    if ($dateM == date('Y-m-d', time() + 3 * 3600)) {
                        $time = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item['created_at'])->format('H:i:s');

                    } elseif ($dateM == \Carbon\Carbon::yesterday('Europe/Moscow')->format('Y-m-d')) {
                        $time = "вчера";

                    } elseif (\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',
                            $item['created_at'])->format('Y') != date("Y", time() + 3 * 3600)) {
                        $time = $time = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',
                            $item['created_at'])->format('d.m.Y H:i');

                    } else {
                        $time = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item['created_at'])->format('d.m H:i');

                    }
                } else {
                    $time = "00:00";
                }

                $senderTmp = ($item['from'] == $id ? 1 : 0);
                $showName = ($sender == $senderTmp) ? 0 : 1;
                $sender = $senderTmp;
                $rItem = [
                    "message" => [
                        "id" => $item['id'],
                        "sender" => ($item['from'] == $id ? 1 : 0),
                        "show_name" => $showName,
                        "text" => $item['text'],
                        "read_status" => $item['read_status'],
                        "edit_status" => $item['edit_status'],
                        "show_to" => $item['show_to'],
                        "show_from" => $item['show_from'],
                        "time" => $time
                    ]

                ];
                $rItem['id'] = $item['from'];


                $dialogs[] = $rItem;

            }
            $dialogs = array_merge($dialogs);

            if ($check === true) {


                return $dialogs;
            }
//            foreach ($dialogs)
            return response()->json(["user" => $userInfo, "dialog" => $dialogs]);


        }
    }

    public function getDialogs(Request $request, $check = false)
    {
        $id = $request->id;
        $id = (int)$id;
        $dialogs = [];
        if ($id > 0) {


            $user = DB::select(
                "SELECT
                    t.`text`, t.`from`, t.`to`, t.`created_at`, t.`id` , t.`edit_status`, t.`read_status`, t.`read_status`,t.`show_to`, t.`show_from`,
                    uf.`name` as from_name, uf.`last_name` as from_last_name, uf.`main_photo` as from_main_photo,
                    ut.`name` as to_name , ut.`last_name` as to_last_name, ut.`main_photo` as to_main_photo
                    FROM `messages` t
                    JOIN (
                        SELECT max(`id`) as `u_id`
                            FROM `messages`
                            GROUP BY `from`, `to`
                    ) as t1 ON t.`id`= t1.`u_id`
                    LEFT JOIN users as uf
                        ON uf.id = t.from
                    LEFT JOIN users as ut
                        ON ut.id = t.to
                    WHERE t.enable = 1 AND (t.to = {$id} OR t.from = {$id})
                    ORDER BY t.id desc"
            );

            foreach ($user as $item) {
                $item = (array)$item;

                if ($item['from'] != $id) {
                    $key = $item['from'];
                } elseif ($item['to'] != $id) {
                    $key = $item['to'];
                } else {
                    $key = $id;
                }
                if (empty($dialogs[$key])) {
//                    $dateM = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item['created_at'])->format('Y-m-d');
//                    if ($dateM == date('Y-m-d', time() + 3 * 3600)) {
//                        $time = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item['created_at'])->format('H:i');
//
//                    } elseif ($dateM == \Carbon\Carbon::yesterday('Europe/Moscow')->format('Y-m-d')) {
//                        $time = "вчера";
//
//                    } elseif (\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item['created_at'])->format('Y') != date("Y", time() + 3 * 3600)) {
//                        $time = $time = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item['created_at'])->format('d.m.Y');
//
//                    } else {
//                        $time = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item['created_at'])->format('d.m');
//
//                    }
                    $time = '1.1.1';

                    $sender = ($item['from'] == $id ? 1 : 0);

                    $rItem = [
                        "message" => [
                            "id" => $item['id'],
                            "sender" => $sender,

                            "text" => $item['text'],
                            "read_status" => $item['read_status'],
                            "edit_status" => $item['edit_status'],
                            "show_to" => $item['show_to'],
                            "show_from" => $item['show_from'],
                            "time" => $time
                        ]

                    ];
                    if ($item['to'] != $id) {
                        $rItem['id'] = $item['to'];
                        $rItem['name'] = $item['to_name'];
                        $rItem['last_name'] = $item['to_last_name'];
                        $rItem['avatar'] = $item['to_main_photo'];
                    } else {
                        $rItem['id'] = $item['from'];
                        $rItem['name'] = $item['from_name'];
                        $rItem['last_name'] = $item['from_last_name'];
                        $rItem['avatar'] = $item['from_main_photo'];
                    }


                    $dialogs[$key] = $rItem;
                }
            }

            $dialogs = array_merge($dialogs);

            if ($check) {
                return $dialogs;
            }
//            foreach ($dialogs)
            return response()->json($dialogs);


        }
    }

    public function getMessMd5(Request $request)
    {
        $id = $request->id;
        $id = (int)$id;
        if ($id > 0) {
            $data = $this->getDialogs($request, 1);
            $messArr = [];

            foreach ($data as $item) {
                $messArr[] = $item['message']['id'];
                $messArr[] = $item['message']['text'];
                $messArr[] = $item['message']['edit_status'];
                $messArr[] = $item['message']['read_status'];
                $messArr[] = $item['message']['show_to'];
                $messArr[] = $item['message']['show_from'];
            }

            $messStr = implode('', $messArr);
            return md5($messStr);


        }
    }

    public function checkMess(Request $request)
    {
        $id = $request->id;
        $hash = $request->h;


        $id = (int)$id;
        if ($id > 0 && !empty($hash)) {
            $time = time();
            $load = rand(4, 12);
            $u = time() >= $time + $load;

            $nTime = time();
            $data = $hash;
            $event = false;
            while (!$u) {
                if ($nTime != time()) {
                    $data2 = $this->getMessMd5($request);
                    if ($data != $data2) {
                        $event = true;
                        break;
                    }
                }
                $u = (time() >= $time + $load ? true : false);
            }

            $out = ['status' => $event, 'dialogs' => null];
            if ($event) {
                $out['dialogs'] = $this->getDialogs($request, 1);
            }
            return response()->json($out);
        }

    }

    public function addMess(Request $request, Message $message)
    {
        $postParams = [];
        if ($request->send_id)
            $postParams["id"] = $request->send_id;
        if ($request->recipient_id)
            $postParams["recipientId"] = $request->recipient_id;
        if ($request->_text)
            $postParams["text"] = $request->_text;
        if (empty($postParams) || count($postParams) < 3) return response(null);
        $mess = $this->messInterface;
        $mess["to"] = (int) $postParams['recipientId'];
        $mess["from"] = (int) $postParams['id'];
        echo "<pre>";
        print_r($postParams['text']);
        echo "</pre>";
        $mess["text"] = self::messageTextFilter($postParams['text']);
        $status = Message::insert($mess);
        $mess['status'] = $status;


        return response()->json($mess);
    }
    static function messageTextFilter($text){

        $filterText = preg_replace('/[\r\n]+/', '<br>', $text);

        return $filterText;
    }
    public function dellMess(Request $request, Message $messages)
    {
        $postParams = [];

        if ($request->id)
            $postParams["id"] = $request->id;

        if (empty($postParams)) return response(null);

        $message = $messages->find($postParams["id"]);
        $message->enable = 0;
        $status = $message->save();
        $mess['status'] = $status;


        return response()->json($mess);
    }


    public function options()
    {
        return response('');

    }

}
