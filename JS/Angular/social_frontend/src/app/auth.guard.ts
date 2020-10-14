import {ActivatedRouteSnapshot, CanActivate, Router, RouterStateSnapshot} from '@angular/router';
import {Observable} from 'rxjs';
import {Injectable} from '@angular/core';
import {UserService} from './services/user.service';

@Injectable({providedIn: 'root'})
export class AuthGuard implements CanActivate {

    constructor(
        private auth: UserService,
        private router: Router
    ) {
    }

    canActivate(
        route: ActivatedRouteSnapshot,
        state: RouterStateSnapshot
    ): Observable<any> | Promise<any> | any {

        return this.auth.validToken().then((e) => {

            if (e) {
                return true;
            } else {
                this.router.navigate(['/login'], {
                    queryParams: {
                        auth: false
                    }
                });
            }
        });
    }
}
