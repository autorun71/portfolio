import {NgModule} from '@angular/core';
import {Routes, RouterModule} from '@angular/router';
import {BrowserModule} from '@angular/platform-browser';
import {HeaderComponent} from '../header/header.component';
import {AuthComponent} from './auth/auth.component';
import {LoginComponent} from './login/login.component';
import {RegisterComponent} from './register/register.component';
import {AboutComponent} from './about/about.component';
import {AuthGuard} from '../auth.guard';
import {LogoutComponent} from './logout/logout.component';
import {MusicComponent} from './music/music.component';
import {MessagesComponent} from './messages-routers/messages/messages.component';
import {CustomRouterComponent} from './custom-routers/custom-router/custom-router.component';


const routes: Routes = [
    {path: 'login', component: LoginComponent},
    {path: 'register', component: RegisterComponent},
    {
        path: '', component: AuthComponent, canActivate: [AuthGuard], children: [

            {path: '', component: AboutComponent},
            {path: 'logout', component: LogoutComponent},
            {path: 'music', component: MusicComponent},
            {path: 'im', component: MessagesComponent},
            {path: '**', component: CustomRouterComponent}
        ]
    },

];

@NgModule({
    imports: [BrowserModule, RouterModule.forRoot(routes)],
    exports: [RouterModule]
})
export class AppRoutingModule {
}
