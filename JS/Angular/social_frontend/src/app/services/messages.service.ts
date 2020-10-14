import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {UserService} from './user.service';
import {Md5} from 'ts-md5/dist/md5';
import {of} from 'rxjs';

interface UserInfo {
    id: number;
    name: string;
    middle_name: string | null;
    last_name: string | null;
    email: string;
    status?: null | string;
    online?: null | number;
}

interface Dialogs {
    id: number;
    name: string;
    last_name: string;
    avatar: string;
    message: {
        id: number;
        sender: number;
        text: string;
        read_status: number;
        edit_status?: number;
        show_to?: number;
        show_from?: number;
        time?: string;
    };

}
interface Dialog {
    user: UserInfo;
    dialog: Dialogs[];

}
interface CheckMess {
    status: boolean;
    dialogs?: Dialogs[];
    messages?: string;
}

@Injectable({
    providedIn: 'root'
})
export class MessagesService {

    messages: Dialogs[];
    messagesTemp: Dialogs[];
    dialogList: Dialog;
    dialogListTemp: Dialog;
    messageGetInit = false;
    dialogId = null;

    constructor(
        private http: HttpClient,
        private user: UserService,
    ) {

        this.getDialogs()
            .then(() => {
                this.messageGetInit = true;
                this.checkMess();
            });
    }

    set dialogLists(mess) {
        this.dialogListTemp = mess;
        this.dialogFilter(mess);
    }

    set messagesList(mess) {
        this.messagesTemp = mess;
        this.messageFilter(mess);
    }

    messageFilter(mess) {
        this.messages = mess;
    }
    dialogFilter(mess) {
        this.dialogList = mess;
    }

    getDialogs() {
        return new Promise((res) => {
            this.http.get<Dialogs[]>('http://api.xccx.site/api/messages/dialogs/' + String(this.user.userInfo.id))
                .subscribe(e => {


                    if (e.length > 0) {
                        this.messagesList = e;

                    }
                    res(true);

                });
        });
    }

    getDialog() {
        return new Promise((res) => {
            if (this.dialogId && this.dialogId > 0) {
                this.http.get<Dialog>('http://api.xccx.site/api/messages/dialog/' + String(this.user.userInfo.id) + '/' + String(this.dialogId))
                    .subscribe(e => {


                        if (e.dialog.length > 0) {
                            this.dialogLists = e;

                        }
                        res(true);

                    });
            } else {
                res(false);
            }

        });
    }

    checkMess() {
        const dialogMd5 = this.dialog2Md5();
        this.http.get<CheckMess>('http://api.xccx.site/api/messages/ms/' + String(this.user.userInfo.id) + '?h=' + dialogMd5)
            .subscribe(e => {
                if (e.status) {
                    this.messagesList = e.dialogs;
                    this.getDialog()
                    this.newMessAudio();
                }
                this.checkMess();
            });
    }

    dialog2Md5() {
        const messArr = [];
        for (const mes of this.messagesTemp) {
            messArr.push(mes.message.id);
            messArr.push(mes.message.text);
            messArr.push(mes.message.edit_status);
            messArr.push(mes.message.read_status);
            messArr.push(mes.message.show_to);
            messArr.push(mes.message.show_from);
        }

        const md5 = new Md5();
        return md5.appendStr(messArr.join('')).end();
    }

    private newMessAudio() {
        const mes = new Audio();
        mes.src = '/assets/audio/mess.mp3';
        mes.play();
    }
}
