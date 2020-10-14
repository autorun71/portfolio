import {Component, OnInit} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {UserService} from '../../../services/user.service';
import {MessagesService} from '../../../services/messages.service';
import {ActivatedRoute, Router} from '@angular/router';

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

interface QueryParam {
    peers: string;
    tab: string;
}

@Component({
    selector: 'app-messages',
    templateUrl: './messages.component.html',
    styleUrls: ['./messages.component.scss']
})
export class MessagesComponent implements OnInit {

    oneDialog = false;
    important = false;
    notRead = false;
    dialogId = null;


    constructor(
        private http: HttpClient,
        private user: UserService,
        private messagesService: MessagesService,
        private router: ActivatedRoute,
    ) {

        router.queryParams.subscribe(
            (queryParam: QueryParam) => {
                if (queryParam.peers) {
                    this.oneDialog = true;
                    this.messagesService.dialogId = Number(queryParam.peers);
                } else {
                    this.oneDialog = false;
                    this.messagesService.dialogId = 0;
                }
                if (queryParam.tab && queryParam.tab === 'unread') {
                    this.messagesService.messageFilter = (mess) => {
                        this.messagesService.messages = mess.filter(e => e.message.sender === 0 && e.message.read_status === 0);

                    };
                    this.notRead = true;
                    this.messagesService.getDialogs().then();


                } else {
                    this.messagesService.getDialogs().then();
                    this.notRead = false;
                    this.messagesService.messageFilter = (mess) => {
                        this.messagesService.messages = mess;

                    };
                }

            }
        );

    }

    ngOnInit() {
    }


}
