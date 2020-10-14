import {Component, OnInit} from '@angular/core';
import {UserService} from '../../services/user.service';
import {Router} from '@angular/router';

@Component({
    selector: 'app-logout',
    templateUrl: './logout.component.html',
    styleUrls: ['./logout.component.scss']
})
export class LogoutComponent implements OnInit {

    constructor(private auth: UserService, private router: Router) {
    }

    ngOnInit() {
        this.auth.logout();
        this.router.navigateByUrl('login');
    }

}
