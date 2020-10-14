import {Component, OnInit} from '@angular/core';
import {FormControl, FormGroup, Validators} from '@angular/forms';
import {HttpClient} from '@angular/common/http';
import {UserService} from '../../services/user.service';
import {Router} from '@angular/router';

interface User {
    access_token: string;
}

@Component({
    selector: 'app-login',
    templateUrl: './login.component.html',
    styleUrls: ['./login.component.scss']
})

export class LoginComponent implements OnInit {

    title = 'Вход';
    login = false;
    loginForm: FormGroup;


    constructor(private http: HttpClient, private user: UserService, private router: Router) {

    }

    ngOnInit() {


        this.loginForm = new FormGroup({
            email: new FormControl('emaa@mail.ruq', [
                Validators.required,
                Validators.email

            ]),
            password: new FormControl('user1', [
                Validators.required
            ])
        });
    }


    onSubmit() {
        if (this.loginForm.valid) {
            const sign = this.loginForm.value;
            this.http.post<User>('http://api.xccx.site/api/login', sign)
                .subscribe(resp => {
                    this.user.accessToken = resp.access_token;

                    this.user.validToken().then(e => {
                        if (e) {
                            this.router.navigateByUrl('');
                        }
                    });
                });



        }

    }
}
