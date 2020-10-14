import {Component, ElementRef, HostListener, OnInit} from '@angular/core';
import {UserService} from '../../services/user.service';
import {PlayerService} from '../../services/player/player.service';
import {PlaylistService} from '../../services/player/playlist.service';
// import {HelperService} from '../../services/helper.service';
// import {stringify} from 'querystring';

// import Moment from './time';


interface Song {
    id: number;
    name: string;
    artist: string;
    duration?: number | string;

}


@Component({
    selector: 'app-player',
    templateUrl: './player.component.html',
    styleUrls: ['./player.component.scss']
})
export class PlayerComponent implements OnInit {
    song: Song;
    i: number;
    playlist;
    duration = this.player.duration;
    currentTime = this.player.currentTime;
    trackTime = this.player.trackTime;


    constructor(
        private auth: UserService,
        private player: PlayerService,
        private playlistService: PlaylistService,
        private eRef: ElementRef
    ) {


    }

    ngOnInit() {
        this.playlistService.getPlaylist()
            .then(() => {
                this.create();
            });
    }

    create() {
        if (!this.player.create && !this.player.initPlayStatus) {
            this.player.song = this.player.playlist[this.player.playTrackNumber];
            this.player.playTrackId = this.player.song.id;
            this.player.src = this.player.srcCreate(this.player.playTrackId);
            this.player.create = true;
            if (this.player.localCurrentTime > 0) {
                this.player.currentTime = this.player.localCurrentTime;
            }
        }
    }

    // init() {
    //     this.song = this.playlist[this.i];
    //     this.player.playTrackId = this.song.id;
    //     this.player.src = this.srcCreate(this.player.playTrackId);
    // }

    repeatTrack() {
        if (this.player.repeat === 2) {
            this.player.repeat = 0;
        } else {
            this.player.repeat++;
        }
    }

    trackTimeDirectChange() {
        this.player.trackTimeDirect = !this.player.trackTimeDirect;
        localStorage.setItem('trackTimeDirect', String(Number(this.player.trackTimeDirect)) + '||' + String(Math.random()));

    }

    monitor() {
        setInterval(() => {
            this.trackTime = this.player.trackTime;
        }, 200);
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

    stop() {
    }

    next() {
        this.player.next();
    }

    prev() {

        this.player.prev();
    }

    clickPolosa(e) {

        const elLeft = e.clientX - e.offsetX;
        const width = e.currentTarget.clientWidth;
        this.player.coord.left = elLeft;
        this.player.coord.width = width;
        this.player.coord.lenght = e.offsetX / width * 100;

        this.player.mouseDown.polosa = true;

    }




}
