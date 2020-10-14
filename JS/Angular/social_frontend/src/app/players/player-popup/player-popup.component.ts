import {Component, ElementRef, HostListener, OnInit} from '@angular/core';
import {UserService} from '../../services/user.service';
import {PlayerService} from '../../services/player/player.service';
import {PlaylistService} from '../../services/player/playlist.service';

@Component({
    selector: 'app-player-popup',
    templateUrl: './player-popup.component.html',
    styleUrls: ['./player-popup.component.scss']
})
export class PlayerPopupComponent implements OnInit {

    constructor(
        // private auth: UserService,
        private player: PlayerService,
        // private playlistService: PlaylistService,
        private eRef: ElementRef
    ) {
    }

    ngOnInit() {
    }

    @HostListener('document:click', ['$event'])
    clickOut(event) {
        const playerShow = document.getElementById('playerShow');

        if (this.eRef.nativeElement.contains(event.target)) {

        } else {
            if (playerShow !== event.target) {
                this.player.playerDisplay = false;
            }

        }
    }
}
