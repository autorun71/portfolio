import {Component, Input, OnInit} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {UserService} from '../../../services/user.service';
import {MessagesService} from '../../../services/messages.service';

@Component({
    selector: 'app-dialog-messages',
    templateUrl: './dialog-messages.component.html',
    styleUrls: ['./dialog-messages.component.scss']
})
export class DialogMessagesComponent implements OnInit {

    @Input() dialogId: number;


    constructor(
        private http: HttpClient,
        private user: UserService,
        private messagesService: MessagesService,
    ) {
    }

    ngOnInit() {
        this.messagesService.getDialog()
            .then();
    }

}
