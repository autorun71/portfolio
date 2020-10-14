import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';

interface TokenValid {
    valid: any;
    user: any;
}

interface UserInfo {
    id: number;
    name: string;
    middle_name: string | null;
    last_name: string | null;
    email: string;
    status?: null | string;
    online?: null | number;
}

@Injectable({
    providedIn: 'root'
})
export class UserService {
    validCheck = false;
    userToken: string;
    isAuth = false;

    userInfo: UserInfo = {
        id: null,
        name: null,
        middle_name: null,
        last_name: null,
        email: null,
        status: null,
        online: 0,
    };

    constructor(private http: HttpClient) {
    }

    set accessToken(token) {
        document.cookie = 'access_token=' + token;
        this.userToken = token;
    }

    get accessToken() {

        if (this.getCookie('access_token') && !this.userToken) {
            this.userToken = this.getCookie('access_token');

        }
        return this.userToken;

    }

    validToken() {

        return new Promise(resolve => {
                // if (this.accessToken) {
                if (this.isAuth) {
                    return resolve(true);
                }
                this.http.get<TokenValid>('http://api.xccx.site/api/is_valid_token', {
                    headers: {Authorization: 'Bearer ' + this.accessToken},
                })
                    .subscribe(resp => {


                            this.validCheck = true;
                            if (resp.valid) {
                                this.isAuth = true;
                                resolve(true);
                            }

                            if (resp.user) {
                                this.userInfo = resp.user;
                            }
                        },
                        error1 => {
                            this.validCheck = true;
                            resolve(false);

                        });


                // } else {
                //     resolve(false);
                // }
            }
        );


    }

    logout() {
        this.accessToken = '';
        this.isAuth = false;


    }

    getCookie(name) {
        const value = '; ' + document.cookie;
        const parts = value.split('; ' + name + '=');
        if (parts.length === 2) {
            return parts.pop().split(';').shift();
        }
    }
}
