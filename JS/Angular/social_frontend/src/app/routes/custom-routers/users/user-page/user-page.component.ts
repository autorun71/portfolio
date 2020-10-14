import {Component, OnInit} from '@angular/core';
import {UserService} from '../../../../services/user.service';
import {CustomRouterService} from '../../../../services/custom-router.service';
import {HttpClient} from '@angular/common/http';

interface UserInfo {
    id: number;
    name: string;
    email: string;
    middle_name?: string | null;
    last_name?: string | null;
    status?: null | string;
    online?: null | number;
}

@Component({
    selector: 'app-user-page',
    templateUrl: './user-page.component.html',
    styleUrls: ['./user-page.component.scss']
})
export class UserPageComponent implements OnInit {

    userInfo: UserInfo;
    authUserPage = false;
    userGetInfo = false;


    constructor(
        private user: UserService,
        private customRouts: CustomRouterService,
        private http: HttpClient
    ) {
    }

    ngOnInit() {
        this.userInfo = {
            id: null,
            name: null,
            email: null
        };
        if (this.user.userInfo.id === this.customRouts.route.queryParams.id) {
            this.authUserPage = true;
            this.userInfo = this.user.userInfo;
            this.userGetInfo = true;
        } else {
            this.http.get<UserInfo[]>('http://api.xccx.site/api/user/' + this.customRouts.route.queryParams.id)
                .subscribe(e => {

                    if (e.length === 1) {
                        this.userGetInfo = true;
                        this.userInfo = e[0];
                    }
                });
        }
    }

}
