import {Component, OnInit} from '@angular/core';
import {UserService} from '../services/user.service';
import {PlayerService} from '../services/player/player.service';

@Component({
    selector: 'app-header',
    templateUrl: './header.component.html',
    styleUrls: ['./header.component.scss']
})
export class HeaderComponent implements OnInit {


    constructor(private auth: UserService, private player: PlayerService) {
    }

    ngOnInit() {
    }

    playerShow() {
        setTimeout(() => {

            this.player.playerDisplay = !this.player.playerDisplay;

        }, 10);
        return false;
    }
}
