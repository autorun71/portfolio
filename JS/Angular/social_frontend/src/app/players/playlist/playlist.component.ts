import {Component, OnInit} from '@angular/core';
import {PlaylistService} from '../../services/player/playlist.service';
import {PlayerService} from '../../services/player/player.service';

@Component({
    selector: 'app-playlist',
    templateUrl: './playlist.component.html',
    styleUrls: ['./playlist.component.scss']
})
export class PlaylistComponent implements OnInit {


    constructor(private playlistService: PlaylistService, private player: PlayerService) {
    }

    ngOnInit() {

    }

    setTrack(id) {

        this.player.initPlay(id);
    }
}
