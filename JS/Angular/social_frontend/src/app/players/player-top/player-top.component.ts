import {Component, OnInit} from '@angular/core';
import {PlayerService} from '../../services/player/player.service';

@Component({
    selector: 'app-player-top',
    templateUrl: './player-top.component.html',
    styleUrls: ['./player-top.component.scss']
})
export class PlayerTopComponent implements OnInit {

    constructor(
        private player: PlayerService
    ) {
    }

    ngOnInit() {
    }

    play() {

        if (this.player.status) {
            this.player.pause();
            this.player.status = false;

        } else {
            this.player.play();
            this.player.status = true;


        }


    }

    next() {

    }

}
