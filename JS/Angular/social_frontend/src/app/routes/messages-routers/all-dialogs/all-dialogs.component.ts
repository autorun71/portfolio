import { Component, OnInit } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {UserService} from '../../../services/user.service';
import {MessagesService} from '../../../services/messages.service';
import {ActivatedRoute} from '@angular/router';

@Component({
  selector: 'app-all-dialogs',
  templateUrl: './all-dialogs.component.html',
  styleUrls: ['./all-dialogs.component.scss']
})
export class AllDialogsComponent implements OnInit {

  constructor(
      private http: HttpClient,
      private user: UserService,
      private messagesService: MessagesService,
  ) {

    this.messagesService.getDialogs().then();
  }

  ngOnInit() {
  }

}
