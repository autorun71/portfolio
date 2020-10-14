import {Component, OnInit} from '@angular/core';
import {Router} from '@angular/router';
import {customRoutes} from './routes';
import {UserService} from '../../../services/user.service';
import {CustomRouterService} from '../../../services/custom-router.service';


@Component({
    selector: 'app-custom-router',
    templateUrl: './custom-router.component.html',
    styleUrls: ['./custom-router.component.scss']
})
export class CustomRouterComponent implements OnInit {

    url = this.router.url.trim();

    route = {
        name: null,
        condition: null,
        params: null,
        queryParams: null
    };

    constructor(
        private router: Router,
        private user: UserService,
        private customRouts: CustomRouterService
    ) {
    }

    ngOnInit() {
        this.cleanUrl();
        this.getRouts();


    }

    getRouts() {
        for (const i in customRoutes) {
            const customRoute = customRoutes[i];
            const match = this.url.match(customRoute.condition);
            if (match && match.length > 0) {
                this.route.name = customRoute.name;
                this.route.condition = customRoute.condition;
                this.route.params = customRoute.params;
                this.route.queryParams = {};
                for (const ii in customRoute.params) {
                    this.route.queryParams[customRoute.params[ii]] = Number(match[Number(ii) + 1]);
                }
                break;
            }

        }
        this.customRouts.route = this.route;

    }

    cleanUrl() {
        const length = this.url.length - 1;
        if (this.url[length] === '/') {
            this.url = this.url.substring(0, length);

        }
        if (this.url[0] === '/') {
            this.url = this.url.substring(1);
        }
    }

}
