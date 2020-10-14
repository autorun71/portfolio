import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {resolve} from 'q';

@Injectable({
    providedIn: 'root'
})
export class PlaylistService {
    playlistUrl = 'http://api.xccx.site/api/playlist';
    playlists;

    constructor(private http: HttpClient) {
    }

    get(url = '') {
        if (!url) {
            url = this.playlistUrl;
        }
        return new Promise((resolve) => {

            this.http.get(url)
                .subscribe(e => {

                    this.playlists = e;
                    resolve(e);
                });
        });

    }

    getPlaylist(i = 0) {
        if (!this.playlists || this.playlists.length === 0) {
            return this.get();
        } else {
            return new Promise(resolve => {

                resolve(this.playlists);
            });
        }
    }
}
