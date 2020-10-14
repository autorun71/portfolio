import {Component, HostListener, OnInit} from '@angular/core';
import {UserService} from './services/user.service';
import {PlayerService} from './services/player/player.service';

@Component({
    selector: 'app-root',
    templateUrl: './app.component.html',
    styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit {
    title = 'social';

    constructor(private auth: UserService, private player: PlayerService) {
        if (!this.auth.isAuth) {

            this.auth.validToken();

        }
    }

    ngOnInit(): void {


    }

    @HostListener('mousemove', ['$event'])
    onMousemove(event: MouseEvent) {
        if (this.player.mouseDown.polosa) {
            let coordX = event.screenX;
            const width = this.player.coord.width;
            const left = this.player.coord.left;
            if (coordX < left) {
                coordX = left;
            } else if (coordX > left + width) {
                coordX = left + width;
            }
            const pos = coordX - left;
            this.player.coord.lenght = pos / width * 100;

        }
    }

    @HostListener('mouseup', ['$event'])
    onMouseup(event) {
        if (this.player.mouseDown.polosa) {

            this.player.currentTime = this.player.duration * this.player.coord.lenght / 100;
            this.player.mouseDown.polosa = false;
        }


    }
}
