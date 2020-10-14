import {Injectable} from '@angular/core';
import {PlaylistService} from './playlist.service';
import {UserService} from '../user.service';
import {HelperService} from '../helper.service';

interface MouseDown {
    polosa: boolean;
}

@Injectable({
    providedIn: 'root'
})
export class PlayerService {

    audio = new Audio();
    status = false;
    playTrackId = 0;
    create = false;
    playTrackNumber = 0;
    song = {
        id: null,
        artist: null,
        name: null,
        duration: null
    };
    playlist;
    countMusic = 0;
    repeat = 1;
    mouseDown: MouseDown = {
        polosa: false
    };
    coord = {
        width: 0,
        left: 0,
        lenght: 0,
    };
    trackTime;
    poloska = 0;
    trackTimeDirect = false;
    localCurrentTime = 0;
    localId = 0;
    playerDisplay = false;
    initPlayStatus = false;

    constructor(private playlistService: PlaylistService, private auth: UserService, private hh: HelperService) {
        const localIdTemp = localStorage.getItem('play');
        if (localIdTemp) {
            this.localId = Number(localIdTemp.split('||')[0]);
        } else {
            this.localId = 0;
        }

        const trackTimeDirectTemp = localStorage.getItem('trackTimeDirect');
        if (trackTimeDirectTemp) {
            this.trackTimeDirect = Boolean(Number(trackTimeDirectTemp.split('||')[0]));
        }

        const localCurrentTime = localStorage.getItem('currentTime');
        if (localCurrentTime) {
            this.localCurrentTime = Number(localCurrentTime.split('||')[0]);
        } else {
            this.localCurrentTime = 0;
        }


        this.playlistService.getPlaylist()
            .then(e => {
                this.playlist = e;
                this.monitor();
                this.countMusic = this.playlist.length;
                if (this.localId > 0) {

                    this.init(this.localId);

                }

                if (this.localCurrentTime > 0) {
                    this.audio.currentTime = this.localCurrentTime;
                }


            });

        window.addEventListener('storage', (e) => {
            switch (e.key) {
                // case 'currentTime':
                //     this.loadCurTime = Number(e.newValue.split('||')[0])
                //     if (!this.status) {
                //         this.audio.currentTime = this.loadCurTime
                //     }
                //     break;
                case 'play':
                    this.pause();
                    // const newTrack = e.newValue.split('||')[0];
                    // if (this.song && newTrack !== this.song.id) {
                    //     this.init(Number(newTrack));
                    // }
                    break;

                case 'default':

                    break;
            }
        });
    }

    monitor() {
        setInterval(() => {


            if (!this.mouseDown.polosa) {
                this.poloska = this.widthPolosa;
            } else {
                this.poloska = this.coord.lenght;
            }
            if (this.audio.duration && this.audio.currentTime) {
                if (this.trackTimeDirect) {
                    this.trackTime = this.hh.timeToStr(this.audio.currentTime, ':', false);
                } else {
                    this.trackTime = '-' + this.hh.timeToStr(this.audio.duration - this.audio.currentTime, ':', false);
                }
            } else {
                this.trackTime = '00:00';
            }
            localStorage.setItem('currentTime', String(this.currentTime) + '||' + String(Math.random()));
            if (this.currentTime === this.duration) {
                if (this.repeat === 2) {
                    this.autoInit();
                } else {
                    if (this.nextStatus() || this.repeat === 1) {
                        this.next();
                    } else {
                        this.pause();
                    }

                }

            }
        }, 30);
    }

    set src(src) {
        this.audio.src = src;
    }

    get duration() {
        return this.audio.duration;
    }

    get widthPolosa() {
        return this.currentTime / this.duration * 100;
    }

    get currentTime() {
        return this.audio.currentTime;
    }

    set currentTime(currentTime) {

        this.audio.currentTime = currentTime;
    }

    init(id) {
        for (let k in this.playlist) {

            if (this.playlist[k].id === id) {
                this.song = this.playlist[k];
                this.playTrackNumber = Number(k);

                break;
            }

        }

        this.playTrackId = this.song.id;
        this.src = this.srcCreate(this.playTrackId);


    }

    autoInit() {
        this.song = this.playlist[this.playTrackNumber];
        this.playTrackId = this.song.id;
        this.src = this.srcCreate(this.playTrackId);
        if (this.status) {
            this.play();
        }
    }

    initPlay(id) {
        this.pause();
        this.init(id);
        this.play();
    }

    srcCreate(id: number): string {
        return '//api.xccx.site/api/audio.mp3?t=' + btoa(this.auth.accessToken) + '&i=' + btoa(id.toString());
    }

    play() {
        this.initPlayStatus = true;
        localStorage.setItem('play', String(this.song.id) + '||' + String(Math.random()));

        this.status = true;
        this.audio.play();
    }

    pause() {

        this.status = false;
        this.audio.pause();
    }

    next() {
        if (this.nextStatus()) {
            this.playTrackNumber++;
            this.autoInit();
        } else {
            if (this.repeat === 1 || this.repeat === 2) {
                this.playTrackNumber = 0;
                this.autoInit();
            }
        }
    }

    nextStatus() {
        if (this.playTrackNumber + 1 < this.countMusic) {
            return true;
        } else {
            return false;
        }
    }

    prev() {
        if (this.prevStatus()) {
            this.playTrackNumber--;
            this.autoInit();
        } else {
            if (this.repeat === 1 || this.repeat === 2) {
                this.playTrackNumber = this.playlist.length - 1;

                this.autoInit();
            }
        }
    }

    prevStatus() {

        if (this.playTrackNumber - 1 >= 0) {
            return true;
        } else {
            return false;
        }
    }


}
